<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GLTransaction extends Model
{
    use HasFactory;

    protected $table = 'gl_transactions';

    protected $fillable = [
        'transaction_date',
        'reference',
        'description',
    ];

    protected $casts = [
        'transaction_date' => 'date',
    ];

    public function items()
    {
        return $this->hasMany(GLTransactionItem::class, 'gl_transaction_id');
    }
}
