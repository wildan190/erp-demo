<?php

namespace Database\Factories;

use App\Models\DeliveryOrder;
use App\Models\Order;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class DeliveryOrderFactory extends Factory
{
    protected $model = DeliveryOrder::class;

    public function definition(): array
    {
        return [
            'order_id' => Order::factory(),
            'customer_id' => Customer::factory(),
            'delivery_number' => 'DO-' . fake()->unique()->numerify('######'),
            'delivery_date' => fake()->date(),
            'status' => fake()->randomElement(['pending','shipped','delivered']),
            'shipping_address' => fake()->optional()->address(),
            'notes' => fake()->optional()->sentence(),
        ];
    }
}
