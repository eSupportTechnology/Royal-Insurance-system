<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerResponseField extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_response_id',
        'form_field_id',
        'response'
    ];

    public function customerResponse()
    {
        return $this->belongsTo(CustomerResponse::class);
    }

    public function formField()
    {
        return $this->belongsTo(FormField::class);
    }

    


}
