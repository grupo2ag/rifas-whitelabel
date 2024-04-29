<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('charge_paids', function (Blueprint $table) {
            $table->id();
            $table->string('e2e');
            $table->dateTime('paied_date');
            $table->bigInteger('charge_id');
            $table->text('json_response')->nullable();

            $table->foreign('charge_id', 'charge_paids_charge_id_fkey')->references('id')->on('charges');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('charge_paids');
    }
};
