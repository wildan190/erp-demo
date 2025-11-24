<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'bank_account_id',
        'transaction_date',
        'description',
        'amount',
        'type',
        'is_reconciled',
        'gl_transaction_id',
    ];

    protected $casts = [
        'transaction_date' => 'date',
        'is_reconciled' => 'boolean',
    ];

    public function bankAccount()
    {
        return $this->belongsTo(BankAccount::class);
    }

    public function glTransaction()
    {
        return $this->belongsTo(GLTransaction::class, 'gl_transaction_id');
    }
}
