<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('car_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_id')->constrained('car_brands')->cascadeOnDelete();
            $table->string('name');
            $table->string('registration_number');
            $table->boolean('is_available');
            $table->unsignedBigInteger('price');
            $table->string('color');
            $table->enum('type', ['sedan', 'suv', 'pickup', 'mpv']);
            $table->string('photo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('car_types');
    }
};
