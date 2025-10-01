<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('industrial_properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained('property_ads')->onDelete('cascade');
            $table->decimal('total_area', 12, 2);
            $table->decimal('power_capacity', 10, 2)->nullable();
            $table->decimal('ceiling_height', 6, 2)->nullable();
            $table->decimal('floor_load_capacity', 8, 2)->nullable();
            $table->boolean('crane_availability')->default(false);
            $table->json('access_roads')->nullable();
            $table->string('waste_disposal')->default(false);
            $table->json('safety_certifications')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('industrial_properties');
    }
};
