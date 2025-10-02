<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\PropertyAd;
use App\Models\CommercialProperty;
use App\Models\IndustrialProperty;
use App\Models\LandProperty;
use App\Models\PropertyImage;


class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory(10)->create()->each(function($user) {

            $property = PropertyAd::factory()->for($user)->create();

            switch ($property->property_type) {
                case 'commercial':
                    CommercialProperty::factory()->for($property, 'property')->create();
                    break;

                case 'industrial':
                    IndustrialProperty::factory()->for($property, 'property')->create();
                    break;

                case 'land':
                    LandProperty::factory()->for($property, 'property')->create();
                    break;
            }

            PropertyImage::factory(rand(1,5))->for($property, 'property')->create();

        });
    }
}
