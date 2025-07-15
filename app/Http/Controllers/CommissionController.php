<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\AgentCommission;
use App\Models\Company;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\CustomerInsurance;
use App\Models\ProfitMargin;
use App\Models\RibCommission;
use App\Models\SubAgentCommission;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class CommissionController extends Controller
{
    public function ribIndex(Request $request)
    {
        // Calculate and update commissions
        $customerInsurances = CustomerInsurance::all();
        $newlyCreatedIds = [];

        foreach ($customerInsurances as $insurance) {
            $profitMargins = ProfitMargin::where('company_id', $insurance->insurance_company)
                ->where('insurance_type_id', $insurance->insurance_type)
                ->where(function ($query) use ($insurance) {
                    $query->whereNull('category_id')->orWhere('category_id', $insurance->category);
                })
                ->where(function ($query) use ($insurance) {
                    $query->whereNull('sub_category_id')->orWhere('sub_category_id', $insurance->subcategory);
                })
                ->where(function ($query) use ($insurance) {
                    $query->whereNull('form_field_id')->orWhere('form_field_id', $insurance->varietyfields);
                })
                ->get();

            $net = $srcc = $tc = 0;
            foreach ($profitMargins as $margin) {
                $rib = floatval($margin->rib);
                switch ($margin->profit_type) {
                    case 'Net Premium':
                        $net += ($rib / 100) * $insurance->basic;
                        break;
                    case 'RCC':
                        $srcc += ($rib / 100) * $insurance->srcc;
                        break;
                    case 'TC':
                        $tc += ($rib / 100) * $insurance->tc;
                        break;
                }
            }

            $status = ($insurance->premium_type == 'Debit') ? 'Pending' : 'Completed';
            $total = $net + $srcc + $tc;

            $updated = RibCommission::updateOrCreate(
                ['customer_insurance_id' => $insurance->id],
                [
                    'net_premium' => round($net, 2),
                    'srcc_premium' => round($srcc, 2),
                    'tc_premium' => round($tc, 2),
                    'total' => round($total, 2),
                    'status' => $status,
                ]
            );

            $newlyCreatedIds[] = $updated->id;
        }

        // AJAX request for DataTable
        if ($request->ajax()) {
            $data = RibCommission::with(['customerInsurance.customer', 'customerInsurance.company'])->latest();

            if ($request->has('name') && $request->name != '') {
                $data->whereHas('customerInsurance.customer', function ($q) use ($request) {
                    $q->where('id', $request->name);
                });
            }

            if ($request->has('insurance_company') && $request->insurance_company != '') {
                $data->whereHas('customerInsurance.company', function ($q) use ($request) {
                    $q->where('id', $request->insurance_company);
                });
            }

            // Apply insurance date filter
            if ($request->from_date && $request->to_date) {
                $data->whereBetween('created_at', [$request->from_date, $request->to_date]);
            }

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('customer_id', fn($row) => $row->customerInsurance->id ?? '-')
                ->addColumn('customer_name', fn($row) => $row->customerInsurance->customer->name ?? '-')
                ->addColumn('company_name', fn($row) => $row->customerInsurance->company->name ?? '-')
                ->addColumn('net', fn($row) => 'Rs.' . number_format($row->net_premium, 2))
                ->addColumn('srcc', fn($row) => 'Rs.' . number_format($row->srcc_premium, 2))
                ->addColumn('tc', fn($row) => 'Rs.' . number_format($row->tc_premium, 2))
                ->addColumn('total', fn($row) => '<strong>Rs.' . number_format($row->total, 2) . '</strong>')
                ->addColumn('status', function ($row) {
                    $badge = $row->status === 'Completed' ? 'success' : 'danger';
                    return '<span class="badge bg-' . $badge . '">' . $row->status . '</span>';
                })
                ->addColumn('action', function ($row) {
                    $view = '<a href="' . route('customerinsurance.show', $row->customerInsurance->id) . '" class="btn btn-sm btn-primary action-btn" title="View"><i class="icon-eye"></i></a>';
                    return '<div class="d-flex gap-1 align-items-center">' . $view . '</div>';
                })
                ->rawColumns(['total', 'status', 'action'])
                ->make(true);
        }

        // Load customers and companies for dropdowns
        $customers = Customer::whereIn('id', RibCommission::with('customerInsurance')
            ->get()
            ->pluck('customerInsurance.name')
            ->unique())->orderBy('name')->get();

        $companies = Company::whereIn('id', RibCommission::with('customerInsurance')
            ->get()
            ->pluck('customerInsurance.insurance_company')
            ->unique())->orderBy('name')->get();

        return view('commission.rib', compact('customers', 'companies'));
    }




    public function agentIndex(Request $request)
    {
        // Recalculate and update commissions
        $customerInsurances = CustomerInsurance::with('agent')->get();



        foreach ($customerInsurances as $insurance) {
            $profitMargins = ProfitMargin::where('company_id', $insurance->insurance_company)
                ->where('insurance_type_id', $insurance->insurance_type)
                ->where(function ($query) use ($insurance) {
                    $query->whereNull('category_id')->orWhere('category_id', $insurance->category);
                })
                ->where(function ($query) use ($insurance) {
                    $query->whereNull('sub_category_id')->orWhere('sub_category_id', $insurance->subcategory);
                })
                ->where(function ($query) use ($insurance) {
                    $query->whereNull('form_field_id')->orWhere('form_field_id', $insurance->varietyfields);
                })
                ->get();

            $net = $srcc = $tc = 0;

            foreach ($profitMargins as $margin) {
                $rate = floatval($margin->main_agent);
                switch ($margin->profit_type) {
                    case 'Net Premium':
                        $net += ($rate / 100) * $insurance->basic;
                        break;
                    case 'RCC':
                        $srcc += ($rate / 100) * $insurance->srcc;
                        break;
                    case 'TC':
                        $tc += ($rate / 100) * $insurance->tc;
                        break;
                }
            }

            $status = ($insurance->premium_type === 'Debit') ? 'Pending' : 'Completed';
            $total = $net + $srcc + $tc;

            AgentCommission::updateOrCreate(
                ['customer_insurance_id' => $insurance->id],
                [
                    'agent_rep_code' => $insurance->agent->rep_code ?? null,
                    'net_premium' => round($net, 2),
                    'srcc_premium' => round($srcc, 2),
                    'tc_premium' => round($tc, 2),
                    'total' => round($total, 2),
                    'status' => $status,
                ]
            );
        }

        // AJAX DataTables response
        if ($request->ajax()) {
            $data = AgentCommission::with(['customerInsurance.customer', 'customerInsurance.company'])->latest();

            if ($request->has('customer_id') && $request->customer_id != '') {
                $data->whereHas('customerInsurance.customer', function ($q) use ($request) {
                    $q->where('id', $request->customer_id);
                });
            }

            if ($request->has('company_id') && $request->company_id != '') {
                $data->whereHas('customerInsurance.company', function ($q) use ($request) {
                    $q->where('id', $request->company_id);
                });
            }

            // Apply insurance date filter
            if ($request->from_date && $request->to_date) {
                $data->whereBetween('created_at', [$request->from_date, $request->to_date]);
            }

            return DataTables::of($data)
                ->filterColumn('customer_name', function ($query, $keyword) {
                    $query->whereHas('customerInsurance.customer', function ($q) use ($keyword) {
                        $q->where('name', 'like', "%{$keyword}%");
                    });
                })
                ->filterColumn('company_name', function ($query, $keyword) {
                    $query->whereHas('customerInsurance.company', function ($q) use ($keyword) {
                        $q->where('name', 'like', "%{$keyword}%");
                    });
                })
                ->filterColumn('agent_id', function ($query, $keyword) {
                    $query->where('agent_rep_code', 'like', "%{$keyword}%");
                })

                ->addIndexColumn()
                ->addColumn('customer_id', fn($row) => $row->customerInsurance->id ?? '-')
                ->addColumn('customer_name', fn($row) => $row->customerInsurance->customer->name ?? '-')
                ->addColumn('company_name', fn($row) => $row->customerInsurance->company->name ?? '-')
                ->addColumn('agent_id', fn($row) => $row->agent_rep_code ?? 'N/A')
                ->addColumn('net', fn($row) => 'Rs.' . number_format($row->net_premium, 2))
                ->addColumn('srcc', fn($row) => 'Rs.' . number_format($row->srcc_premium, 2))
                ->addColumn('tc', fn($row) => 'Rs.' . number_format($row->tc_premium, 2))
                ->addColumn('total', fn($row) => '<strong>Rs.' . number_format($row->total, 2) . '</strong>')
                ->addColumn('status', function ($row) {
                    $badge = $row->status === 'Completed' ? 'success' : 'danger';
                    return '<span class="badge bg-' . $badge . '">' . $row->status . '</span>';
                })

                ->addColumn('action', function ($row) {
                    $view = '<a href="' . route('customerinsurance.show', $row->customerInsurance->id) . '" class="btn btn-sm btn-primary action-btn" title="View"><i class="icon-eye"></i></a>';
                    return '<div class="d-flex gap-1 align-items-center">' . $view . '</div>';
                })
                ->rawColumns(['total', 'status', 'action'])
                ->make(true);
        }

        // Load customers and companies for filters
        $customerIds = AgentCommission::with('customerInsurance.customer')
            ->get()
            ->pluck('customerInsurance.customer.id')
            ->unique();

        $companyIds = AgentCommission::with('customerInsurance.company')
            ->get()
            ->pluck('customerInsurance.company.id')
            ->unique();

        $customers = Customer::whereIn('id', $customerIds)->orderBy('name')->get();
        $companies = Company::whereIn('id', $companyIds)->orderBy('name')->get();

        return view('commission.agent', compact('customers', 'companies'));
    }




    public function subagentIndex(Request $request)
    {
        $customerInsurances = CustomerInsurance::with('agent')->get();
        $newlyCreatedIds = [];

        foreach ($customerInsurances as $insurance) {
            $profitMargins = ProfitMargin::where('company_id', $insurance->insurance_company)
                ->where('insurance_type_id', $insurance->insurance_type)
                ->where(function ($query) use ($insurance) {
                    $query->whereNull('category_id')->orWhere('category_id', $insurance->category);
                })
                ->where(function ($query) use ($insurance) {
                    $query->whereNull('sub_category_id')->orWhere('sub_category_id', $insurance->subcategory);
                })
                ->where(function ($query) use ($insurance) {
                    $query->whereNull('form_field_id')->orWhere('form_field_id', $insurance->varietyfields);
                })
                ->get();

            $net = $srcc = $tc = 0;

            foreach ($profitMargins as $margin) {
                $rate = floatval($margin->sub_agent);
                switch ($margin->profit_type) {
                    case 'Net Premium':
                        $net += ($rate / 100) * $insurance->basic;
                        break;
                    case 'RCC':
                        $srcc += ($rate / 100) * $insurance->srcc;
                        break;
                    case 'TC':
                        $tc += ($rate / 100) * $insurance->tc;
                        break;
                }
            }

            $status = ($insurance->premium_type === 'Debit') ? 'Pending' : 'Completed';
            $total = $net + $srcc + $tc;

            $updated = SubAgentCommission::updateOrCreate(
                ['customer_insurance_id' => $insurance->id],
                [
                    'sub_agent_rep_code' => $insurance->subagent_code ?? null,
                    'net_premium' => round($net, 2),
                    'srcc_premium' => round($srcc, 2),
                    'tc_premium' => round($tc, 2),
                    'total' => round($total, 2),
                    'status' => $status,
                ]
            );

            $newlyCreatedIds[] = $updated->id;
        }

        if ($request->ajax()) {
            $data = SubAgentCommission::with(['customerInsurance.customer', 'customerInsurance.company'])->latest();

            if ($request->has('customer_id') && $request->customer_id != '') {
                $data->whereHas('customerInsurance.customer', function ($q) use ($request) {
                    $q->where('id', $request->customer_id);
                });
            }

            if ($request->has('company_id') && $request->company_id != '') {
                $data->whereHas('customerInsurance.company', function ($q) use ($request) {
                    $q->where('id', $request->company_id);
                });
            }

            // Apply insurance date filter
            if ($request->from_date && $request->to_date) {
                $data->whereBetween('created_at', [$request->from_date, $request->to_date]);
            }

            return DataTables::of($data)
                ->filterColumn('customer_name', function ($query, $keyword) {
                    $query->whereHas('customerInsurance.customer', function ($q) use ($keyword) {
                        $q->where('name', 'like', "%{$keyword}%");
                    });
                })
                ->filterColumn('company_name', function ($query, $keyword) {
                    $query->whereHas('customerInsurance.company', function ($q) use ($keyword) {
                        $q->where('name', 'like', "%{$keyword}%");
                    });
                })
                ->filterColumn('sub_agent_id', function ($query, $keyword) {
                    $query->where('sub_agent_rep_code', 'like', "%{$keyword}%");
                })

                ->addIndexColumn()
                ->addColumn('customer_id', fn($row) => $row->customerInsurance->id ?? '-')
                ->addColumn('customer_name', fn($row) => $row->customerInsurance->customer->name ?? '-')
                ->addColumn('company_name', fn($row) => $row->customerInsurance->company->name ?? '-')
                ->addColumn('sub_agent_id', fn($row) => $row->sub_agent_rep_code ?? '-')
                ->addColumn('net', fn($row) => 'Rs.' . number_format($row->net_premium, 2))
                ->addColumn('srcc', fn($row) => 'Rs.' . number_format($row->srcc_premium, 2))
                ->addColumn('tc', fn($row) => 'Rs.' . number_format($row->tc_premium, 2))
                ->addColumn('total', fn($row) => '<strong>Rs.' . number_format($row->total, 2) . '</strong>')
                ->addColumn('status', function ($row) {
                    $badge = $row->status === 'Completed' ? 'success' : 'danger';
                    return '<span class="badge bg-' . $badge . '">' . $row->status . '</span>';
                })
                ->addColumn('action', function ($row) {
                    $view = '<a href="' . route('customerinsurance.show', $row->customerInsurance->id) . '" class="btn btn-sm btn-primary action-btn" title="View"><i class="icon-eye"></i></a>';
                    return '<div class="d-flex gap-1 align-items-center">' . $view . '</div>';
                })
                ->rawColumns(['total', 'status', 'action'])
                ->make(true);
        }

        // Load customer and company filters
        $customerIds = SubAgentCommission::with('customerInsurance.customer')
            ->get()
            ->pluck('customerInsurance.customer.id')
            ->unique();

        $companyIds = SubAgentCommission::with('customerInsurance.company')
            ->get()
            ->pluck('customerInsurance.company.id')
            ->unique();

        $customers = Customer::whereIn('id', $customerIds)->orderBy('name')->get();
        $companies = Company::whereIn('id', $companyIds)->orderBy('name')->get();

        return view('commission.sub_agent', compact('customers', 'companies'));
    }


    //rep commission side

    public function repagentIndex(Request $request)
    {
        $rep = Auth::guard('rep')->user();

        if (!$rep || $rep->role !== 'agent') {
            return abort(403, 'Unauthorized. Only agents can view this page.');
        }

        // Recalculate commissions for this agent's assigned insurances
        $customerInsurances = CustomerInsurance::with('agent')
            ->whereHas('agent', function ($query) use ($rep) {
                $query->where('rep_code', $rep->code);
            })
            ->get();

        $newlyCreatedIds = [];

        foreach ($customerInsurances as $insurance) {
            $profitMargins = ProfitMargin::where('company_id', $insurance->insurance_company)
                ->where('insurance_type_id', $insurance->insurance_type)
                ->where(function ($query) use ($insurance) {
                    $query->whereNull('category_id')->orWhere('category_id', $insurance->category);
                })
                ->where(function ($query) use ($insurance) {
                    $query->whereNull('sub_category_id')->orWhere('sub_category_id', $insurance->subcategory);
                })
                ->where(function ($query) use ($insurance) {
                    $query->whereNull('form_field_id')->orWhere('form_field_id', $insurance->varietyfields);
                })
                ->get();

            $net = $srcc = $tc = 0;
            foreach ($profitMargins as $margin) {
                $rate = floatval($margin->main_agent);
                switch ($margin->profit_type) {
                    case 'Net Premium':
                        $net += ($rate / 100) * $insurance->basic;
                        break;
                    case 'RCC':
                        $srcc += ($rate / 100) * $insurance->srcc;
                        break;
                    case 'TC':
                        $tc += ($rate / 100) * $insurance->tc;
                        break;
                }
            }

            $status = ($insurance->premium_type === 'Debit') ? 'Pending' : 'Completed';
            $total = $net + $srcc + $tc;

            $updated = AgentCommission::updateOrCreate(
                ['customer_insurance_id' => $insurance->id],
                [
                    'agent_rep_code' => $insurance->agent->rep_code ?? null,
                    'net_premium' => round($net, 2),
                    'srcc_premium' => round($srcc, 2),
                    'tc_premium' => round($tc, 2),
                    'total' => round($total, 2),
                    'status' => $status,
                ]
            );

            $newlyCreatedIds[] = $updated->id;
        }

        // AJAX DataTables request with filters
        if ($request->ajax()) {
            $query = AgentCommission::with(['customerInsurance.customer', 'customerInsurance.company'])
                ->where('agent_rep_code', $rep->code)
                ->latest();

            if ($request->filled('customer_id')) {
                $query->whereHas('customerInsurance.customer', function ($q) use ($request) {
                    $q->where('id', $request->customer_id);
                });
            }

            if ($request->filled('company_id')) {
                $query->whereHas('customerInsurance.company', function ($q) use ($request) {
                    $q->where('id', $request->company_id);
                });
            }

            // Apply insurance date filter
            if ($request->from_date && $request->to_date) {
                $query->whereBetween('created_at', [$request->from_date, $request->to_date]);
            }

            return DataTables::of($query)
                ->filterColumn('customer_name', function ($query, $keyword) {
                    $query->whereHas('customerInsurance.customer', function ($q) use ($keyword) {
                        $q->where('name', 'like', "%{$keyword}%");
                    });
                })
                ->filterColumn('company_name', function ($query, $keyword) {
                    $query->whereHas('customerInsurance.company', function ($q) use ($keyword) {
                        $q->where('name', 'like', "%{$keyword}%");
                    });
                })
                ->filterColumn('agent_id', function ($query, $keyword) {
                    $query->where('agent_rep_code', 'like', "%{$keyword}%");
                })

                ->addIndexColumn()
                ->addColumn('customer_id', fn($row) => $row->customerInsurance->id ?? '-')
                ->addColumn('customer_name', fn($row) => $row->customerInsurance->customer->name ?? '-')
                ->addColumn('company_name', fn($row) => $row->customerInsurance->company->name ?? '-')
                ->addColumn('agent_id', fn($row) => $row->agent_rep_code ?? 'N/A')
                ->addColumn('net', fn($row) => 'Rs.' . number_format($row->net_premium, 2))
                ->addColumn('srcc', fn($row) => 'Rs.' . number_format($row->srcc_premium, 2))
                ->addColumn('tc', fn($row) => 'Rs.' . number_format($row->tc_premium, 2))
                ->addColumn('total', fn($row) => '<strong>Rs.' . number_format($row->total, 2) . '</strong>')
                ->addColumn('status', function ($row) {
                    $badge = $row->status === 'Completed' ? 'success' : 'danger';
                    return '<span class="badge bg-' . $badge . '">' . $row->status . '</span>';
                })
                ->addColumn('action', function ($row) {
                    $view = '<a href="' . route('rep.commissions.show', $row->customerInsurance->id) . '" class="btn btn-sm btn-primary action-btn" title="View"><i class="icon-eye"></i></a>';
                    return '<div class="d-flex gap-1 align-items-center">' . $view . '</div>';
                })
                ->rawColumns(['total', 'status', 'action'])
                ->make(true);
        }


        // For filter dropdowns, get customers and companies related to this agent's commissions
        $customerIds = AgentCommission::where('agent_rep_code', $rep->code)
            ->with('customerInsurance.customer')
            ->get()
            ->pluck('customerInsurance.customer.id')
            ->unique()
            ->filter()
            ->values();

        $companyIds = AgentCommission::where('agent_rep_code', $rep->code)
            ->with('customerInsurance.company')
            ->get()
            ->pluck('customerInsurance.company.id')
            ->unique()
            ->filter()
            ->values();

        $customers = Customer::whereIn('id', $customerIds)->orderBy('name')->get();
        $companies = Company::whereIn('id', $companyIds)->orderBy('name')->get();

        return view('RepDashboard.commission.agent', compact('customers', 'companies'));
    }



    public function repsubagentIndex(Request $request)
    {
        $rep = Auth::guard('rep')->user();

        if (!$rep || $rep->role !== 'subagent') {
            return abort(403, 'Unauthorized. Only sub-agents can view this page.');
        }

        // Recalculate commissions
        $customerInsurances = CustomerInsurance::with('agent')
            ->whereHas('agent', function ($query) use ($rep) {
                $query->where('rep_code', $rep->code);
            })
            ->get();

        foreach ($customerInsurances as $insurance) {
            $profitMargins = ProfitMargin::where('company_id', $insurance->insurance_company)
                ->where('insurance_type_id', $insurance->insurance_type)
                ->where(function ($query) use ($insurance) {
                    $query->whereNull('category_id')->orWhere('category_id', $insurance->category);
                })
                ->where(function ($query) use ($insurance) {
                    $query->whereNull('sub_category_id')->orWhere('sub_category_id', $insurance->subcategory);
                })
                ->where(function ($query) use ($insurance) {
                    $query->whereNull('form_field_id')->orWhere('form_field_id', $insurance->varietyfields);
                })
                ->get();

            $net = $srcc = $tc = 0;

            foreach ($profitMargins as $margin) {
                $rate = floatval($margin->sub_agent);
                switch ($margin->profit_type) {
                    case 'Net Premium':
                        $net += ($rate / 100) * $insurance->basic;
                        break;
                    case 'RCC':
                        $srcc += ($rate / 100) * $insurance->srcc;
                        break;
                    case 'TC':
                        $tc += ($rate / 100) * $insurance->tc;
                        break;
                }
            }

            $status = ($insurance->premium_type === 'Debit') ? 'Pending' : 'Completed';
            $total = $net + $srcc + $tc;

            SubAgentCommission::updateOrCreate(
                ['customer_insurance_id' => $insurance->id],
                [
                    'sub_agent_rep_code' => $rep->code,
                    'net_premium' => round($net, 2),
                    'srcc_premium' => round($srcc, 2),
                    'tc_premium' => round($tc, 2),
                    'total' => round($total, 2),
                    'status' => $status,
                ]
            );
        }

        if ($request->ajax()) {
            $query = SubAgentCommission::with(['customerInsurance.customer', 'customerInsurance.company'])
                ->where('sub_agent_rep_code', $rep->code)
                ->latest();

            // Apply dropdown filters
            if ($request->filled('customer_id')) {
                $query->whereHas('customerInsurance.customer', function ($q) use ($request) {
                    $q->where('id', $request->customer_id);
                });
            }

            if ($request->filled('company_id')) {
                $query->whereHas('customerInsurance.company', function ($q) use ($request) {
                    $q->where('id', $request->company_id);
                });
            }

            // Apply insurance date filter
            if ($request->from_date && $request->to_date) {
                $query->whereBetween('created_at', [$request->from_date, $request->to_date]);
            }

            // Handle global search from DataTables
            if (!empty($request->input('search.value'))) {
                $search = $request->input('search.value');

                $query->where(function ($q) use ($search) {
                    $q->whereHas('customerInsurance.customer', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%{$search}%");
                    })
                        ->orWhereHas('customerInsurance.company', function ($q2) use ($search) {
                            $q2->where('name', 'like', "%{$search}%");
                        })
                        ->orWhere('sub_agent_rep_code', 'like', "%{$search}%")
                        ->orWhere('net_premium', 'like', "%{$search}%")
                        ->orWhere('srcc_premium', 'like', "%{$search}%")
                        ->orWhere('tc_premium', 'like', "%{$search}%")
                        ->orWhere('total', 'like', "%{$search}%")
                        ->orWhere('status', 'like', "%{$search}%");
                });
            }

            return datatables()->of($query)
                ->addIndexColumn()
                ->addColumn('customer_insurance_id', fn($row) => optional($row->customerInsurance)->id ?? '-')
                ->addColumn('customer_name', fn($row) => optional(optional($row->customerInsurance)->customer)->name ?? '-')
                ->addColumn('company_name', fn($row) => optional(optional($row->customerInsurance)->company)->name ?? '-')
                ->addColumn('sub_agent_id', fn($row) => $row->sub_agent_rep_code ?? '-')
                ->addColumn('net_premium', fn($row) => 'Rs.' . number_format($row->net_premium, 2))
                ->addColumn('srcc_premium', fn($row) => 'Rs.' . number_format($row->srcc_premium, 2))
                ->addColumn('tc_premium', fn($row) => 'Rs.' . number_format($row->tc_premium, 2))
                ->addColumn('total', fn($row) => '<strong>Rs.' . number_format($row->total, 2) . '</strong>')
                ->addColumn('status', function ($row) {
                    $badge = $row->status === 'Completed' ? 'success' : 'danger';
                    return '<span class="badge bg-' . $badge . '">' . $row->status . '</span>';
                })
                ->addColumn('action', function ($row) {
                    $view = '<a href="' . route('rep.commissions.show', $row->customerInsurance->id) . '" class="btn btn-sm btn-primary action-btn" title="View"><i class="icon-eye"></i></a>';
                    return '<div class="d-flex gap-1 align-items-center">' . $view . '</div>';
                })
                ->rawColumns(['total', 'status', 'action'])
                ->make(true);
        }


        // For filter dropdowns - Fix the data retrieval
        $commissions = SubAgentCommission::where('sub_agent_rep_code', $rep->code)
            ->with(['customerInsurance.customer', 'customerInsurance.company'])
            ->get();

        $customerIds = $commissions->map(function ($commission) {
            return $commission->customerInsurance && $commission->customerInsurance->customer
                ? $commission->customerInsurance->customer->id
                : null;
        })->filter()->unique()->values();

        $companyIds = $commissions->map(function ($commission) {
            return $commission->customerInsurance && $commission->customerInsurance->company
                ? $commission->customerInsurance->company->id
                : null;
        })->filter()->unique()->values();

        $customers = Customer::whereIn('id', $customerIds)->orderBy('name')->get();
        $companies = Company::whereIn('id', $companyIds)->orderBy('name')->get();

        return view('RepDashboard.commission.sub_agent', compact('customers', 'companies'));
    }

    public function show(string $id)
    {
        $customerinsurance = CustomerInsurance::find($id);
        return view('RepDashboard.commission.show', compact('customerinsurance'));
    }
}
