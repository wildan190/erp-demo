<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use App\Models\ARPaymentReceived;


class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id','invoice_number','amount','status','issued_at','paid_at'
    ];

    protected static function booted()
    {
        static::creating(function ($invoice) {
            if (empty($invoice->invoice_number)) {
                $invoice->invoice_number = 'INV-' . strtoupper(Str::random(8));
            }
        });
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Payments received for this invoice
     */
    public function payments()
    {
        return $this->hasMany(ARPaymentReceived::class, 'invoice_id');
    }

    /**
     * Remaining amount (amount - sum(payments))
     */
    public function getRemainingAmountAttribute()
    {
        $paid = $this->payments()->sum('amount');
        return max(0, $this->amount - $paid);
    }
}
