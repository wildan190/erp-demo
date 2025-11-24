<?php

namespace Database\Factories;

use App\Models\APBill;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

class APBillFactory extends Factory
{
    protected $model = APBill::class;

    public function definition(): array
    {
        $billDate = fake()->date();
        $dueDate = fake()->dateTimeBetween($billDate, '+60 days')->format('Y-m-d');

        return [
            'supplier_id' => Supplier::factory(),
            'bill_number' => 'APB-' . fake()->unique()->numerify('######'),
            'bill_date' => $billDate,
            'due_date' => $dueDate,
            'total_amount' => 0,
            'status' => 'unpaid',
            'notes' => fake()->optional()->sentence(),
        ];
    }
}
