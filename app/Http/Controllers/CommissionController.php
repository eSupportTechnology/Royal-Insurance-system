<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\AgentCommission;
use Illuminate\Http\Request;
use App\Models\CustomerInsurance;
use App\Models\ProfitMargin;
use App\Models\RibCommission;
use App\Models\SubAgentCommission;

class CommissionController extends Controller
{
    public function ribIndex()
    {
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
                $rib = floatval($margin->rib); // Use rib field
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

            $latest = RibCommission::where('customer_insurance_id', $insurance->id)
                ->latest()
                ->first();

            $hasChanges = !$latest ||
                round($latest->net_premium, 2) !== round($net, 2) ||
                round($latest->srcc_premium, 2) !== round($srcc, 2) ||
                round($latest->tc_premium, 2) !== round($tc, 2) ||
                round($latest->total, 2) !== round($total, 2) ||
                $latest->status !== $status;

            if ($hasChanges) {
                $new = RibCommission::create([
                    'customer_insurance_id' => $insurance->id,
                    'net_premium' => round($net, 2),
                    'srcc_premium' => round($srcc, 2),
                    'tc_premium' => round($tc, 2),
                    'total' => round($total, 2),
                    'status' => $status,
                ]);
                $newlyCreatedIds[] = $new->id;
            }
        }

        $allCommissions = RibCommission::with('customerInsurance')->latest()->get();
        $newCommissions = RibCommission::whereIn('id', $newlyCreatedIds)->get();

        return view('commission.rib', compact('allCommissions', 'newCommissions'));
    }



    public function agentIndex()
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

            $latest = AgentCommission::where('customer_insurance_id', $insurance->id)
                ->latest()
                ->first();

            // Check for changes
            $hasChanges = !$latest ||
                round($latest->net_premium, 2) !== round($net, 2) ||
                round($latest->srcc_premium, 2) !== round($srcc, 2) ||
                round($latest->tc_premium, 2) !== round($tc, 2) ||
                round($latest->total, 2) !== round($total, 2) ||
                $latest->status !== $status;

            if ($hasChanges) {
                $new = AgentCommission::create([
                    'customer_insurance_id' => $insurance->id,
                    'agent_rep_code' => $insurance->agent->rep_code ?? null,
                    'net_premium' => round($net, 2),
                    'srcc_premium' => round($srcc, 2),
                    'tc_premium' => round($tc, 2),
                    'total' => round($total, 2),
                    'status' => $status,
                ]);

                $newlyCreatedIds[] = $new->id;
            }
        }

        // Get all commission records
        $commissionRecords = AgentCommission::latest()->get();

        // Also get only newly created ones to highlight in view
        $newCommissions = AgentCommission::whereIn('id', $newlyCreatedIds)->get();

        return view('commission.agent', compact('commissionRecords', 'newCommissions'));
    }




    public function subagentIndex()
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

            $latest = SubAgentCommission::where('customer_insurance_id', $insurance->id)
                ->latest()
                ->first();

            $hasChanges = !$latest ||
                round($latest->net_premium, 2) !== round($net, 2) ||
                round($latest->srcc_premium, 2) !== round($srcc, 2) ||
                round($latest->tc_premium, 2) !== round($tc, 2) ||
                round($latest->total, 2) !== round($total, 2) ||
                $latest->status !== $status;

            if ($hasChanges) {
                $new = SubAgentCommission::create([
                    'customer_insurance_id' => $insurance->id,
                    'sub_agent_rep_code' => $insurance->agent->rep_code ?? null,
                    'net_premium' => round($net, 2),
                    'srcc_premium' => round($srcc, 2),
                    'tc_premium' => round($tc, 2),
                    'total' => round($total, 2),
                    'status' => $status,
                ]);
                $newlyCreatedIds[] = $new->id;
            }
        }

        $allCommissions = SubAgentCommission::with('customerInsurance')->latest()->get();
        $newCommissions = SubAgentCommission::whereIn('id', $newlyCreatedIds)->get();

        return view('commission.sub_agent', compact('allCommissions', 'newCommissions'));
    }
}
