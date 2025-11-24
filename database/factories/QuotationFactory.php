<?php

namespace Database\Factories;

use App\Models\Quotation;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuotationFactory extends Factory
{
    protected $model = Quotation::class;

    public function definition(): array
    {
        $qDate = fake()->date();
        $validUntil = fake()->dateTimeBetween($qDate, '+30 days')->format('Y-m-d');

        return [
            'customer_id' => Customer::factory(),
            'user_id' => User::factory(),
            'quotation_number' => 'QT-' . fake()->unique()->numerify('######'),
            'quotation_date' => $qDate,
            'valid_until' => $validUntil,
            'status' => fake()->randomElement(['draft','sent','accepted','rejected']),
            'total_amount' => fake()->randomFloat(2, 0, 10000),
            'notes' => fake()->optional()->sentence(),
        ];
    }
}
