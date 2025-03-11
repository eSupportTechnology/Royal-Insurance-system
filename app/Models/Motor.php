<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Motor extends Model
{
    use HasFactory;
    protected $table = "motors";
    protected $primaryKey = 'id';

    protected $fillable = ['make', 'model', 'year', 'vehicle_number', 'class', 'usage', 'vehicle_value', 'financial_interest', 'fuel_type', 'customer_id', 'email', 'phone', 'nic', 'address', 'id_number', 'location', 'other_details', 'vehicle_copy', 'id_copy', 'renewal_copy', 'vehical_pic', 'client_letter', 'other_doc','status'];
}
