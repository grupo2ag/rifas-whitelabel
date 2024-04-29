<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('raffle_images', function (Blueprint $table) {
            $table->id();
            $table->text('path')->nullable();
            $table->bigInteger('raffle_id');

            $table->foreign('raffle_id', 'raffle_images_raffle_id_fkey')->references('id')->on('raffles');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('raffle_images');
    }
};
