<?php

namespace Database\Factories;

use App\Models\ResidentialProperty;
use Illuminate\Database\Eloquent\Factories\Factory;

class ResidentialPropertyFactory extends Factory
{
    protected $model = ResidentialProperty::class;

    public function definition(): array
    {
        return [
            'bedrooms' => $this->faker->numberBetween(1, 6),
            'bathrooms' => $this->faker->numberBetween(1, 4),
            'floor_area' => $this->faker->numberBetween(500, 5000),
            'lot_size' => $this->faker->numberBetween(1000, 10000),
            'year_built' => $this->faker->year(),
            'floors' => $this->faker->numberBetween(1, 3),
            'parking_spaces' => $this->faker->numberBetween(0, 4),
            'balcony' => $this->faker->boolean(),
            'heating_cooling' => $this->faker->randomElement(['AC','Heater','Central']),
            'amenities' => $this->faker->words(3, true),
        ];
    }
}
