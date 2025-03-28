<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuatationOption extends Model
{
    use HasFactory;

    protected $fillable = [
        'quotation_id',
        'option_value',
    ];

    public function quotation()
    {
        return $this->belongsTo(Quatation::class);
    }
}
