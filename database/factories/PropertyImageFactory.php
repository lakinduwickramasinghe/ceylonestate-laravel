<?php

namespace Database\Factories;

use App\Models\PropertyImage;
use App\Models\PropertyAd;
use Illuminate\Database\Eloquent\Factories\Factory;

class PropertyImageFactory extends Factory
{
    protected $model = PropertyImage::class;

    public function definition(): array
    {
        return [
            'property_id' => PropertyAd::factory(),
            'imagepath' => $this->faker->imageUrl(640, 480, 'building'),
            'order' => $this->faker->numberBetween(0, 10),
            'is_main' => $this->faker->boolean,
        ];
    }
}
