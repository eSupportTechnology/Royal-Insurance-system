<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerResponse;
use App\Models\FormField;
use App\Models\SubCategory;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $responses = CustomerResponse::with(['customer', 'subcategory', 'field'])->get();
        return view('Customer_responses.index', compact('responses'));
    }

    // Show form to create a new response
    public function create(Request $request)
    {

        if ($request->ajax() && $request->has('sub_category_id')) {
            $fields = FormField::where('sub_category_id', $request->sub_category_id)->get();
            return response()->json($fields);
        }

        $customers = Customer::all();
        $subcategories = SubCategory::all();
        return view('Customer_responses.create', compact('subcategories', 'customers'));
    }

    // Store the submitted response
    public function store(Request $request)
    {
        $request->validate([
            'sub_category_id' => 'required|exists:sub_categories,id',
            'customer_id' => 'required|exists:customers,id',
            'responses' => 'nullable|array',
            'responses.*.field_id' => 'required|exists:form_fields,id',
            'responses.*.value' => 'nullable|string' // Allow NULL values
        ]);

        foreach ($request->responses as $response) {
            if (!empty($response['value'])) { // Only insert if value is not empty
                CustomerResponse::create([
                    'sub_category_id' => $request->sub_category_id,
                    'customer_id' => $request->customer_id,
                    'field_id' => $response['field_id'],
                    'value' => $response['value'],
                ]);
            }
        }

        return redirect()->route('customerResponses.index')->with('success', 'Responses saved successfully.');
    }


    // Delete response
    public function destroy($id)
    {
        CustomerResponse::findOrFail($id)->delete();
        return redirect()->route('customerResponses.index')->with('success', 'Response deleted successfully.');
    }

    // create a new customer

    public function newCustomer()
    {
        $newcustomers = Customer::all();
        return view('Customer.index', compact('newcustomers'));
    }

    public function createCustomer()
    {

        return view('Customer.create')->with('success', 'Customer created successfully.');
    }

    public function storeCustomer(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'nic' => 'required',
            'address' => 'required',

        ]);

        Customer::create($request->all());
        return redirect()->route('new-customer')->with('success', 'Customer created successfully.');
    }

    public function editCustomer($id)
    {
        $newcustomers = Customer::find($id);
        return view('Customer.edit', compact('newcustomers'));
    }

    public function updateCustomer(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'nic' => 'required',
            'address' => 'required',
        ]);

        Customer::find($id)->update($request->all());
        return redirect()->route('new-customer')->with('success', 'Customer updated successfully.');
    }

    public function deleteCustomer($id)
    {
        Customer::find($id)->delete();
        return redirect()->route('new-customer')->with('success', 'Customer deleted successfully.');
    }
}
