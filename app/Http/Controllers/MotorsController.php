<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\ContactMail;
use App\Models\Company;
use App\Models\Customer;
use App\Models\MailRequest;
use App\Models\Motor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class MotorsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function indexxx()
    {
        $motors = Motor::all();
        return view('motors.index', compact('motors'));
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
        'status' => 'required|string|in:pending,approved,rejected',
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
    // dd($request);
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
        'customer_id' => 'required|string',
        'email' => 'required|string',
        'phone' => 'required|string',
        'nic' => 'required|string',
        'address' => 'required|string',
    ]);

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
        'customer_id' => $request->customer_id,
        'email' => $request->email,
        'phone' => $request->phone,
        'nic' => $request->nic,
        'address' => $request->address,
    ]);

    $customer = Customer::find($request->customer_id);
    $customer_name = $customer ? $customer->name : 'Unknown Customer';

    if ($recode) {
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
            'customer_id' => $customer_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'nic' => $request->nic,
            'address' => $request->address,
            'date' => now()->format('Y-m-d'),
        ];

        $emails = explode(',', $request->company_email);
        foreach ($emails as $email) {
            Mail::to(trim($email))->send(new ContactMail($data));
        }
    }

    return redirect()->route('indexxx')->with('success', 'Motor request sent successfully.');
}

public function viewRequest(){

    $requests = MailRequest::with('customer')->get();
    return view('CustomerRequest.index', compact('requests'));
}

}
