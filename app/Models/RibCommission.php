<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RibCommission extends Model
{
    protected $fillable = [
        'customer_insurance_id',
        'net_premium',
        'srcc_premium',
        'tc_premium',
        'total',
        'status',
    ];

    public function customerInsurance()
    {
        return $this->belongsTo(CustomerInsurance::class);
    }

    public function customer(){
        return $this->belongsTo(Customer::class, 'name', 'id');
    }

    public function company(){
        return $this->belongsTo(Company::class, 'insurance_company', 'id');
    }
}


