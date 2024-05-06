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
        Schema::table('gateways', function (Blueprint $table) {
            $table->string('endpoint_sandbox')->nullable();
            $table->string('auth_sandbox')->nullable();
            $table->string('endpoint_prod')->nullable();
            $table->string('auth_prod')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gateways', function (Blueprint $table) {
            $table->dropColumn('endpoint_sandbox');
            $table->dropColumn('auth_sandbox');
            $table->dropColumn('endpoint_prod');
            $table->dropColumn('auth_prod');
        });
    }
};
