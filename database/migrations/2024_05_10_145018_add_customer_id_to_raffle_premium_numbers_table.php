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
        Schema::table('raffle_premium_numbers', function (Blueprint $table) {
            $table->unsignedBigInteger('customer_id')->nullable()->after('raffle_id');
            $table->foreign('customer_id')->references('id')->on('customers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('raffle_premium_numbers', function (Blueprint $table) {
            $table->dropForeign('raffle_premium_numbers_customer_id_foreign');
            $table->dropColumn('customer_id');
        });
    }
};
