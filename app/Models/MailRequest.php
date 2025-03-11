<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MailRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'company_email',
        'make',
        'year',
        'vehicle_number',
        'usage',
        'vehicle_value',
        'financial_interest',
        'fuel_type',
        'customer_id',
        'email',
        'phone',
        'nic',
        'address',
    ];

    protected $casts = [
        'company_email' => 'array',
    ];


    public function customer()
{
    return $this->belongsTo(Customer::class, 'customer_id');
}

}
