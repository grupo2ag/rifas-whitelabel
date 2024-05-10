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
        Schema::table('raffle_promotions', function (Blueprint $table) {
            $table->boolean('is_popular')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('raffle_promotions', function (Blueprint $table) {
            $table->dropColumn('is_popular');
        });
    }
};
