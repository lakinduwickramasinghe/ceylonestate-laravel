<?php

namespace Database\Factories;

use App\Models\Feedback;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class FeedbackFactory extends Factory
{
    protected $model = Feedback::class;

    public function definition(): array
    {
        return [
            'userid' => User::factory(), // ensure feedback is tied to a user
            'rating' => $this->faker->numberBetween(1, 5),
            'message' => $this->faker->sentence(12),
        ];
    }
}
