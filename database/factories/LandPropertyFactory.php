<?php

namespace Database\Factories;

use App\Models\LandProperty;
use App\Models\PropertyAd;
use Illuminate\Database\Eloquent\Factories\Factory;

class LandPropertyFactory extends Factory
{
    protected $model = LandProperty::class;

    public function definition(): array
    {
        return [
            'property_id' => PropertyAd::factory(),
            'land_size' => $this->faker->randomFloat(2, 500, 10000),
            'zoning' => $this->faker->randomElement(['residential','commercial','agricultural','industrial','mixed']),
            'road_frontage' => $this->faker->randomFloat(2, 10, 200),
            'utilities' => json_encode($this->faker->randomElements(['Electricity', 'Water', 'Gas', 'Internet'], 3)),
            'soil_type' => $this->faker->randomElement(['Clay', 'Sandy', 'Loam', 'Silt']),
        ];
    }
}
