<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerResponse extends Model
{
    use HasFactory;

    protected $fillable = ['sub_category_id', 'customer_id', 'field_id', 'value'];

    public function field()
{
    return $this->belongsTo(FormField::class, 'field_id');
}

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id'); // Assuming customers are stored in the users table
    }
}
