<?php

namespace Database\Factories;

use App\Models\ARPaymentReceived;
use App\Models\Invoice;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class ARPaymentReceivedFactory extends Factory
{
    protected $model = ARPaymentReceived::class;

    public function definition(): array
    {
        return [
            'invoice_id' => Invoice::factory(),
            'customer_id' => Customer::factory(),
            'payment_number' => 'PAY-' . fake()->unique()->numerify('######'),
            'amount' => fake()->randomFloat(2, 1, 5000),
            'payment_date' => fake()->date(),
            'payment_method' => fake()->randomElement(['cash','bank_transfer','credit_card']),
            'notes' => fake()->optional()->sentence(),
        ];
    }
}
