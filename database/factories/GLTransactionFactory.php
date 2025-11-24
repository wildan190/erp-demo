<?php

namespace Database\Factories;

use App\Models\GLTransaction;
use Illuminate\Database\Eloquent\Factories\Factory;

class GLTransactionFactory extends Factory
{
    protected $model = GLTransaction::class;

    public function definition(): array
    {
        return [
            'transaction_date' => fake()->date(),
            'reference' => fake()->optional()->lexify('REF-????'),
            'description' => fake()->sentence(),
        ];
    }
}
