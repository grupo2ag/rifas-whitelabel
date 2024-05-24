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
            $table->bigInteger('affiliate_id')->nullable()->index();
            $table->foreign('affiliate_id', 'participants_affiliate_id_fkey')->references('id')->on('affiliates');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('participants', function (Blueprint $table) {
            $table->dropForeign('participants_affiliate_id_fkey');
            $table->dropColumn('affiliate_id');
        });
    }
};
