<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarBrand extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'logo'];

    public function carType()
    {
        return $this->hasMany(CarType::class, 'brand_id');
    }
}
