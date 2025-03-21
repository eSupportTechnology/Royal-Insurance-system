<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\InsuranceType;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class InsuranceController extends Controller
{
    public function index(){

        $insurance_types = InsuranceType::all();
        return view('insurance_types.index', compact('insurance_types'));
    }

    public function create(){
        return view('insurance_types.create');
    }

    public function store(Request $request){
        $request->validate([
            'name' =>'required|string|max:255',
        ]);

        InsuranceType::create($request->all());
        return redirect()->route('insuranceType.index')->with('success', 'Insurance type created successfully');
    }

    public function edit($id){
        $insurance_type = InsuranceType::find($id);
        return view('insurance_types.edit', compact('insurance_type'));
    }

    public function update(Request $request, $id){
        $request->validate([
            'name' =>'required|string|max:255',
        ]);

        InsuranceType::find($id)->update($request->all());
        return redirect()->route('insuranceType.index')->with('success', 'Insurance type updated successfully');
    }

    public function delete($id){
        InsuranceType::find($id)->delete();
        return redirect()->route('insuranceType.index')->with('success', 'Insurance type deleted successfully');
    }


    public function categoriesindex(){

        $insurance_types = InsuranceType::all();
        $categories = Category::all();
        return view('categories.index',compact('categories','insurance_types'));
    }

    public function categoriescreate(){
        $insurance_types = InsuranceType::all();
        return view('categories.create', compact('insurance_types'));
    }

    public function categoriesstore(Request $request){
        $request->validate([
            'name' =>'required|string|max:255',
            'insurance_type_id' => 'required',
        ]);

        Category::create($request->all());
        return redirect()->route('categories.index')->with('success', 'Category created successfully');
    }

    public function categoriesedit($id){
        $category = Category::find($id);
        $insurance_types = InsuranceType::all();
        return view('categories.edit', compact('category','insurance_types'));
    }

    public function categoriesupdate(Request $request, $id){
        $request->validate([
            'name' =>'required|string|max:255',
            'insurance_type_id' => 'required',
        ]);

        Category::find($id)->update($request->all());
        return redirect()->route('categories.index')->with('success', 'Category updated successfully');
    }

    public function categoriesdelete($id){
        Category::find($id)->delete();
        return redirect()->route('categories.index')->with('success', 'Category deleted successfully');
    }


    public function subcategoriesindex(){

        $subcategories = Subcategory::all();
        // $categories = Category::all();
        return view('subcategory.index', compact('subcategories'));
    }

    public function subcategoriescreate(){
        $insurance_types = InsuranceType::all();
        $categories = Category::all();
        return view('subcategory.create', compact('categories','insurance_types'));
    }

    public function subcategoriesstore(Request $request)
{
    // dd($request);
    $request->validate([
        'name' => 'required|string|max:255',
        'insurance_type_id' => 'required|exists:insurance_types,id',
        'category_id' => 'required|exists:categories,id',
    ]);

    SubCategory::create([
        'name' => $request->name,
        'insurance_type_id' => $request->insurance_type_id,
        'category_id' => $request->category_id,
    ]);

    return redirect()->route('subcategories.index')->with('success', 'Subcategory created successfully!');
}


    public function subcategoriesedit($id){
        $subcategories = Subcategory::find($id);
        $categories = Category::all();
        $insurance_types = InsuranceType::all();
        return view('subcategory.edit', compact('subcategories','categories','insurance_types'));
    }
    public function subcategoriesupdate(Request $request, $id){
        $request->validate([
            'name' =>'required|string|max:255',
            'category_id' => 'required|integer',
            'insurance_type_id' => 'required|integer',
        ]);
        SubCategory::find($id)->update($request->all());
        return redirect()->route('subcategories.index')->with('success', 'Subcategory updated successfully');
    }
    public function subcategoriesdelete($id){
        SubCategory::find($id)->delete();
        return redirect()->route('subcategories.index')->with('success', 'Subcategory deleted successfully');
    }


}
