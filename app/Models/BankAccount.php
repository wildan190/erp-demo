<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'bank_name',
        'account_name',
        'account_number',
        'currency',
        'opening_balance',
        'current_balance',
    ];

    public function bankTransactions()
    {
        return $this->hasMany(BankTransaction::class);
    }
}
