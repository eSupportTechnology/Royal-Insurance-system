<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Customer;
use App\Models\CustomerResponse;
use App\Models\CustomerResponseField;
use App\Models\FormField;
use App\Models\InsuranceType;
use App\Models\Category;
use App\Models\Company;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\QuotationRequestMail;
use Illuminate\Support\Facades\Storage;

class CustomerResponseController extends Controller
{
    public function create()
{
    $agents = Agent::select('id', 'name')->get();
    $customers = Customer::select('id', 'name')->get();
    $insurance_types = InsuranceType::all();
    $categories = Category::all();
    $subcategories = SubCategory::all();
    $formFields = FormField::with('options')->get();

    return view('customerResponse.create', compact('agents', 'customers', 'insurance_types', 'categories', 'subcategories', 'formFields'));
}




    public function getFormFields(Request $request)
    {
        $typeId = $request->insurance_type_id;
        $categoryId = $request->category_id;
        $subCategoryId = $request->sub_category_id;

        $query = FormField::with('options')
            ->where('insurance_type_id', $typeId)
            ->where('category_id', $categoryId);

        // Only filter by sub_category_id if it's provided
        if ($subCategoryId) {
            $query->where(function($q) use ($subCategoryId) {
                $q->whereNull('sub_category_id')->orWhere('sub_category_id', $subCategoryId);
            });
        } else {
            $query->whereNull('sub_category_id');
        }

        $formFields = $query->get();

        return response()->json($formFields);
    }



    public function store(Request $request)
    {
        $request->validate([
            'agent_id' => 'required|exists:agents,id',
            'customer_id' => 'required|exists:customers,id',
            'insurance_type_id' => 'required|exists:insurance_types,id',
            'category_id' => 'required|exists:categories,id',
            'sub_category_id' => 'nullable|exists:sub_categories,id',
            'responses' => 'required|array',
            'status' => 'nullable|string',
            'date' => 'nullable|date',
        ]);

        // Retrieve customer details from the Customer table
        $customer = Customer::findOrFail($request->customer_id);

        // Create the customer response record
        $customerResponse = CustomerResponse::create([
            'agent_id' => $request->agent_id,
            'insurance_type_id' => $request->insurance_type_id,
            'category_id' => $request->category_id,
            'sub_category_id' => $request->sub_category_id,
            'customer_name' => $customer->name,
            'customer_email' => $customer->email,
            'customer_phone' => $customer->phone,
            'status' => $request->status ?? 'Pending',
            'date' => $request->date ?? now()->toDateString(),
        ]);

        // Save individual form field responses
        foreach ($request->responses as $fieldId => $response) {
            $field = FormField::find($fieldId);

            if ($field && $field->field_type === 'file' && $request->hasFile("responses.$fieldId")) {
                $file = $request->file("responses.$fieldId");
                $path = $file->store('uploads/files', 'public'); // Save in storage/app/public/uploads/files
                $finalValue = $path;
            } else {
                $finalValue = is_array($response) ? implode(', ', $response) : $response;
            }

            CustomerResponseField::create([
                'customer_response_id' => $customerResponse->id,
                'form_field_id' => $fieldId,
                'response' => $finalValue,
            ]);
        }


        return redirect()->route('indexxx')->with('success', 'Customer response saved successfully.');
    }

    public function edit($id)
{
    $response = CustomerResponse::with(['responseFields.formField.options', 'agent', 'customer'])->findOrFail($id);
// dd([
//         'response_id' => $response->id,
//         'agent_id' => $response->agent_id,
//         'customer_id' => $response->customer_id,
//         'customer_relationship' => $response->customer,
//         'customer_name' => $response->customer->name ?? 'NOT FOUND',
//         'agent_name' => $response->agent->name ?? 'NOT FOUND'
//     ]);
    $agents = Agent::select('id', 'name')->get();
    $customers = Customer::select('id', 'name')->get();
    $insurance_types = InsuranceType::all();
    $categories = Category::all();
    $subcategories = SubCategory::all();

    return view('customerResponse.edit', compact('response', 'agents', 'customers', 'insurance_types', 'categories', 'subcategories'));
}


    public function update(Request $request, $id)
    {
        $request->validate([
            'agent_id' => 'required|exists:agents,id',
            'customer_id' => 'required|exists:customers,id',
            'insurance_type_id' => 'required|exists:insurance_types,id',
            'category_id' => 'required|exists:categories,id',
            'sub_category_id' => 'nullable|exists:sub_categories,id',
            'responses' => 'required|array',
            'status' => 'nullable|string',
            'date' => 'nullable|date',
        ]);

        $customer = Customer::findOrFail($request->customer_id);

        // Update main response
        $response = CustomerResponse::findOrFail($id);
        $response->update([
            'agent_id' => $request->agent_id,
            'insurance_type_id' => $request->insurance_type_id,
            'category_id' => $request->category_id,
            'sub_category_id' => $request->sub_category_id,
            'customer_name' => $customer->name,
            'customer_email' => $customer->email,
            'customer_phone' => $customer->phone,
            'status' => $request->status ?? 'Pending',
            'date' => $request->date ?? now()->toDateString(),
        ]);

        // Loop through and update each response field
        foreach ($request->responses as $fieldId => $input) {
            $formField = FormField::find($fieldId);
            if (!$formField) continue;

            // Fetch existing response record
            $responseField = CustomerResponseField::where('customer_response_id', $response->id)
                ->where('form_field_id', $fieldId)
                ->first();

            $value = '';

            // Handle file upload
            if ($formField->field_type === 'file' && $request->hasFile("responses.$fieldId")) {
                // Delete old file if exists
                if ($responseField && $responseField->response && Storage::disk('public')->exists($responseField->response)) {
                    Storage::disk('public')->delete($responseField->response);
                }

                $file = $request->file("responses.$fieldId");
                $value = $file->store('uploads/files', 'public');
            } else {
                $value = is_array($input) ? implode(', ', $input) : $input;
            }

            // Update or create the field record
            if ($responseField) {
                $responseField->update(['response' => $value]);
            } else {
                CustomerResponseField::create([
                    'customer_response_id' => $response->id,
                    'form_field_id' => $fieldId,
                    'response' => $value,
                ]);
            }
        }

        return redirect()->route('indexxx', $response->id)
            ->with('success', 'Customer response updated successfully.');
    }

    public function mailForm($id)
    {
        $response = CustomerResponse::with('responseFields.formField')->findOrFail($id);
        $companies = Company::where('status', 1)->get(); // Assuming you have a model/table for this

        return view('customerResponse.mail', compact('response', 'companies'));
    }


    public function sendQuotationMail(Request $request)
    {
        $request->validate([
            'customer_response_id' => 'required|exists:customer_responses,id',
            'companies' => 'required|array',
            'companies.*' => 'email',
        ]);

        $response = CustomerResponse::with('responseFields.formField')->findOrFail($request->customer_response_id);

        $mailData = [
            'date' => now()->format('F j, Y'),
            'company_name' => 'Insurance Company', // optional: map email to name if needed
            'email' => implode(', ', $request->companies)
        ];

        // Send email
        Mail::to('kavidumalshankulathunga@gmail.com') // required "To"
            ->bcc($request->companies)
            ->send(new QuotationRequestMail($mailData, $response->responseFields));

        $response->status = 'Sent';
        $response->save();

        return redirect()->route('sendindex')->with('success', 'Quotation email sent to selected companies.');
    }







}
