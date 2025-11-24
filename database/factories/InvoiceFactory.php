<?php

namespace Database\Factories;

use App\Models\Invoice;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class InvoiceFactory extends Factory
{
    protected $model = Invoice::class;

    public function definition(): array
    {
        $order = Order::factory();
        return [
            'order_id' => $order,
            'invoice_number' => 'INV-' . strtoupper(fake()->lexify('????????')),
            'amount' => 0,
            'status' => fake()->randomElement(['unpaid','paid']),
            'issued_at' => fake()->dateTimeBetween('-1 years','now'),
            'paid_at' => null,
        ];
    }
}
