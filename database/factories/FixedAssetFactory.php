<?php

namespace Database\Factories;

use App\Models\FixedAsset;
use Illuminate\Database\Eloquent\Factories\Factory;

class FixedAssetFactory extends Factory
{
    protected $model = FixedAsset::class;

    public function definition(): array
    {
        return [
            'asset_name' => fake()->word() . ' Asset',
            'description' => fake()->optional()->sentence(),
            'asset_number' => strtoupper(fake()->unique()->bothify('ASSET-###')),
            'acquisition_date' => fake()->date(),
            'cost' => fake()->randomFloat(2, 100, 20000),
            'salvage_value' => fake()->randomFloat(2, 0, 1000),
            'useful_life_years' => fake()->numberBetween(1, 20),
            'depreciation_method' => fake()->randomElement(['straight_line','declining_balance']),
            'current_value' => fake()->randomFloat(2, 0, 20000),
            'disposal_date' => null,
        ];
    }
}
