<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rental_properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained('property_ads')->onDelete('cascade');
            $table->enum('rent_frequency', ['monthly','yearly','quarterly','weekly']);
            $table->decimal('rent_amount', 12, 2);
            $table->decimal('deposit_amount', 12, 2)->nullable();
            $table->string('lease_term', 50)->nullable();
            $table->date('available_from')->nullable();
            $table->enum('furnished', ['unfurnished','semi','furnished'])->nullable();
            $table->json('utilities_included')->nullable();
            $table->text('other_conditions')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rental_properties');
    }
};
