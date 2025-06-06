<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfitMargin extends Model
{
    protected $fillable = [
        'company_id',
        'insurance_type_id',
        'category_id',
        'sub_category_id',
        'form_field_id',
        'profit_type',
        'total',
        'rib',
        'main_agent',
        'sub_agent',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function insurance_type()
    {
        return $this->belongsTo(InsuranceType::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function sub_category()
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function form_field()
    {
        return $this->belongsTo(FormField::class);
    }
}
