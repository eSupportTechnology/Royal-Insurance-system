<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Company;
use App\Models\InsuranceType;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\FormField;
use App\Models\Agent;
use App\Models\SubAgent;
use App\Models\CustomerInsurance;
use Illuminate\Http\Request;

class CustomerInsuranceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customerinsurances = CustomerInsurance::all();
        return view('CustomerInsurance.index',compact('customerinsurances'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
    $customers = Customer::all();
    $companies = Company::all();
    $insurance_types = InsuranceType::with('categories.subcategories.formFields')->get();
    $categories = Category::all();
    $subcategories = SubCategory::all();
    $formfields = FormField::all();
    $agents = Agent::all();

    $agentsWithSubagents = Agent::with('subagents')->get(); // Get agents + their subagents

    return view('CustomerInsurance.create', compact(
        'agents',
        'customers',
        'companies',
        'insurance_types',
        'categories',
        'subcategories',
        'formfields',
        'agentsWithSubagents'
    ));
}


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $validated = $request->validate([
        'inv' => 'required|string|max:50',
        'date' => 'required|date',
        'customer_id' => 'required|string|max:255',
        'policy' => 'nullable|string|max:255',
        'dn' => 'nullable|string|max:255',
        'vehicle' => 'nullable|string|max:255',
        'insurance_company' => 'nullable|string|max:255',
        'insurance_type_id' => 'required|exists:insurance_types,id',
        'category_id' => 'nullable|exists:categories,id',
        'sub_category_id' => 'nullable|exists:sub_categories,id',
        'form_field_id' => 'nullable|exists:form_fields,id',
        'rep' => 'nullable|string|max:255',
        'basic' => 'nullable|numeric',
        'srcc' => 'nullable|numeric',
        'tc' => 'nullable|numeric',
        'others' => 'nullable|numeric',
        'total' => 'required|numeric',
        'sum_insured' => 'nullable|numeric',
        'from_date' => 'nullable|date',
        'to_date' => 'nullable|date|after_or_equal:from_date',
        'contact' => 'nullable|string|max:20',
        'address' => 'nullable|string|max:255',
        'agent_code' => 'required|string|max:50',
        'subagent_code' => 'nullable|string|max:50',
        'status' => 'required|string|max:20',
    ]);

    CustomerInsurance::create($validated);

    return redirect()->route('customerinsurance.index')->with('success', 'Customer Insurance Record Created Successfully!');
}


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $customerinsurance = CustomerInsurance::find($id);
        return view('CustomerInsurance.show',compact('customerinsurance'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $customerinsurance = CustomerInsurance::find($id);
        $companies = Company::all();
        $customers = Customer::all();
        $insurance_types = InsuranceType::with('categories.subcategories.formFields')->get();
        $categories = Category::all();
        $sub_categories  = SubCategory::all();
        $form_fields = FormField::all();
        return view('Customerinsurance.edit',compact('customerinsurance', 'companies', 'customers', 'insurance_types', 'categories', 'sub_categories', 'form_fields'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'inv'              => 'required|string|max:50',
            'date'             => 'required|date',
            'customer_id'             => 'required|string|max:255',
            'policy'           => 'nullable|string|max:255',
            'dn'               => 'nullable|string|max:255',
            'vehicle'          => 'nullable|string|max:255',
            'insurance_company'=> 'nullable|string|max:255',
            'insurance_type_id'=> 'required|exists:insurance_types,id',
            'category_id'      => 'nullable|exists:categories,id',
            'sub_category_id'  => 'nullable|exists:sub_categories,id',
            'form_field_id'    => 'nullable|exists:form_fields,id',
            'rep'              => 'nullable|string|max:255',
            'basic'            => 'nullable|numeric',
            'srcc'             => 'nullable|numeric',
            'tc'               => 'nullable|numeric',
            'others'           => 'nullable|numeric',
            'total'            => 'required|numeric',
            'sum_insured'      => 'nullable|numeric',
            'from_date'        => 'nullable|date',
            'to_date'          => 'nullable|date|after_or_equal:from_date',
            'contact'          => 'nullable|string|max:20',
            'address'          => 'nullable|string|max:255',
            'agent_code'       => 'required|string|max:50',
            'subagent_code'    => 'nullable|string|max:50',
            'status'           => 'required|string|max:20',
        ]);

        $customerInsurance = CustomerInsurance::findOrFail($id);

    // Then update it
    $customerInsurance->update($validated);

        return redirect()->route('customerinsurance.index')
                         ->with('success', 'Customer Insurance Record Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        CustomerInsurance::find($id)->delete();
        return redirect()->route('customerinsurance.index')->with('success', 'CustomerInsurance deleted successfully.');
    }
}
