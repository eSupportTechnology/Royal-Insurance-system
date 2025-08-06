<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class RepAuth extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'code',
        'role',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function agent()
    {
        return $this->hasOne(Agent::class, 'rep_code', 'code');
    }

    public function subAgent()
    {
        return $this->hasOne(SubAgent::class, 'sub_agent_rep_code', 'code');
    }
}
