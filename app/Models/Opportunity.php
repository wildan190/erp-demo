<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Opportunity extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'customer_id',
        'lead_id',
        'user_id',
        'expected_revenue',
        'close_date',
        'stage',
        'probability',
        'notes',
    ];

    protected $casts = [
        'close_date' => 'date',
        'probability' => 'float',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function followUps()
    {
        return $this->morphMany(FollowUp::class, 'followupable');
    }
}
