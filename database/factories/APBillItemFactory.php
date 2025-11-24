<?php

namespace Database\Factories;

use App\Models\APBillItem;
use App\Models\APBill;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class APBillItemFactory extends Factory
{
    protected $model = APBillItem::class;

    public function definition(): array
    {
        $qty = fake()->numberBetween(1, 10);
        $price = fake()->randomFloat(2, 1, 500);

        return [
            'ap_bill_id' => APBill::factory(),
            'product_id' => Product::factory(),
            'description' => fake()->optional()->sentence(),
            'quantity' => $qty,
            'unit_price' => $price,
            'total' => $qty * $price,
        ];
    }
}
