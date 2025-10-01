<?php

namespace Database\Factories;

use App\Models\PropertyAd;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PropertyAdFactory extends Factory
{
    protected $model = PropertyAd::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'property_type' => $this->faker->randomElement(['residential','commercial','land','industrial']),
            'price' => $this->faker->randomFloat(2, 50000, 5000000),
            'status' => $this->faker->randomElement(['available','sold','inactive']),
            'address_line_1' => $this->faker->streetAddress,
            'address_line_2' => $this->faker->secondaryAddress,
            'city' => $this->faker->city,
            'province' => $this->faker->state,
            'postal_code' => $this->faker->postcode,
            'latitude' => $this->faker->latitude,
            'longitude' => $this->faker->longitude,
            'user_id' => User::factory(),
        ];
    }
}
