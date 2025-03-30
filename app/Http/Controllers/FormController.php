<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\FormField;
use App\Models\FormFieldOption;
use App\Models\InsuranceType;
use App\Models\SubCategory;
use Illuminate\Http\Request;


class FormController extends Controller
{
    public function index()
    {
        // Fetch all form fields with related categories, insurance types, and subcategories
        $formFields = FormField::with(['category', 'insuranceType', 'subCategory', 'options'])->get();

        // Group form fields by Insurance Type -> Category -> SubCategory
        $groupedFormFields = $formFields->groupBy([
            'insuranceType.name',
            'category.name',
            'subCategory.name'
        ]);

        return view('formField.index', compact('groupedFormFields'));
    }

    public function create(){
        $insurance_types = InsuranceType::all();
        $subcategories = SubCategory::all();
        $categories = Category::all();
        return view('formField.create', compact('subcategories', 'insurance_types', 'categories'));
    }

    public function store(Request $request)
    {
        // Validation for the input fields
        $request->validate([
            'insurance_type_id' => 'required|exists:insurance_types,id',
            'category_id' => 'required|exists:categories,id',
            'sub_category_id' => 'nullable|exists:sub_categories,id',
            'field_name' => 'required|array',
            'field_name.*' => 'required|string|max:255',
            'field_type' => 'required|array',
            'field_type.*' => 'required|string|max:255',
            'required' => 'sometimes|array',
            'required.*' => 'nullable|boolean',
            'field_options' => 'nullable|array', // For select/checkbox options
            'field_options.*' => 'nullable|string|max:255', // For options
        ]);

        // Loop through form fields to store each one
        foreach ($request->field_name as $index => $fieldName) {
            // Create the FormField entry
            $formField = FormField::create([
                'insurance_type_id' => $request->insurance_type_id,
                'category_id' => $request->category_id,
                'sub_category_id' => $request->sub_category_id ?? null, // Allow null for sub-category
                'field_name' => $fieldName,
                'field_type' => $request->field_type[$index],
                'required' => isset($request->required[$index]) ? 1 : 0,
            ]);

            // If the field is a select or checkbox, store options in the FormFieldOption table
            if (in_array($formField->field_type, ['select', 'checkbox']) && isset($request->field_options[$index])) {
                $options = explode(',', $request->field_options[$index]); // Assuming options are comma-separated

                // Loop through options and create them
                foreach ($options as $option) {
                    FormFieldOption::create([
                        'form_field_id' => $formField->id,
                        'option_value' => trim($option), // Trim to remove extra spaces
                    ]);
                }
            }
        }

        return redirect()->route('formField.index')->with('success', 'Form Fields created successfully.');
    }

    public function edit($id)
    {
        $formField = FormField::with('options')->findOrFail($id); // Fetch options with form field
        $subcategories = SubCategory::all();
        $categories = Category::all();
        $insurance_types = InsuranceType::all();

        // Retrieve options as a comma-separated string
        $formFieldOptions = $formField->options->pluck('option_value')->toArray();
        $formFieldOptions = implode(', ', $formFieldOptions); // Convert array to string

        return view('formField.edit', compact('formField', 'formFieldOptions', 'subcategories', 'categories', 'insurance_types'));
    }


    public function update(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'field_name' => 'required|string|max:255',
            'field_type' => 'required|string|max:255',
            'required' => 'nullable', // Allow null value
            'field_options' => 'nullable|string', // Options will be a comma-separated string
        ]);
    
        // Find the form field to update
        $formField = FormField::findOrFail($id);
        $formField->update([
            'field_name' => $request->field_name,
            'field_type' => $request->field_type,
            'required' => $request->has('required') ? 1 : 0,
        ]);
    
        // If the field type is 'select', 'checkbox', or 'radio', handle the options
        if (in_array($request->field_type, ['select', 'checkbox', 'radio'])) {
            // Delete previous options
            FormFieldOption::where('form_field_id', $formField->id)->delete();
    
            // Save new options if provided
            if ($request->filled('field_options')) {
                $options = explode(',', $request->field_options); // Split by comma
                foreach ($options as $option) {
                    FormFieldOption::create([
                        'form_field_id' => $formField->id,
                        'option_value' => trim($option), // Remove extra spaces
                    ]);
                }
            }
        } else {
            // If the field type is not one that requires options, delete any existing options
            FormFieldOption::where('form_field_id', $formField->id)->delete();
        }
    
        return redirect()->route('formField.index')->with('success', 'Form Field updated successfully.');
    }
    
    

    public function destroy($id)
    {
        // Delete form field and its options
        $formField = FormField::findOrFail($id);
        $formField->options()->delete(); // Delete associated options if any
        $formField->delete(); // Delete the form field itself

        return redirect()->route('formField.index')->with('success', 'Form Field deleted successfully.');
    }

    // Show the add new field form
    public function addNew(Request $request)
    {
        $insuranceTypeId = $request->insurance_type_id;
        $categoryId = $request->category_id;
        $subCategoryId = $request->sub_category_id;
    
        return view('formField.addNewField', compact('insuranceTypeId', 'categoryId', 'subCategoryId'));
    }
    

    // Store the new field
    public function storeNew(Request $request)
    {
        //dd($request);
        $request->validate([
            'insurance_type_id' => 'required|exists:insurance_types,id',
            'category_id' => 'required|exists:categories,id',
            'sub_category_id' => 'nullable|exists:sub_categories,id',
            'field_name' => 'required|string|max:255',
            'field_type' => 'required|string|max:255',
            'required' => 'nullable|in:0,1',
            'field_options' => 'nullable|string',
        ]);

        $formField = FormField::create([
            'insurance_type_id' => $request->insurance_type_id,
            'category_id' => $request->category_id,
            'sub_category_id' => $request->sub_category_id,
            'field_name' => $request->field_name,
            'field_type' => $request->field_type,
            'required' => $request->has('required') ? 1 : 0,
        ]);

        if (in_array($request->field_type, ['select', 'checkbox', 'radio']) && $request->filled('field_options')) {
            $options = explode(',', $request->field_options);
            foreach ($options as $option) {
                FormFieldOption::create([
                    'form_field_id' => $formField->id,
                    'option_value' => trim($option),
                ]);
            }
        }

        return redirect()->route('formField.index')->with('success', 'New Form Field added successfully.');
    }


}
