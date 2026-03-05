<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Faker\Factory as Faker;
use Faker\Provider\FakeCar;

class CarType extends Model
{
    use HasFactory;
    protected $fillable = ['brand_id', 'name', 'is_available', 'price', 'photo', 'registration_number', 'color', 'type'];

    public function invoice()
    {
        return $this->hasOne(Invoice::class, 'car_type_id');
    }

    public function carBrand()
    {
        return $this->belongsTo(CarBrand::class, 'brand_id');
    }

    public static function booted()
    {
        static::creating(function ($carType) {
            $faker = Faker::create();
            $faker->addProvider(new FakeCar($faker));
            $carType->registration_number = $faker->vehicleRegistration();
        });
    }
}
