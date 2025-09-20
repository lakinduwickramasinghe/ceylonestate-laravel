<?php

namespace Database\Factories;

use App\Models\CommercialProperty;
use App\Models\PropertyAd;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommercialPropertyFactory extends Factory
{
    protected $model = CommercialProperty::class;

    public function definition(): array
    {
        return [
            'property_id' => PropertyAd::factory(),
            'floor_area' => $this->faker->randomFloat(2, 100, 10000),
            'number_of_floors' => $this->faker->numberBetween(1, 10),
            'parking_spaces' => $this->faker->numberBetween(0, 100),
            'power_capacity' => $this->faker->randomFloat(2, 50, 1000),
            'business_type' => $this->faker->company,
            'loading_docks' => $this->faker->numberBetween(0, 10),
            'conference_rooms' => $this->faker->numberBetween(0, 5),
           'accessibility_features' => json_encode($this->faker->randomElements(['Wheelchair Ramp', 'Elevator', 'Accessible Restroom'], 2)),

        ];
    }
}
