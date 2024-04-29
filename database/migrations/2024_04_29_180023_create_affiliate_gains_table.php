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
        Schema::create('affiliate_gains', function (Blueprint $table) {
            $table->id();
            $table->integer('amount')->nullable();
            $table->bigInteger('participant_id');
            $table->bigInteger('raffle_id');
            $table->bigInteger('affiliate_id');
            $table->smallInteger('paied')->default(0)->comment("comissao paga");

            $table->index(['raffle_id', 'affiliate_id'], 'affiliate_gains_raffle_id_affiliate_id_fkey');
            $table->foreign('participant_id', 'affiliate_gains_participant_id_fkey')->references('id')->on('participants');
            $table->foreign(['raffle_id', 'affiliate_id'], 'affiliate_gains_raffle_id_affiliate_id_fkey')->references(['affiliate_id', 'raffle_id'])->on('affiliate_raffles');
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
        Schema::dropIfExists('affiliate_gains');
    }
};
