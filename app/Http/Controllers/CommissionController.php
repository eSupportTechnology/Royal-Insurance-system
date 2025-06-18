<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use Illuminate\Http\Request;
use App\Models\CustomerInsurance;
use App\Models\ProfitMargin;

class CommissionController extends Controller
{
    public function ribIndex()
    {
        $customerInsurances = CustomerInsurance::all();
        $commissions = [];

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

            $netPremiumCommission = 0;
            $srccPremiumCommission = 0;
            $tcPremiumCommission = 0;

            foreach ($profitMargins as $margin) {
                $rib = floatval($margin->rib); // Ensure numeric
                switch ($margin->profit_type) {
                    case 'Net Premium':
                        $netPremiumCommission += ($rib / 100) * $insurance->basic;
                        break;
                    case 'RCC':
                        $srccPremiumCommission += ($rib / 100) * $insurance->srcc;
                        break;
                    case 'TC':
                        $tcPremiumCommission += ($rib / 100) * $insurance->tc;
                        break;
                }
            }
            $status = ($insurance->premium_type == 'Debit') ? 'Pending' : 'Completed';

            $totalCommission = $netPremiumCommission + $srccPremiumCommission + $tcPremiumCommission;

            $commissions[] = [
                'insurance' => $insurance,
                'netPremiumCommission' => round($netPremiumCommission, 2),
                'srccPremiumCommission' => round($srccPremiumCommission, 2),
                'tcPremiumCommission' => round($tcPremiumCommission, 2),
                'totalCommission' => round($totalCommission, 2),
                'status' => $status
            ];
        }

        return view('commission.rib', compact('commissions'));
    }

    public function agentIndex()
    {
        $customerInsurances = CustomerInsurance::all();
        $commissions = [];

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

            $netPremiumCommission = 0;
            $srccPremiumCommission = 0;
            $tcPremiumCommission = 0;

            foreach ($profitMargins as $margin) {
                $main_agent = floatval($margin->main_agent); // Ensure numeric
                switch ($margin->profit_type) {
                    case 'Net Premium':
                        $netPremiumCommission += ($main_agent / 100) * $insurance->basic;
                        break;
                    case 'RCC':
                        $srccPremiumCommission += ($main_agent / 100) * $insurance->srcc;
                        break;
                    case 'TC':
                        $tcPremiumCommission += ($main_agent / 100) * $insurance->tc;
                        break;
                }
            }
            $status = ($insurance->premium_type == 'Debit') ? 'Pending' : 'Completed';

            $totalCommission = $netPremiumCommission + $srccPremiumCommission + $tcPremiumCommission;
            $agents = Agent::all();
            $commissions[] = [
                'insurance' => $insurance,
                'netPremiumCommission' => round($netPremiumCommission, 2),
                'srccPremiumCommission' => round($srccPremiumCommission, 2),
                'tcPremiumCommission' => round($tcPremiumCommission, 2),
                'totalCommission' => round($totalCommission, 2),
                'status' => $status,
                'agents' => $agents
            ];
        }

        return view('commission.agent', compact('commissions'));
    }

    public function subagentIndex()
    {
        $customerInsurances = CustomerInsurance::all();
        $commissions = [];

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

            $netPremiumCommission = 0;
            $srccPremiumCommission = 0;
            $tcPremiumCommission = 0;

            foreach ($profitMargins as $margin) {
                $sub_agent = floatval($margin->sub_agent); // Ensure numeric
                switch ($margin->profit_type) {
                    case 'Net Premium':
                        $netPremiumCommission += ($sub_agent / 100) * $insurance->basic;
                        break;
                    case 'RCC':
                        $srccPremiumCommission += ($sub_agent / 100) * $insurance->srcc;
                        break;
                    case 'TC':
                        $tcPremiumCommission += ($sub_agent / 100) * $insurance->tc;
                        break;
                }
            }
            $status = ($insurance->premium_type == 'Debit') ? 'Pending' : 'Completed';

            $totalCommission = $netPremiumCommission + $srccPremiumCommission + $tcPremiumCommission;
            $agents = Agent::all();
            $commissions[] = [
                'insurance' => $insurance,
                'netPremiumCommission' => round($netPremiumCommission, 2),
                'srccPremiumCommission' => round($srccPremiumCommission, 2),
                'tcPremiumCommission' => round($tcPremiumCommission, 2),
                'totalCommission' => round($totalCommission, 2),
                'status' => $status,
                'agents' => $agents
            ];
        }

        return view('commission.sub_agent', compact('commissions'));
    }
}
