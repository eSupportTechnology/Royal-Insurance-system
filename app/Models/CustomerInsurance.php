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
        'class',
        'insurance_company',
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
        'introducer_code'
    ];

}
