<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\ContactMail;
use App\Models\Company;
use App\Models\MailRequest;
use App\Models\Motor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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
        return view('motors.create');
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
            'vehicle_number' => 'required|string',
            'class' => 'required|string',
            'usage' => 'required|string',
            'vehicle_value' => 'required|numeric',
            'financial_interest' => 'required|string',
            'fuel_type' => 'required|string',
            'name' => 'required|string',
            'id_number' => 'required|string',
            'location' => 'required|string',
            'other_details' => 'nullable|string',
            'vehicle_copy.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
            'id_copy.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
            'renewal_copy.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
            'vehical_pic.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
            'client_letter.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
            'other_doc.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
        ]);

        $data = $validated;

        foreach (['vehicle_copy', 'id_copy', 'renewal_copy', 'vehical_pic', 'client_letter', 'other_doc'] as $fileField) {
            if ($request->hasFile($fileField)) {
                $files = [];
                foreach ($request->file($fileField) as $file) {
                    $files[] = $file->store('uploads', 'public');
                }
                $data[$fileField] = json_encode($files);
            }
        }

        Motor::create($data);

        return redirect()->route('indexxx')->with('success', 'Motor insurance data added successfully.');
    }

    public function edit($id)
    {
        $motor = Motor::findOrFail($id);
        return view('motors.edit', compact('motor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $validated = $request->validate([
            'make' => 'required|string',
            'model' => 'required|string',
            'year' => 'required|numeric',
            'vehicle_number' => 'required|string',
            'class' => 'required|string',
            'usage' => 'required|string',
            'vehicle_value' => 'required|numeric',
            'financial_interest' => 'required|string',
            'fuel_type' => 'required|string',
            'name' => 'required|string',
            'id_number' => 'required|string',
            'location' => 'required|string',
            'other_details' => 'nullable|string',
            'vehicle_copy.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
            'id_copy.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
            'renewal_copy.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
            'vehical_pic.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
            'client_letter.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
            'other_doc.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
            'status' => 'required|string|in:pending,approved,rejected',

        ]);


        $motor = Motor::findOrFail($id);
        $motor->update(['status' => $validated['status']]);

        $data = $validated;

        foreach (['vehicle_copy', 'id_copy', 'renewal_copy', 'vehical_pic', 'client_letter', 'other_doc'] as $fileField) {
            $existingFiles = json_decode($motor->$fileField, true) ?? [];

            if ($request->filled("remove_{$fileField}")) {
                $existingFiles = array_diff($existingFiles, $request->input("remove_{$fileField}"));
            }

            if ($request->hasFile($fileField)) {
                foreach ($request->file($fileField) as $file) {
                    $existingFiles[] = $file->store('uploads', 'public');
                }
            }

            $data[$fileField] = json_encode($existingFiles);
        }

        $motor->update($data);

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
        $companies = Company::all();
        return view('motors.mail', compact('motors','companies'));
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
        'name'           => 'required|string',
        'id_number'      => 'required|string'
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
        'name'           => $request->name,
        'id_number'      => $request->id_number
    ]);

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
            'name'           => $request->name,
            'id_number'      => $request->id_number
        ];

        $emails = explode(',', $request->company_email);
        foreach ($emails as $email) {
            Mail::to(trim($email))->send(new ContactMail($data));
        }
    }

    return redirect()->route('indexxx')->with('success', 'Motor request sent successfully.');
}

}
