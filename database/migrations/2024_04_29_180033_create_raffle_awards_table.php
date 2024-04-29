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
        Schema::create('raffle_awards', function (Blueprint $table) {
            $table->id();
            $table->integer('ordem')->nullable();
            $table->text('descricao');
            $table->text('winner_name')->nullable();
            $table->text('winner_image')->nullable();
            $table->string('winner_phone')->nullable();
            $table->integer('number_award')->nullable()->comment("numero ganhador");
            $table->bigInteger('raffle_id');

            $table->foreign('raffle_id', 'raffle_awards_raffle_id_fkey')->references('id')->on('raffles');

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
        Schema::dropIfExists('raffle_awards');
    }
};
