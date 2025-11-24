<?php

namespace Database\Factories;

use App\Models\GLAccount;
use Illuminate\Database\Eloquent\Factories\Factory;

class GLAccountFactory extends Factory
{
    protected $model = GLAccount::class;

    public function definition(): array
    {
        return [
            'account_number' => fake()->unique()->numerify('4###'),
            'account_name' => fake()->word() . ' Account',
            'account_type' => fake()->randomElement(['asset','liability','equity','income','expense']),
            'parent_account_id' => null,
            'is_contra' => fake()->boolean(10),
        ];
    }
}
