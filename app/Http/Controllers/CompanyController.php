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
        // dd($request);
        $request -> validate([
            'name' => 'required',
            'email' => 'required',
            'contact_number' => 'required',
            'insurance_type' => 'required',
        ]);

        $data = $request->except('_token');

        $companies = new Company();
        $companies->name = $data['name'];
        $companies->email = $data['email'];
        $companies->contact_number = $data['contact_number'];
        $companies->insurance_type = $data['insurance_type'];
        $companies->save();

        return redirect()->route('company.index')->with('success','Successfully Add New Details');
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
        $request -> validate([
            'name' => 'required',
            'email' => 'required',
            'contact_number' => 'required',
            'insurance_type' => 'required',
        ]);

        $companies = Company::find($id);
        $companies->name = $request->input('name');
        $companies->email = $request->input('email');
        $companies->contact_number = $request->input('contact_number');
        $companies->insurance_type = $request->input('insurance_type');
        $companies->save();

        return redirect()->route('company.index')->with('success','Successfully Update Details');
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
