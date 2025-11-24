<?php

namespace Database\Factories;

use App\Models\PurchaseItem;
use App\Models\Purchase;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class PurchaseItemFactory extends Factory
{
    protected $model = PurchaseItem::class;

    public function definition(): array
    {
        $qty = fake()->numberBetween(1, 20);
        $price = fake()->randomFloat(2, 1, 500);

        return [
            'purchase_id' => Purchase::factory(),
            'product_id' => Product::factory(),
            'quantity' => $qty,
            'price' => $price,
            'total' => $qty * $price,
        ];
    }
}
