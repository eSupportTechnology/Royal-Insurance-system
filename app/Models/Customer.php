<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'nic',
        'address',
        'whatsapp_number',
        'job'
    ];
    public function customer_insurances()
    {
        return $this->hasMany(CustomerInsurance::class);
    }
}
