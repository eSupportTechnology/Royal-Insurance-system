<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'insurance_type_id'];

    public function insuranceType()
    {
        return $this->belongsTo(InsuranceType::class);
    }

    public function subCategories()
    {
        return $this->hasMany(SubCategory::class);
    }
    public function customerResponses()
    {
        return $this->hasMany(CustomerResponse::class);
    }
    public function formFields()
    {
        return $this->hasMany(FormField::class);
    }
    public function customer_insurances()
    {
        return $this->hasMany(CustomerInsurance::class);
    }
}


