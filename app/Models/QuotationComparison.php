<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuotationComparison extends Model
{
    protected $fillable = ['customer_response_id'];

    public function response()
    {
        return $this->belongsTo(CustomerResponse::class, 'customer_response_id');
    }

    public function details()
    {
        return $this->hasMany(QuotationDetail::class);
    }
}
