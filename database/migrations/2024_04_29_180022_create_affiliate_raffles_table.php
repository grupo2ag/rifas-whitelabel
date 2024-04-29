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
        Schema::create('affiliate_raffles', function (Blueprint $table) {
            $table->bigInteger('affiliate_id');
            $table->bigInteger('raffle_id');
            $table->smallInteger('actived')->default(0);
            $table->string('type')->default('percent')->comment("percent\nvalue");
            $table->integer('value')->nullable();

            $table->primary(['affiliate_id', 'raffle_id']);
            $table->foreign('affiliate_id', 'affiliate_raffles_affiliate_id_fkey')->references('id')->on('affiliates');
            $table->foreign('raffle_id', 'affiliate_raffles_raffle_id_fkey')->references('id')->on('raffles');
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
        Schema::dropIfExists('affiliate_raffles');
    }
};
