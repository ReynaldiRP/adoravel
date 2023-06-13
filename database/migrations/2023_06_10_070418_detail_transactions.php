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
        Schema::create('detail_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transaction_id');
            $table->unsignedBigInteger('pet_registration_id');
            $table->unsignedBigInteger('service_id');
            $table->unsignedBigInteger('pet_food_id');
            $table->integer('quantity');
            $table->double('total_amount');
            $table->timestamps();

            $table->foreign('transaction_id')->references('id')->on('transactions')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('pet_registration_id')->references('id')->on('pet_registrations')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('service_id')->references('id')->on('service_prices')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('pet_food_id')->references('id')->on('pet_food_prices')->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_transactions');
    }
};
