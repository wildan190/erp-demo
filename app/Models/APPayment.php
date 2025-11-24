<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class APPayment extends Model
{
    use HasFactory;

    protected $table = 'ap_payments';

    protected $fillable = [
        'ap_bill_id',
        'payment_number',
        'amount',
        'payment_date',
        'bank_account_id',
        'notes',
    ];

    protected $casts = [
        'payment_date' => 'date',
        'amount' => 'decimal:2',
    ];

    public function apBill()
    {
        return $this->belongsTo(APBill::class, 'ap_bill_id');
    }

    public function bankAccount()
    {
        return $this->belongsTo(BankAccount::class, 'bank_account_id');
    }
}
