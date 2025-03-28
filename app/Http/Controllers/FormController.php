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
        $forms = FormField::with(['insuranceType', 'category', 'subCategory'])
            ->get()
            ->groupBy(function ($item) {
                return $item->insurance_type_id . '-' . $item->category_id . '-' . $item->sub_category_id;
            });

        return view('formField.index', compact('forms'));
    }


    public function show($groupKey)
    {
        // Parse the group key to get insurance type, category, and sub-category
        list($insuranceTypeId, $categoryId, $subCategoryId) = explode('-', $groupKey);

        // Fetch the fields for this combination
        $formFields = FormField::where('insurance_type_id', $insuranceTypeId)
            ->where('category_id', $categoryId)
            ->when($subCategoryId !== 'null', function ($query) use ($subCategoryId) {
                // If subCategoryId is not null, only show fields with that subCategoryId
                $query->where('sub_category_id', $subCategoryId);
            }, function ($query) {
                // If subCategoryId is null, show fields that either have a subCategory or not
                $query->whereNull('sub_category_id');
            })
            ->with('options') // Eager load options for select/checkbox fields
            ->get();

        // Fetch additional data for display
        $insuranceType = InsuranceType::find($insuranceTypeId);
        $category = Category::find($categoryId);
        $subCategory = $subCategoryId !== 'null' ? SubCategory::find($subCategoryId) : null;

        return view('formField.show', compact('formFields', 'insuranceType', 'category', 'subCategory'));
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
        $formField = FormField::findOrFail($id);
        $subcategories = SubCategory::all();
        $categories = Category::all();
        $insurance_types = InsuranceType::all();
        $formFieldOptions = $formField->options->pluck('option')->toArray(); // Get options if they exist

        return view('formField.edit', compact('formField', 'formFieldOptions', 'subcategories', 'categories', 'insurance_types'));
    }

    public function update(Request $request, $id)
    {
        // Validation for updating fields
        $request->validate([
            'sub_category_id' => 'nullable|exists:sub_categories,id',
            'field_name' => 'required|string|max:255',
            'field_type' => 'required|string|max:255',
            'required' => 'nullable|boolean',
            'field_options' => 'nullable|array', // For select/checkbox options
            'field_options.*' => 'nullable|string|max:255', // For options
        ]);

        // Find the form field to update
        $formField = FormField::findOrFail($id);
        $formField->update([
            'sub_category_id' => $request->sub_category_id ?? null,
            'field_name' => $request->field_name,
            'field_type' => $request->field_type,
            'required' => $request->has('required') ? 1 : 0,
        ]);

        // If it's a select or checkbox, update options
        if (in_array($formField->field_type, ['select', 'checkbox']) && isset($request->field_options)) {
            // First, delete old options
            FormFieldOption::where('form_field_id', $formField->id)->delete();

            // Insert new options
            $options = explode(',', $request->field_options[0]); // Assuming options are comma-separated

            foreach ($options as $option) {
                FormFieldOption::create([
                    'form_field_id' => $formField->id,
                    'option' => trim($option), // Trim to remove extra spaces
                ]);
            }
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
}
