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
                ->rawColumns(['total', 'status'])
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

        return DataTables::of($data)
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
            ->rawColumns(['total', 'status'])
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

        return DataTables::of($data)
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
            ->rawColumns(['total', 'status'])
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

    public function repagentIndex()
    {
        $rep = Auth::guard('rep')->user();

        if (!$rep || $rep->role !== 'agent') {
            return abort(403, 'Unauthorized. Only agents can view this page.');
        }

        // Get only customer insurances assigned to the logged-in agent
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

        // Load only this agent's commissions
        $commissionRecords = AgentCommission::where('agent_rep_code', $rep->code)->latest()->get();
        $newCommissions = AgentCommission::whereIn('id', $newlyCreatedIds)
            ->where('agent_rep_code', $rep->code)
            ->get();

        return view('RepDashboard.commission.agent', compact('commissionRecords', 'newCommissions'));
    }


    public function repsubagentIndex()
    {
        $rep = Auth::guard('rep')->user();

        // Ensure only sub agents can access this method
        if (!$rep || $rep->role !== 'subagent') {
            return abort(403, 'Unauthorized. Only sub-agents can view this page.');
        }

        // Load all customer insurances assigned to this sub agent (by rep code)
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
                    'sub_agent_rep_code' => $rep->code, // Use logged-in sub agent's code
                    'net_premium' => round($net, 2),
                    'srcc_premium' => round($srcc, 2),
                    'tc_premium' => round($tc, 2),
                    'total' => round($total, 2),
                    'status' => $status,
                ]
            );

            $newlyCreatedIds[] = $updated->id;
        }

        // Show only this sub agent’s commissions
        $allCommissions = SubAgentCommission::with('customerInsurance')
            ->where('sub_agent_rep_code', $rep->code)
            ->latest()
            ->get();

        $newCommissions = SubAgentCommission::whereIn('id', $newlyCreatedIds)
            ->where('sub_agent_rep_code', $rep->code)
            ->get();

        return view('RepDashboard.commission.sub_agent', compact('allCommissions', 'newCommissions'));
    }
}
