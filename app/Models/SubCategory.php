<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name','insurance_type_id','category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function insuranceType()
    {
        return $this->belongsTo(InsuranceType::class);
    }

    public function formFields()
    {
        return $this->hasMany(FormField::class);
    }

    public function customerResponses()
    {
        return $this->hasMany(CustomerResponse::class);
    }
}
