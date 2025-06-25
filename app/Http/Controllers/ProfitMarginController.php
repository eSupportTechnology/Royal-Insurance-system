<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Company;
use App\Models\FormField;
use App\Models\InsuranceType;
use App\Models\ProfitMargin;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class ProfitMarginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $profits = ProfitMargin::all();
        return view('profitMargin.index',compact('profits'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companies = Company::all();
        $insurance_types = InsuranceType::with('categories.subcategories.formFields')->get();
        $categories = Category::all();
        $subcategories = SubCategory::all();
        $formfields = FormField::all();
        return view('profitMargin.create' ,compact('companies', 'insurance_types', 'categories', 'subcategories','formfields'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'company_id' => 'required|exists:companies,id',
        'insurance_type_id' => 'required|exists:insurance_types,id',
        'category_id' => 'nullable|exists:categories,id',
        'sub_category_id' => 'nullable|exists:sub_categories,id',
        'form_field_id' => 'nullable|exists:form_fields,id',
        'profit_type' => 'required|string',
        'total' => 'required|numeric',
        'rib' => 'required|numeric',
        'main_agent' => 'required|numeric',
        'sub_agent' => 'required|numeric',
    ]);

    ProfitMargin::create([
        'company_id' => $request->company_id,
        'insurance_type_id' => $request->insurance_type_id,
        'category_id' => $request->category_id ?: null,
        'sub_category_id' => $request->sub_category_id ?: null,
        'form_field_id' => $request->form_field_id ?: null,
        'profit_type' => $request->profit_type,
        'total' => $request->total,
        'rib' => $request->rib,
        'main_agent' => $request->main_agent,
        'sub_agent' => $request->sub_agent,
    ]);

    return redirect()->route('profitMargin.index')->with('success', 'Profit Margin created successfully!');
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
        $companies = Company::all();
        $insurance_types = InsuranceType::with('categories.subcategories.formFields')->get();
        $categories = Category::all();
        $sub_categories  = SubCategory::all();
        $form_fields = FormField::all();
        $profitMargin = ProfitMargin::findOrFail($id);
        return view('profitMargin.edit' ,
        compact('companies', 'insurance_types', 'categories', 'sub_categories', 'form_fields', 'profitMargin'));
    }

    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, $id)
{
    $request->validate([
        'company_id' => 'required|exists:companies,id',
        'insurance_type_id' => 'required|exists:insurance_types,id',
        'category_id' => 'nullable|exists:categories,id',
        'sub_category_id' => 'nullable|exists:sub_categories,id',
        'form_field_id' => 'nullable|exists:form_fields,id',
        'profit_type' => 'required|string',
        'total' => 'required|numeric',
        'rib' => 'required|numeric',
        'main_agent' => 'required|numeric',
        'sub_agent' => 'required|numeric',
    ]);

    $profitMargin = ProfitMargin::findOrFail($id);

    $profitMargin->update([
        'company_id' => $request->company_id,
        'insurance_type_id' => $request->insurance_type_id,
        'category_id' => $request->category_id,
        'sub_category_id' => $request->sub_category_id,
        'form_field_id' => $request->form_field_id,
        'profit_type' => $request->profit_type,
        'total' => $request->total,
        'rib' => $request->rib,
        'main_agent' => $request->main_agent,
        'sub_agent' => $request->sub_agent,
    ]);

    return redirect()->route('profitMargin.index')->with('success', 'Profit Margin updated successfully!');
}



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $profits = ProfitMargin::findOrFail($id);
        $profits->delete();
        return redirect()->route('profitMargin.index')->with('success', 'Profit Margin deleted successfully!');

    }

}
