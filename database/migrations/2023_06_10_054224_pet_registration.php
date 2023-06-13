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
        Schema::create('pet_registrations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('owner_id');
            $table->string('pet_name');
            $table->unsignedBigInteger('pet_type_id');
            $table->timestamps();

            $table->foreign('owner_id')->references('id')->on('pet_owners')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('pet_type_id')->references('id')->on('pet_types')->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pet_registration');
    }
};
