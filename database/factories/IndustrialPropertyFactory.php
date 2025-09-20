<?php

namespace Database\Factories;

use App\Models\IndustrialProperty;
use App\Models\PropertyAd;
use Illuminate\Database\Eloquent\Factories\Factory;

class IndustrialPropertyFactory extends Factory
{
    protected $model = IndustrialProperty::class;

    public function definition(): array
    {
        return [
            'property_id' => PropertyAd::factory(),
            'total_area' => $this->faker->randomFloat(2, 500, 20000),
            'power_capacity' => $this->faker->randomFloat(2, 50, 2000),
            'ceiling_height' => $this->faker->randomFloat(2, 3, 12),
            'floor_load_capacity' => $this->faker->randomFloat(2, 100, 1000),
            'crane_availability' => $this->faker->boolean,
            'waste_disposal' => $this->faker->boolean,
            'access_roads' => json_encode($this->faker->randomElements(['Main Road', 'Side Road'], 2)),
            'safety_certifications' => json_encode($this->faker->randomElements(['ISO 9001', 'OSHA', 'LEED'], 2)),

        ];
    }
}
