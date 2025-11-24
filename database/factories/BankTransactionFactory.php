<?php

namespace Database\Factories;

use App\Models\BankTransaction;
use App\Models\BankAccount;
use App\Models\GLTransaction;
use Illuminate\Database\Eloquent\Factories\Factory;

class BankTransactionFactory extends Factory
{
    protected $model = BankTransaction::class;

    public function definition(): array
    {
        return [
            'bank_account_id' => BankAccount::factory(),
            'transaction_date' => fake()->date(),
            'description' => fake()->sentence(),
            'amount' => fake()->randomFloat(2, 1, 5000),
            'type' => fake()->randomElement(['deposit','withdrawal']),
            'is_reconciled' => fake()->boolean(30),
            'gl_transaction_id' => null,
        ];
    }
}
