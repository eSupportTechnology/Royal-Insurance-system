<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerResponse;
use App\Models\FormField;
use App\Models\SubCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CustomerController extends Controller
{
    public function index()
    {
        $responses = CustomerResponse::with(['customer', 'subcategory', 'field'])->get();
        return view('Customer_responses.index', compact('responses'));
    }

    // Show form to create a new response
    public function create(Request $request)
    {

        if ($request->ajax() && $request->has('sub_category_id')) {
            $fields = FormField::where('sub_category_id', $request->sub_category_id)->get();
            return response()->json($fields);
        }

        $customers = Customer::all();
        $subcategories = SubCategory::all();
        return view('Customer_responses.create', compact('subcategories', 'customers'));
    }

    // Store the submitted response
    public function store(Request $request)
    {
        $request->validate([
            'sub_category_id' => 'required|exists:sub_categories,id',
            'customer_id' => 'required|exists:customers,id',
            'responses' => 'nullable|array',
            'responses.*.field_id' => 'required|exists:form_fields,id',
            'responses.*.value' => 'nullable|string' // Allow NULL values
        ]);

        foreach ($request->responses as $response) {
            if (!empty($response['value'])) { // Only insert if value is not empty
                CustomerResponse::create([
                    'sub_category_id' => $request->sub_category_id,
                    'customer_id' => $request->customer_id,
                    'field_id' => $response['field_id'],
                    'value' => $response['value'],
                ]);
            }
        }

        return redirect()->route('customerResponses.index')->with('success', 'Responses saved successfully.');
    }


    // Delete response
    public function destroy($id)
    {
        CustomerResponse::findOrFail($id)->delete();
        return redirect()->route('customerResponses.index')->with('success', 'Response deleted successfully.');
    }


    public function newCustomer(Request $request)
    {
        if ($request->ajax()) {
            $data = Customer::query();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $view = '<a href="' . route('view-customer', $row->id) . '" class="btn btn-sm btn-primary"><i class="icon-eye"></i></a>';
                    $edit = '<a href="' . route('edit-customer', $row->id) . '" class="btn btn-sm btn-warning"><i class="icon-pencil-alt"></i></a>';
                    $delete = '
                    <form action="' . route('delete-customer', $row->id) . '" method="POST" onsubmit="return confirm(\'Are you sure?\');" style="display:inline;">
                        ' . csrf_field() . method_field('DELETE') . '
                        <button type="submit" class="btn btn-sm btn-danger" style="height: 31px; padding: 0 28px;"><i class="icon-trash"></i></button>
                    </form>';

                    return '<div class="d-flex gap-1 align-items-center">' . $view . $edit . $delete . '</div>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('customer.index');
    }


    public function createCustomer()
    {

        return view('customer.create')->with('success', 'Customer created successfully.');
    }

    public function storeCustomer(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'nullable',
            'nic' => 'nullable',
            'address' => 'nullable',
            'whatsapp_number' => 'nullable'
        ]);

        $data = $request->all();
        $data['Insurance_coverages'] = $request->input('Insurance_coverages', 0); // Default to 0

        Customer::create($data);

        return redirect()->route('new-customer')->with('success', 'Customer created successfully.');
    }


    public function editCustomer($id)
    {
        $newcustomers = Customer::find($id);
        return view('customer.edit', compact('newcustomers'));
    }

    public function updateCustomer(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'nullable|email',
            'phone' => 'nullable',
            'nic' => 'nullable',
            'address' => 'nullable',
        ]);

        Customer::find($id)->update($request->all());
        return redirect()->route('new-customer')->with('success', 'Customer updated successfully.');
    }

    public function deleteCustomer($id)
    {
        Customer::find($id)->delete();
        return redirect()->route('new-customer')->with('success', 'Customer deleted successfully.');
    }

    public function view($id)
    {
        $customer = Customer::findOrFail($id);
        $responses = CustomerResponse::with('insuranceType', 'category', 'subCategory')
            ->where('customer_email', $customer->email)
            ->get();

        return view('customer.view', compact('customer', 'responses'));
    }
}
