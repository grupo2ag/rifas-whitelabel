<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('log_errors', function (Blueprint $table) {
            $table->id();
            $table->longText('exception')->nullable()->index();
            $table->longText('payload')->nullable()->index();
            $table->string('table')->nullable()->index();
            $table->text('comment')->nullable();
            $table->string('id_reference')->nullable()->index();
            $table->unsignedBigInteger('users_id')->nullable()->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_errors');
    }
};
