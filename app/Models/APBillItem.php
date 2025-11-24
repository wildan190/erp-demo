<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class APBillItem extends Model
{
    use HasFactory;

    protected $table = 'ap_bill_items';

    protected $fillable = [
        'ap_bill_id',
        'product_id',
        'description',
        'quantity',
        'unit_price',
        'total',
    ];

    public function apBill()
    {
        return $this->belongsTo(APBill::class, 'ap_bill_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
