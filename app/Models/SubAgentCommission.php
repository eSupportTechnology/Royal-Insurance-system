<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubAgentCommission extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_insurance_id',
        'sub_agent_rep_code',
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
}
