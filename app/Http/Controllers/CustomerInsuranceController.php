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
use Yajra\DataTables\Facades\DataTables;

class CustomerInsuranceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index(Request $request)
{
    if ($request->ajax()) {
        $data = CustomerInsurance::with([
            'customer',
            'company',
            'insuranceType',
            'categories',
            'subCategory',
            'formField',
            'agent'
        ]);

        // Apply customer filter
        if ($request->has('name') && $request->name != '') {
            $data->whereHas('customer', function ($q) use ($request) {
                $q->where('id', $request->name);
            });
        }

        // Apply company filter
        if ($request->has('insurance_company') && $request->insurance_company != '') {
            $data->whereHas('company', function ($q) use ($request) {
                $q->where('id', $request->insurance_company);
            });
        }

        return DataTables::of($data)
            ->addIndexColumn()

            ->addColumn('customer', fn($row) => $row->customer->name ?? 'N/A')
            ->addColumn('company', fn($row) => $row->company->name ?? 'N/A')
            ->addColumn('insurance_type', fn($row) => $row->insuranceType->name ?? 'N/A')
            ->addColumn('category', fn($row) => $row->categories->name ?? 'N/A')
            ->addColumn('subcategory', fn($row) => $row->subCategory->name ?? 'N/A')
            ->addColumn('form_field', fn($row) => $row->formField->field_name ?? 'N/A')
            ->addColumn('agent', fn($row) => $row->agent?->rep_code ?? 'N/A')

            ->addColumn('status', function ($row) {
                if ($row->status === 'Completed') {
                    return '<span class="badge bg-success">Completed</span>';
                } elseif ($row->status === 'Pending') {
                    return '<span class="badge bg-danger text-dark">Pending</span>';
                } else {
                    return '<span class="badge bg-secondary">Unknown</span>';
                }
            })

            ->filterColumn('customer', function ($query, $keyword) {
                $query->whereHas('customer', function ($q) use ($keyword) {
                    $q->where('name', 'like', "%{$keyword}%");
                });
            })
            ->filterColumn('company', function ($query, $keyword) {
                $query->whereHas('company', function ($q) use ($keyword) {
                    $q->where('name', 'like', "%{$keyword}%");
                });
            })
            ->filterColumn('insurance_type', function ($query, $keyword) {
                $query->whereHas('insuranceType', function ($q) use ($keyword) {
                    $q->where('name', 'like', "%{$keyword}%");
                });
            })
            ->filterColumn('agent', function ($query, $keyword) {
                $query->whereHas('agent', function ($q) use ($keyword) {
                    $q->where('rep_code', 'like', "%{$keyword}%");
                });
            })

            ->addColumn('action', function ($row) {
                $view = '<a href="' . route('customerinsurance.show', $row->id) . '" class="btn btn-sm btn-primary" title="View"><i class="icon-eye"></i></a>';

                $edit = '<a href="' . route('customerinsurance.edit', $row->id) . '" class="btn btn-sm btn-warning" title="Edit"><i class="icon-pencil-alt"></i></a>';

                $delete = '
    <form action="' . route('customerinsurance.destroy', $row->id) . '" method="POST" onsubmit="return confirm(\'Are you sure?\');" style="display:inline;">
        ' . csrf_field() . method_field('DELETE') . '
        <button type="submit" class="btn btn-sm btn-danger d-inline-flex align-items-center justify-content-center" style="height: 31px; padding: 0 28px;">
            <i class="icon-trash"></i>
        </button>
    </form>';

                $link = '';
                if ($row->status === 'Pending') {
                    $link = '<a href="' . route('customerinsurance.setCash', $row->id) . '" class="btn btn-sm btn-info" title="Set to Cash" style="height: 31px; padding: 0 28px;"><i class="icon-link"></i></a>';
                }

                return '<div class="d-flex gap-1 align-items-center">' . $view . $edit . $link . $delete . '</div>';
            })

            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    // Get unique customers and companies for dropdowns
    $customers = CustomerInsurance::with('customer')
        ->get()
        ->pluck('customer')
        ->unique('id')
        ->sortBy('name');

    $companies = CustomerInsurance::with('company')
        ->get()
        ->pluck('company')
        ->unique('id')
        ->sortBy('name');

    return view('customerinsurance.index', compact('customers', 'companies'));
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

    public function setCash($id)
    {
        $insurance = CustomerInsurance::findOrFail($id);

        if ($insurance->status === 'Pending') {
            $insurance->premium_type = 'Cash';
            $insurance->status = 'Completed';
            $insurance->save();

            return redirect()->back()->with('success', 'Successfully updated.');
        }

        return redirect()->back()->with('error', 'Update failed. Status is not Pending.');
    }
}
