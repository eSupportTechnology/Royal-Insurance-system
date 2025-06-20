<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    use HasFactory;

    protected $fillable = [
        'rep_code','name', 'email', 'phone', 'address'
    ];

    public function subagents()
    {
        return $this->hasMany(SubAgent::class);
    }
}
