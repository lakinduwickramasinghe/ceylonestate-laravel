<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('land_properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained('property_ads')->onDelete('cascade');
            $table->decimal('land_size', 12, 2);
            $table->enum('zoning', ['residential','commercial','agricultural','industrial','mixed']);
            $table->decimal('road_frontage', 8, 2)->nullable();
            $table->json('utilities')->nullable();
            $table->string('soil_type', 100)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('land_properties');
    }
};
