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
        Schema::create('gateway_configurations', function (Blueprint $table) {
            $table->id();
            $table->string('token')->nullable();
            $table->string('login')->nullable();
            $table->bigInteger('gateway_id')->unsigned();
            $table->foreign('gateway_id', 'gateway_configurations_gateway_id_fkey')->references('id')->on('gateways');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id', 'gateway_configurations_user_id_fkey')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gateway_configurations');
    }
};
