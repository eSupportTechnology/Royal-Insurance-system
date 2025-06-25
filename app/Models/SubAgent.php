<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubAgent extends Model
{
    protected $fillable = [
        'agent_id',
        'sub_agent_name',
        'email',
        'phone',
        'address',
        
    ];

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }
}
