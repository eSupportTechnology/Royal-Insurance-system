<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Health extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'age',
        'nic',
        'address',
        'weight',
        'contact_number',
        'blood_group'
    ];
}
