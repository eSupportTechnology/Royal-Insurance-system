<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\ContactMail;
use App\Models\Company;
use App\Models\Customer;
use App\Models\MailRequest;
use App\Models\Motor;
use App\Models\Quatation;
use App\Models\QuatationOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class MotorsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function notsend()
{
    $motors = Motor::where('status', 'Not send')->get();

    return view('motors.index', compact('motors'));
}


    public function send()
    {
        $motors = Motor::where('status', 'Send')->get();
        return view('motors.send', compact('motors'));
    }

    public function quatationreport($id){

        $motor = Motor::findOrFail($id);
        $companies = Company::all();
        return view('motors.quatation', compact('motor','companies'));
    }
    public function quatationreportstore(Request $request, $id)
    {
        $request->validate([
            'insurance_company_id' => 'required|exists:companies,id',
            'package_name' => 'required|array',
            'package_name.*' => 'required|string|max:255',
            'package_type' => 'required|array',
            'package_type.*' => 'required|string|max:255',
            'required' => 'sometimes|array',
            'required.*' => 'nullable|boolean',
            'field_options' => 'nullable|array',
            'field_options.*' => 'nullable|string|max:255',
        ], [
            'insurance_company_id.required' => 'Please select a valid insurance company.',
            'package_name.*.required' => 'Each package name is required.',
            'package_type.*.required' => 'Each package type is required.',
        ]);

        // Use transaction for data consistency
        DB::transaction(function () use ($request) {
            foreach ($request->package_name as $index => $packageName) {
                $quotation = Quatation::create([
                    'insurance_company_id' => $request->insurance_company_id,
                    'package_name' => trim($packageName),
                    'package_type' => $request->package_type[$index],
                    'required' => isset($request->required[$index]) ? 1 : 0,
                ]);

                if (in_array($quotation->package_type, ['select', 'checkbox']) && isset($request->field_options[$index])) {
                    $options = explode(',', $request->field_options[$index]);
                    foreach ($options as $option) {
                        QuatationOption::create([
                            'quotation_id' => $quotation->id,
                            'option_value' => trim($option),
                        ]);
                    }
                }
            }
        });

        return redirect()->route('sendindex')->with('success', 'Form Fields created successfully.');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::all();
        return view('motors.create', compact('customers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $validated = $request->validate([
        'make' => 'required|string',
        'model' => 'required|string',
        'year' => 'required|numeric',
        'vehicle_number' => 'required|string|unique:motors,vehicle_number',
        'class' => 'required|string',
        'usage' => 'required|string',
        'vehicle_value' => 'required|numeric',
        'financial_interest' => 'nullable|string',
        'fuel_type' => 'required|string',
        'customer_id' => 'required|exists:customers,id', // Ensure valid customer
    ]);

    // Fetch customer details and store them in the motors table
    $customer = Customer::findOrFail($request->customer_id);

    $data = array_merge($validated, [
        'email' => $customer->email,
        'phone' => $customer->phone,
        'nic' => $customer->nic,
        'address' => $customer->address,
    ]);

    // Handle file uploads
    foreach (['vehicle_copy', 'id_copy', 'renewal_copy', 'vehical_pic', 'client_letter', 'other_doc'] as $fileField) {
        if ($request->hasFile($fileField)) {
            $files = [];
            foreach ($request->file($fileField) as $file) {
                $files[] = $file->store('uploads', 'public');
            }
            $data[$fileField] = json_encode($files);
        }
    }

    // Store everything in motors table
    Motor::create($data);

    return redirect()->route('indexxx')->with('success', 'Motor insurance data added successfully.');
}

public function edit($id)
{
    $motor = Motor::findOrFail($id);
    $customers = Customer::all(); // Fetch all customers for dropdown

    return view('motors.edit', compact('motor', 'customers'));
}


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    // Validate input data
    $validated = $request->validate([
        'make' => 'required|string',
        'model' => 'required|string',
        'year' => 'required|numeric',
        'vehicle_number' => "required|string|unique:motors,vehicle_number,{$id}",
        'class' => 'required|string',
        'usage' => 'required|string',
        'vehicle_value' => 'required|numeric',
        'financial_interest' => 'nullable|string',
        'fuel_type' => 'required|string',
        'customer_id' => 'required|exists:customers,id',
        'status' => 'required|string|in:Not send,Send',
        'other_details' => 'nullable|string',

        // File validation
        'vehicle_copy.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
        'id_copy.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
        'renewal_copy.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
        'vehical_pic.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
        'client_letter.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
        'other_doc.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
    ]);

    // Fetch the motor record
    $motor = Motor::findOrFail($id);

    // Fetch customer details and update them in motors table
    $customer = Customer::findOrFail($validated['customer_id']);
    $validated['email'] = $customer->email;
    $validated['phone'] = $customer->phone;
    $validated['nic'] = $customer->nic;
    $validated['address'] = $customer->address;

    // Handle file uploads (append new files & remove old ones)
    foreach (['vehicle_copy', 'id_copy', 'renewal_copy', 'vehical_pic', 'client_letter', 'other_doc'] as $fileField) {
        $existingFiles = json_decode($motor->$fileField, true) ?? [];

        // Remove selected files
        if ($request->filled("remove_{$fileField}")) {
            foreach ($request->input("remove_{$fileField}") as $fileToRemove) {
                if (($key = array_search($fileToRemove, $existingFiles)) !== false) {
                    unset($existingFiles[$key]);
                    Storage::disk('public')->delete($fileToRemove); // Delete the file from storage
                }
            }
        }

        // Add new files
        if ($request->hasFile($fileField)) {
            foreach ($request->file($fileField) as $file) {
                $existingFiles[] = $file->store('uploads', 'public');
            }
        }

        $validated[$fileField] = json_encode(array_values($existingFiles)); // Reindex array
    }

    // Update motor record
    $motor->update($validated);

    return redirect()->route('indexxx')->with('success', 'Motor insurance data updated successfully.');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, Motor $motor)
    {
        $motor = Motor::findOrFail($id);
        $motor->delete();

        return redirect()->route('indexxx')->with('success', 'Motor insurance detail deleted successfully.');
    }

    public function mail($id)
    {
        $motors = Motor::findOrFail($id);
        $companies = Company::where('status', 1)->get();
        $customers = Customer::all();
        return view('motors.mail', compact('motors','companies','customers'));
    }

    public function storeMail(Request $request, $id)
    {
        // Validate the input
        $request->validate([
            'company_id'     => 'required|string',
            'company_email'  => ['required', 'string', function ($attribute, $value, $fail) {
                $emails = explode(',', $value);
                foreach ($emails as $email) {
                    if (!filter_var(trim($email), FILTER_VALIDATE_EMAIL)) {
                        $fail('The ' . $attribute . ' must contain valid email addresses.');
                    }
                }
            }],
            'make'           => 'required|string',
            'year'           => 'required|numeric',
            'vehicle_number' => 'required|string',
            'usage'          => 'required|string',
            'vehicle_value'  => 'required|numeric',
            'financial_interest' => 'required|string',
            'fuel_type'      => 'required|string',
            'customer_id'    => 'required|string',
            'email'          => 'required|string',
            'phone'          => 'required|string',
            'nic'            => 'required|string',
            'address'        => 'required|string',
        ]);

        // Save the mail request in the database
        $recode = MailRequest::create([
            'company_id'     => $request->company_id,
            'company_email'  => $request->company_email,
            'make'           => $request->make,
            'year'           => $request->year,
            'vehicle_number' => $request->vehicle_number,
            'usage'          => $request->usage,
            'vehicle_value'  => $request->vehicle_value,
            'financial_interest' => $request->financial_interest,
            'fuel_type'      => $request->fuel_type,
            'customer_id'    => $request->customer_id,
            'email'          => $request->email,
            'phone'          => $request->phone,
            'nic'            => $request->nic,
            'address'        => $request->address,
        ]);

        // Prepare email data
        $customer = Customer::find($request->customer_id);
        $customer_name = $customer ? $customer->name : 'Unknown Customer';
        $data = [
            'company_id'     => $request->company_id,
            'company_email'  => $request->company_email,
            'make'           => $request->make,
            'year'           => $request->year,
            'vehicle_number' => $request->vehicle_number,
            'usage'          => $request->usage,
            'vehicle_value'  => $request->vehicle_value,
            'financial_interest' => $request->financial_interest,
            'fuel_type'      => $request->fuel_type,
            'customer_id'    => $customer_name,
            'email'          => $request->email,
            'phone'          => $request->phone,
            'nic'            => $request->nic,
            'address'        => $request->address,
            'date'           => now()->format('Y-m-d'),
        ];

        // Send the email and update the motor's status
        try {
            $emails = explode(',', $request->company_email);
            foreach ($emails as $email) {
                Mail::to(trim($email))->send(new ContactMail($data));
            }

            // Update motor status to "Send"
            $motor = Motor::findOrFail($id);
            $motor->update(['status' => 'Send']);

            return redirect()->route('indexxx')->with('success', 'Motor request sent successfully.');
        } catch (\Exception $e) {
            return redirect()->route('indexxx')->with('error', 'Failed to send motor request. Please try again.');
        }
    }


public function viewRequest(){

    $requests = MailRequest::with('customer')->get();
    return view('CustomerRequest.index', compact('requests'));
}



}
