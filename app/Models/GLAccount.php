<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GLAccount extends Model
{
    use HasFactory;

    protected $table = 'gl_accounts';

    protected $fillable = [
        'account_number',
        'account_name',
        'account_type',
        'parent_account_id',
        'is_contra',
    ];

    public function parentAccount()
    {
        return $this->belongsTo(GLAccount::class, 'parent_account_id');
    }

    public function childAccounts()
    {
        return $this->hasMany(GLAccount::class, 'parent_account_id');
    }

    public function childrenRecursive()
    {
        return $this->childAccounts()->with('childrenRecursive');
    }

    public function transactionItems()
    {
        return $this->hasMany(GLTransactionItem::class, 'gl_account_id');
    }
}
