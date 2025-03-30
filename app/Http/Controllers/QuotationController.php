<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomerResponse;
use App\Models\Company;
use App\Models\QuotationComparison;
use App\Models\QuotationDetail;

class QuotationController extends Controller
{
    // Show the quotation comparison page
    public function show($id)
    {
        $response = CustomerResponse::findOrFail($id);
        $companies = Company::all();

        $comparison = QuotationComparison::firstOrCreate([
            'customer_response_id' => $id,
        ]);

        $details = QuotationDetail::where('quotation_comparison_id', $comparison->id)->get();

        return view('quotations.show', compact('response', 'companies', 'comparison', 'details'));
    }

    // Save the updated quotation table
    public function save(Request $request, $id)
    {
        //dd($request);
        $comparison = QuotationComparison::updateOrCreate(
            ['customer_response_id' => $id],
            ['updated_at' => now()]
        );

        // Delete existing and re-add all rows for simplicity
        QuotationDetail::where('quotation_comparison_id', $comparison->id)->delete();

        foreach ($request->packages as $packageName => $companies) {
            foreach ($companies as $companyId => $description) {
                if ($companyId === 'label') {
                    continue; // Skip the label input
                }
        
                QuotationDetail::create([
                    'quotation_comparison_id' => $comparison->id,
                    'company_id' => $companyId,
                    'package_name' => $packageName,
                    'package_description' => $description,
                ]);
            }
        }
        

        return back()->with('success', 'Quotation table saved successfully.');
    }
}