<?php

namespace Database\Factories;

use App\Models\CarBrand;
use Faker\Provider\FakeCar;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CarType>
 */
class CarTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $carBrands = CarBrand::get()->pluck('id')->toArray();
        $name = $this->faker->randomElement([
            'Corolla Altis', 'Grandmax', 'Rocky', 'Sigra', 'Accord', 'Civic', 'HRV', 'Mobilio', 'Santa Fe', 'Xpander', 'Ertiga', 'Carry', 'Avanza', 'Camry', 'Fortuner', 'Hilux'
        ]);
        $this->faker->addProvider(new FakeCar($this->faker));

        return [
            'brand_id' => $this->faker->randomElement($carBrands),
            'name' => $name,
            'registration_number' => $this->faker->vehicleRegistration(),
            'is_available' => $this->faker->boolean(),
            'color' => $this->faker->colorName(),
            'type' => $this->faker->randomElement(['sedan', 'suv', 'pickup', 'mpv']),
            'price' => $this->faker->numberBetween(1000000,5000000),
        ];
    }
}
