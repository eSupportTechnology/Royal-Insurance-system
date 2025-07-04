<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'representator',
        'logo',
        'address',
        'email',
        'contact_number',
        'insurance_type',
        'status',
        'pinned',
    ];

    public function allActive(){
        return $this->where('status', 1)->get(); //filter active records
    }

    public function profitMargine(){
        return $this->belongsTo(ProfitMargin::class);
    }


}
