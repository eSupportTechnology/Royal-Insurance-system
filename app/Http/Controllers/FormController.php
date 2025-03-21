<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\FormField;
use App\Models\InsuranceType;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class FormController extends Controller
{
    public function index(){

        $formfields = FormField::all();
        return view('formField.index', compact('formfields'));
    }

    public function create(){

        $insurance_types = InsuranceType::all();
        $subcategories = SubCategory::all();
        $categories = Category::all();
        return view('formField.create', compact('subcategories', 'insurance_types', 'categories'));
    }

    public function store(Request $request)
{
    $request->validate([
        'insurance_type_id' => 'required|exists:insurance_types,id',
        'category_id' => 'required|exists:categories,id',
        'sub_category_id' => 'required|exists:sub_categories,id',
        'field_name' => 'required|array',
        'field_name.*' => 'required|string|max:255',
        'field_type' => 'required|array',
        'field_type.*' => 'required|string|max:255',
        'required' => 'sometimes|array',
        'required.*' => 'nullable|boolean'
    ]);

    foreach ($request->field_name as $index => $fieldName) {
        FormField::create([
            'insurance_type_id' => $request->insurance_type_id,
            'category_id' => $request->category_id,
            'sub_category_id' => $request->sub_category_id,
            'field_name' => $fieldName,
            'field_type' => $request->field_type[$index],
            'required' => isset($request->required[$index]) ? 1 : 0
        ]);
    }

    return redirect()->route('formField.index')->with('success', 'Form Fields created successfully.');
}

public function edit($id)
{
    $formField = FormField::findOrFail($id);
    $subcategories = SubCategory::all();
    $categories = Category::all();
    $insurance_types = InsuranceType::all();
    return view('formField.edit', compact('formField', 'subcategories','categories', 'insurance_types'));
}
public function update(Request $request, $id)
{
    $request->validate([
        'sub_category_id' => 'required|exists:sub_categories,id',
        'field_name' => 'required|string|max:255',
        'field_type' => 'required|string|max:255',
        'required' => 'nullable|boolean'
    ]);

    $formField = FormField::findOrFail($id);
    $formField->update([
        'sub_category_id' => $request->sub_category_id,
        'field_name' => $request->field_name,
        'field_type' => $request->field_type,
        'required' => $request->has('required') ? 1 : 0
    ]);

    return redirect()->route('formField.index')->with('success', 'Form Field updated successfully.');
}
public function destroy($id)
{
    FormField::find($id)->delete();

    return redirect()->route('formField.index')->with('success', 'Form Field deleted successfully.');
}


}
