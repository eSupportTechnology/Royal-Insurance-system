<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerInsurance extends Model
{
    protected $fillable = [
        'inv',
        'date',
        'customer_id',
        'policy',
        'dn',
        'vehicle',
        'insurance_company',
        'insurance_type',
        'category',
        'sub_category',
        'form_field',
        'rep',
        'basic',
        'srcc',
        'tc',
        'others',
        'total',
        'sum_insured',
        'from_date',
        'to_date',
        'contact',
        'address',
        'agent_code',
        'sub_agent_code',
        'status'

    ];

}
