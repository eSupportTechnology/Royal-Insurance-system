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
        $customerinsurances = CustomerInsurance::with('customer')->get();
        return view('CustomerInsurance.index', compact('customerinsurances'));

        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::select('id', 'name', 'phone', 'whatsapp_number', 'address')->get();
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
            'name' => 'required|string|max:255',
            'policy' => 'nullable|string|max:255',
            'dn' => 'nullable|string|max:255',
            'vehicle' => 'nullable|string|max:255',
            'insurance_company' => 'required|string|max:255',
            'insurance_type' => 'required|exists:insurance_types,id',
            'category' => 'nullable|exists:categories,id',
            'subcategory' => 'nullable|exists:sub_categories,id',
            'varietyfields' => 'nullable|exists:form_fields,id',
            'basic' => 'nullable|numeric',
            'srcc' => 'nullable|numeric',
            'tc' => 'nullable|numeric',
            'others' => 'nullable|numeric',
            'total' => 'required|numeric',
            'sum_insured' => 'nullable|numeric',
            'paid_amount' => 'required|numeric',
            'outstanding_amount' => 'required|numeric',
            'from_date' => 'nullable|date',
            'to_date' => 'nullable|date|after_or_equal:from_date',
            'contact' => 'nullable|string|max:20',
            'whatsapp' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'introducer_code' => 'required|string|max:50',
            'subagent_code' => 'nullable|string|max:50',
            'premium_type' => 'required|string|max:20',
            'status' => 'required|string|max:20',
        ]);

        // Use 'inv' as the unique identifier to avoid duplicate insurance entries
        CustomerInsurance::updateOrCreate(
            ['inv' => $validated['inv']],  // Search condition
            $validated                      // Fields to update or insert
        );

        return redirect()->route('customerinsurance.index')->with('success', 'Customer Insurance Record Created Successfully!');
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $customerinsurance = CustomerInsurance::find($id);
        return view('CustomerInsurance.show', compact('customerinsurance'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $customerinsurance = CustomerInsurance::find($id);

        $customers = Customer::select('id', 'name', 'phone', 'whatsapp_number', 'address')->get();
        $companies = Company::all();
        $insurance_types = InsuranceType::with('categories.subcategories.formFields')->get();
        $categories = Category::all();
        $subcategories = SubCategory::all();
        $formfields = FormField::all();
        $agents = Agent::all();

        $agentsWithSubagents = Agent::with('subagents')->get(); // Get agents + their subagents

        return view('CustomerInsurance.edit', compact(
            'agents',
            'customers',
            'companies',
            'insurance_types',
            'categories',
            'subcategories',
            'formfields',
            'agentsWithSubagents',
            'customerinsurance'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'inv'              => 'required|string|max:50',
            'date'             => 'required|date',
            'name'             => 'required|string|max:255',
            'policy'           => 'nullable|string|max:255',
            'dn'               => 'nullable|string|max:255',
            'vehicle'          => 'nullable|string|max:255',
            'insurance_company' => 'required|string|max:255',
            'insurance_type' => 'required|exists:insurance_types,id',
            'category'      => 'nullable|exists:categories,id',
            'subcategory'  => 'nullable|exists:sub_categories,id',
            'varietyfields'    => 'nullable|exists:form_fields,id',
            'basic'            => 'nullable|numeric',
            'srcc'             => 'nullable|numeric',
            'tc'               => 'nullable|numeric',
            'others'           => 'nullable|numeric',
            'total'            => 'required|numeric',
            'sum_insured'      => 'nullable|numeric',
            'paid_amount'      => 'required|numeric',
            'outstanding_amount' => 'required|numeric',
            'from_date'        => 'nullable|date',
            'to_date'          => 'nullable|date|after_or_equal:from_date',
            'contact'          => 'nullable|string|max:20',
            'whatsapp'         => 'nullable|string|max:20',
            'address'          => 'nullable|string|max:255',
            'introducer_code'  => 'required|string|max:50',
            'subagent_code'    => 'nullable|string|max:50',
            'premium_type'     => 'required|string|max:20',
            'status'           => 'required|string|max:20',
        ]);

        // Find and update the record
        $customerInsurance = CustomerInsurance::findOrFail($id);
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
