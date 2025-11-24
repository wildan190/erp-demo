<?php

namespace Database\Factories;

use App\Models\FollowUp;
use App\Models\User;
use App\Models\Lead;
use App\Models\Opportunity;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class FollowUpFactory extends Factory
{
    protected $model = FollowUp::class;

    public function definition(): array
    {
        $types = [Lead::class, Opportunity::class, Customer::class];
        $type = fake()->randomElement($types);

        return [
            'user_id' => User::factory(),
            'followupable_type' => $type,
            'followupable_id' => $type::factory(),
            'type' => fake()->randomElement(['call','email','meeting']),
            'notes' => fake()->sentence(),
            'scheduled_date' => fake()->date(),
            'is_completed' => fake()->boolean(20),
        ];
    }
}
