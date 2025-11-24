<?php

namespace Database\Factories;

use App\Models\Opportunity;
use App\Models\Customer;
use App\Models\Lead;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OpportunityFactory extends Factory
{
    protected $model = Opportunity::class;

    public function definition(): array
    {
        return [
            'name' => fake()->sentence(3),
            'customer_id' => Customer::factory(),
            'lead_id' => Lead::factory(),
            'user_id' => User::factory(),
            'expected_revenue' => fake()->randomFloat(2, 100, 10000),
            'close_date' => fake()->optional()->date(),
            'stage' => fake()->randomElement(['prospect','proposal','negotiation','won','lost']),
            'probability' => fake()->randomFloat(2, 0, 1),
            'notes' => fake()->optional()->sentence(),
        ];
    }
}
