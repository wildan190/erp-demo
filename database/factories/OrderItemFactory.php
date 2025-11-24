<?php

namespace Database\Factories;

use App\Models\OrderItem;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderItemFactory extends Factory
{
    protected $model = OrderItem::class;

    public function definition(): array
    {
        $product = Product::factory();
        $qty = fake()->numberBetween(1, 5);
        $price = fake()->randomFloat(2, 1, 500);

        return [
            'order_id' => Order::factory(),
            'product_id' => $product,
            'quantity' => $qty,
            'price' => $price,
            'total' => $qty * $price,
        ];
    }
}
