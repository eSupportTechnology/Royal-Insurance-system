<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormFieldOption extends Model
{
    use HasFactory;

    protected $fillable = ['form_field_id', 'option_value'];

    public function formField()
    {
        return $this->belongsTo(FormField::class);
    }
}
