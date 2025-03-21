<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormField extends Model
{
    use HasFactory;

    protected $fillable = ['insurance_type_id', 'category_id', 'sub_category_id', 'field_name', 'field_type', 'required'];

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function customerResponses()
    {
        return $this->hasMany(CustomerResponse::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function insuranceType()
    {
        return $this->belongsTo(InsuranceType::class);
    }
}
