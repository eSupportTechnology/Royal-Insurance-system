<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companies = Company::all();
        return view('company.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('company.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'name' => 'required',
        'logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        'address' => 'required',
        'email' => 'required|email',
        'contact_number' => 'required',
    ]);

    $companies = new Company();
    $companies->name = $request->name;
    $companies->address = $request->address;
    $companies->email = $request->email;
    $companies->contact_number = $request->contact_number;

    // Handle file upload
    if ($request->hasFile('logo')) {
        $image = $request->file('logo');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('uploads'), $imageName); // Move file to 'public/uploads/'
        $companies->logo = 'uploads/' . $imageName; // Save the file path in the database
    }

    $companies->save();

    return redirect()->route('company.index')->with('success', 'Successfully Added New Company');
}


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $companies = Company::find($id);
        return view('company.edit', compact('companies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
{
    $request->validate([
        'name' => 'required',
        'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Allow null for existing logo
        'address' => 'required',
        'email' => 'required|email',
        'contact_number' => 'required',
    ]);

    $companies = Company::findOrFail($id); // Find the company or fail if not found

    $companies->name = $request->input('name');
    $companies->address = $request->input('address');
    $companies->email = $request->input('email');
    $companies->contact_number = $request->input('contact_number');

    // Handle logo update
    if ($request->hasFile('logo')) {
        // Delete the old logo if it exists
        if ($companies->logo && file_exists(public_path($companies->logo))) {
            unlink(public_path($companies->logo));
        }

        // Upload the new logo
        $image = $request->file('logo');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('uploads'), $imageName);
        $companies->logo = 'uploads/' . $imageName;
    }

    $companies->save();

    return redirect()->route('company.index')->with('success', 'Successfully Updated Company Details');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $companies = Company::find($id);
        if($companies){
            $companies ->delete();

            return redirect()->route('company.index')->with('success','Data is Deleted!');
        }
        return redirect()->route('company.index')->with('error','Details Not!');
    }
    public function status($company_id)
    {
        $company = Company::find($company_id);
        // $company = $this->company->find($company_id);
        $company->status = !$company->status;
        $company->update();

        return redirect()->back();
    }

}
