<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'username' => $this->faker->unique()->userName(),
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => bcrypt('password'), // Default password
            'role' => $this->faker->randomElement(['admin', 'member']),
            'profile_photo_path' => null, // Or: $this->faker->image('storage/app/public/profile-photos', 200, 200, null, false)
        ];
    }
}
