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
        Schema::table('raffles', function (Blueprint $table) {
            $table->unsignedBigInteger('raffle_promotion_id')->nullable();
            $table->foreign('raffle_promotion_id')->references('id')->on('raffle_promotions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('raffles', function (Blueprint $table) {
            $table->dropForeign('raffles_raffle_promotion_id_foreign');
            $table->dropColumn('raffle_promotion_id');
        });
    }
};
