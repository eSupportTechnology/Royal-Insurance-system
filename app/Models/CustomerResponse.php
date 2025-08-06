<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerResponse extends Model
{
    use HasFactory;

    protected $fillable = [
        'agent_id',
        'insurance_type_id',
        'category_id',
        'sub_category_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'status',
        'date'
    ];

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function responseFields()
    {
        return $this->hasMany(CustomerResponseField::class);
    }

    public function insuranceType()
    {
        return $this->belongsTo(InsuranceType::class, 'insurance_type_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id');
    }


}
