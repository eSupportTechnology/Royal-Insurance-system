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
        'name',
        'id_number',
    ];

    protected $casts = [
        'company_email' => 'array',
    ];
}
