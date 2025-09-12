<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('residential_properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained('property_ads')->onDelete('cascade');
            $table->tinyInteger('bedrooms')->unsigned();
            $table->decimal('bathrooms', 3, 1)->unsigned()->nullable();
            $table->decimal('floor_area', 10, 2)->nullable();
            $table->decimal('lot_size', 10, 2)->nullable();
            $table->year('year_built')->nullable();
            $table->tinyInteger('floors')->unsigned()->nullable();
            $table->tinyInteger('parking_spaces')->unsigned()->nullable();
            $table->boolean('balcony')->default(false);
            $table->string('heating_cooling', 100)->nullable();
            $table->json('amenities')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('residential_properties');
    }
};
