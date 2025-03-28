<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quatation extends Model
{
    use HasFactory;

    protected $fillable = ['insurance_company_id', 'package_name', 'package_type', 'required'];

    public function options()
    {
        return $this->hasMany(QuatationOption::class);
    }
}


