<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FixedAsset extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_name',
        'description',
        'asset_number',
        'acquisition_date',
        'cost',
        'salvage_value',
        'useful_life_years',
        'depreciation_method',
        'current_value',
        'disposal_date',
    ];

    protected $casts = [
        'acquisition_date' => 'date',
        'disposal_date' => 'date',
    ];
}
