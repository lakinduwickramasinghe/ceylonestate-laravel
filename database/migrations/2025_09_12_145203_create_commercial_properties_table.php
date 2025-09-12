<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('commercial_properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained('property_ads')->onDelete('cascade');
            $table->decimal('floor_area', 10, 2)->nullable();
            $table->tinyInteger('number_of_floors')->unsigned()->nullable();
            $table->tinyInteger('parking_spaces')->unsigned()->nullable();
            $table->decimal('power_capacity', 10, 2)->nullable();
            $table->string('business_type', 100)->nullable();
            $table->tinyInteger('loading_docks')->unsigned()->nullable();
            $table->tinyInteger('conference_rooms')->unsigned()->nullable();
            $table->json('accessibility_features')->nullable();
            $table->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('commercial_properties');
    }
};
