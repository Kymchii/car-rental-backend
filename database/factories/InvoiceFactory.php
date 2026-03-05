<?php

namespace Database\Factories;

use App\Models\CarType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $invoiceNumber = 'INV-' . date('Ymd') . '-' . $this->faker->unique()->numberBetween(1000, 9999);
        $userId = User::get()->pluck('id')->toArray();
        $carTypeId = CarType::get()->pluck('id')->toArray();
        return [
            'invoice_number' => $invoiceNumber,
            'user_id' => $this->faker->randomElement($userId),
            'car_type_id' => $this->faker->randomElement($carTypeId),
            'start_at' => $this->faker->date('Y-m-d', 'now'),
            'end_of' => $this->faker->date('Y-m-d'),
            'payment' => false,
        ];
    }
}
