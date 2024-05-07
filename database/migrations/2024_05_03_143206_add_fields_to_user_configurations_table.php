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
        Schema::table('user_configurations', function (Blueprint $table) {
            $table->string('whatsapp')->nullable();
            $table->string('telegram')->nullable();
            $table->tinyInteger('register_cpf')->default(0);
            $table->tinyInteger('register_email')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_configurations', function (Blueprint $table) {
            $table->dropColumn('whatsapp');
            $table->dropColumn('telegram');
            $table->dropColumn('register_cpf');
            $table->dropColumn('register_email');
        });
    }
};
