<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParticipantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('participants', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('checked')->default(1)->comment("conferido");
            $table->smallInteger('msg_paid_sent')->nullable()->comment("mensagem pago enviada");
            $table->string('name');
            $table->string('phone')->index();
            $table->string('email')->nullable();
            $table->string('document')->nullable();
            $table->integer('amount')->comment("valor da compra");
            $table->text('numbers')->comment("numeros da compra");
            $table->integer('paid')->nullable()->comment("pagos");
            $table->integer('reserved')->nullable()->comment("reservados");
            $table->bigInteger('raffle_id');

            $table->foreign('raffle_id', 'participants_raffle_id_fkey')->references('id')->on('raffles');

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
        Schema::dropIfExists('participants');
    }
}
