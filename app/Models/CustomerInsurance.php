<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerInsurance extends Model
{
    protected $fillable = [
        'inv',
        'date',
        'name',
        'policy',
        'dn',
        'vehicle',
        'insurance_company',
        'insurance_type',
        'category',
        'subcategory',
        'varietyfields',
        'basic',
        'srcc',
        'tc',
        'others',
        'total',
        'sum_insured',
        'paid_amount',
        'outstanding_amount',
        'from_date',
        'to_date',
        'contact',
        'whatsapp',
        'address',
        'introducer_code',
        'subagent_code',
        'premium_type',
        'status',

    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'name', 'id');
    }

    public function insuranceType()
    {
        return $this->belongsTo(InsuranceType::class, 'insurance_type', 'id');
    }
    public function categories()
{
    return $this->belongsTo(Category::class, 'category', 'id');
}

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class, 'subcategory', 'id');
    }
    public function formField()
    {
        return $this->belongsTo(FormField::class, 'varietyfields', 'id');
    }
    public function company()
    {
        return $this->belongsTo(Company::class, 'insurance_company', 'id');
    }
    public function subagent()
    {
        return $this->belongsTo(SubAgent::class, 'subagent_code', 'id');
    }
    public function agent()
{
    return $this->belongsTo(Agent::class, 'introducer_code', 'id');
}

}
