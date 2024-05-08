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
        Schema::create('devolutions', function (Blueprint $table) {
            $table->id();
            $table->text('payload_pix');
            $table->text('numbers');
            $table->integer('amount');
            $table->integer('quantity');

            $table->bigInteger('participant_id');
            $table->foreign('participant_id', 'devolutions_participant_id_fkey')->references('id')->on('participants');

            $table->bigInteger('charge_id');
            $table->foreign('charge_id', 'devolutions_charge_id_fkey')->references('id')->on('charges');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devolutions');
    }
};
