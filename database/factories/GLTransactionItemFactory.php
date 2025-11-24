<?php

namespace Database\Factories;

use App\Models\GLTransactionItem;
use App\Models\GLTransaction;
use App\Models\GLAccount;
use Illuminate\Database\Eloquent\Factories\Factory;

class GLTransactionItemFactory extends Factory
{
    protected $model = GLTransactionItem::class;

    public function definition(): array
    {
        $debit = fake()->randomFloat(2, 0, 1000);
        $credit = fake()->boolean(50) ? 0 : $debit;

        return [
            'gl_transaction_id' => GLTransaction::factory(),
            'gl_account_id' => GLAccount::factory(),
            'debit' => $debit,
            'credit' => $credit,
        ];
    }
}
