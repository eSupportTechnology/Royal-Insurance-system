<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InsuranceType extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function categories()
    {
        return $this->hasMany(Category::class);
    }
    public function subCategories()
    {
        return $this->hasMany(SubCategory::class);
    }
    public function formFields()
    {
        return $this->hasMany(FormField::class);
    }
}
