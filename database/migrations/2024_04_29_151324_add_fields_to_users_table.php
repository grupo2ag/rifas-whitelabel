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
        Schema::table('users', function (Blueprint $table) {
            $table->smallInteger('level')->comment("Level para o login\n0 - ADMIN\n1 - RIFEIRO");
            $table->text('domain')->nullable();
            $table->string('document', 45)->nullable();
            $table->string('phone', 45)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('level');
            $table->dropColumn('domain');
            $table->dropColumn('document');
            $table->dropColumn('phone');
        });
    }
};
