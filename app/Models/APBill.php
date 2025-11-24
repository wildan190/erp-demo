<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class APBill extends Model
{
    use HasFactory;

    protected $table = 'ap_bills';

    protected $fillable = [
        'supplier_id',
        'bill_number',
        'bill_date',
        'due_date',
        'total_amount',
        'status',
        'invoice_id',
        'paid_at',
        'notes',
    ];

    protected $casts = [
        'bill_date' => 'date',
        'due_date' => 'date',
        'paid_at' => 'datetime',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function items()
    {
        return $this->hasMany(APBillItem::class, 'ap_bill_id');
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }

    public function payments()
    {
        return $this->hasMany(APPayment::class, 'ap_bill_id');
    }

    /**
     * Mark the AP bill as paid (or partially paid) based on recorded payments.
     */
    public function refreshPaymentStatus()
    {
        $paid = $this->payments()->sum('amount');
        if ($paid <= 0) {
            $this->update(['status' => 'unpaid', 'paid_at' => null]);
            return;
        }

        if ($paid >= $this->total_amount) {
            $this->update(['status' => 'paid', 'paid_at' => now()]);
        } else {
            $this->update(['status' => 'partially_paid', 'paid_at' => null]);
        }
    }
}
