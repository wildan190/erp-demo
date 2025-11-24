<?php

namespace Database\Factories;

use App\Models\InventoryMovement;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class InventoryMovementFactory extends Factory
{
    protected $model = InventoryMovement::class;

    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'quantity' => fake()->numberBetween(1, 50),
            'type' => fake()->randomElement(['in','out','adjustment']),
            'note' => fake()->optional()->sentence(),
        ];
    }
}
