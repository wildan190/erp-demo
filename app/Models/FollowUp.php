<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FollowUp extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'followupable_id',
        'followupable_type',
        'type',
        'notes',
        'scheduled_date',
        'is_completed',
    ];

    protected $casts = [
        'scheduled_date' => 'date',
        'is_completed' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function followupable()
    {
        return $this->morphTo();
    }
}
