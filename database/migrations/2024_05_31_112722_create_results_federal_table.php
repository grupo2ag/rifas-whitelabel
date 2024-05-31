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
        Schema::create('results_federal', function (Blueprint $table) {
            $table->id();
            $table->date('date')->index();
            $table->string('local')->nullable();
            $table->string('concurso');
            $table->text('results')->index();
            $table->string('r1');
            $table->string('r2');
            $table->string('r3');
            $table->string('r4');
            $table->string('r5');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('results_federal');
    }
};
