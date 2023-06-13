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
        Schema::create('pet_food_prices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pet_food_id');
            $table->timestamps();

            $table->foreign('pet_food_id')->references('id')->on('pet_foods')->onUpdate('cascade')->onDelete('restrict');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pet_food_prices');
    }
};
