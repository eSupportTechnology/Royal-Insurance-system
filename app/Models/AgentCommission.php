<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgentCommission extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_insurance_id',
        'agent_rep_code',
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
