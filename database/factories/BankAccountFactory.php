<?php

namespace Database\Factories;

use App\Models\BankAccount;
use Illuminate\Database\Eloquent\Factories\Factory;

class BankAccountFactory extends Factory
{
    protected $model = BankAccount::class;

    public function definition(): array
    {
        $opening = fake()->randomFloat(2, 0, 10000);

        return [
            'bank_name' => fake()->company() . ' Bank',
            'account_name' => fake()->name(),
            'account_number' => fake()->bankAccountNumber(),
            'currency' => fake()->currencyCode(),
            'opening_balance' => $opening,
            'current_balance' => $opening,
        ];
    }
}
