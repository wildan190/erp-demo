<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GLTransactionItem extends Model
{
    use HasFactory;

    protected $table = 'gl_transaction_items';

    protected $fillable = [
        'gl_transaction_id',
        'gl_account_id',
        'debit',
        'credit',
    ];

    public function glTransaction()
    {
        return $this->belongsTo(GLTransaction::class, 'gl_transaction_id');
    }

    public function glAccount()
    {
        return $this->belongsTo(GLAccount::class, 'gl_account_id');
    }
}
