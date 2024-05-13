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
        Schema::create('raffle_popular_numbers', function (Blueprint $table) {
            $table->id();

            $table->integer('quantity_numbers')->comment("quantidade do card");
            $table->boolean('popular')->default(0);
            $table->bigInteger('raffle_id');

            $table->foreign('raffle_id', 'raffle_popular_numbers_raffle_id_fkey')->references('id')->on('raffles');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('raffle_popular_numbers');
    }
};
