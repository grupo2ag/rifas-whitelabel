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
        Schema::table('participants', function (Blueprint $table) {
            $table->bigInteger('raffle_promotion_id')->nullable();
            $table->foreign('raffle_promotion_id')->references('id')->on('raffle_promotions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('participants', function (Blueprint $table) {
            $table->dropForeign('participants_raffle_promotion_id_foreign');
            $table->dropColumn('raffle_promotion_id');
        });
    }
};
