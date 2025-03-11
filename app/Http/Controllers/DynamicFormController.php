<?php

namespace App\Http\Controllers;

use App\Models\FormField;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class DynamicFormController extends Controller
{
    public function showPrivateCar()
{
    // Fetch subcategory by name
    $subCategory = SubCategory::where('name', 'Private Car')->first();

    // If no subcategory is found, return the view with a message
    if (!$subCategory) {
        return view('subcategories.privatecar', ['message' => 'No data available for Private Car.']);
    }

    // Fetch associated form fields
    $formFields = FormField::where('sub_category_id', $subCategory->id)->get();

    return view('subcategories.privatecar', compact('subCategory', 'formFields'));
}

}
