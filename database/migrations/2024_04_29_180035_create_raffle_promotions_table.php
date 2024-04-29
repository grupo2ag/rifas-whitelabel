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
        Schema::create('raffle_promotions', function (Blueprint $table) {
            $table->id();
            $table->integer('quantity_numbers')->comment("quantidade de numeros para ativar a promocao");
            $table->integer('ordem')->comment("ordem de exibicao");
            $table->integer('discount')->comment("valor do desconto em porcentagem");
            $table->integer('amount')->comment("valor final com desconto");
            $table->bigInteger('raffle_id');

            $table->foreign('raffle_id', 'raffle_promotions_raffle_id_fkey')->references('id')->on('raffles');

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
        Schema::dropIfExists('raffle_promotions');
    }
};
