<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuotationDetail extends Model
{
    protected $fillable = [
        'quotation_comparison_id',
        'company_id',
        'package_name',
        'package_description',
    ];

    public function comparison()
    {
        return $this->belongsTo(QuotationComparison::class);
    }

    public function company()
    {
        return $this->belongsTo(InsuranceCompany::class);
    }
}
