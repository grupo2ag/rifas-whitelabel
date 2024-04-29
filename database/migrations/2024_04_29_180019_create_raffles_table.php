<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRafflesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('raffles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->integer('pix_expired')->comment("tempo de expiracao do pix");
            $table->integer('buyer_ranking')->comment("ranking de compradores");
            $table->text('link')->comment("link da rifa");
            $table->integer('price')->comment("Valor unitario de venda");
            $table->string('status')->default('Ativo')->comment("Status da Rifa\nAtivo\nFinalizado");
            $table->integer('quantity')->default(1000)->comment("quantidade de numeros da rifa");
            $table->text('numbers')->nullable()->comment("numeros da rifa string");
            $table->string('type', 45)->default('automatico')->comment("tipo da rifa string\nautomatico\nmanual");
            $table->smallInteger('highlight')->comment("destaque");
            $table->integer('minimum_purchase')->default(1)->comment("compra minima");
            $table->integer('maximum_purchase')->default(99)->comment("compra maxima");
            $table->smallInteger('visible')->default(0)->comment("visivel no site\n0 - oculto\n1 - visivel");
            $table->bigInteger('user_id');
            $table->smallInteger('partial')->default(1);
            $table->text('description')->nullable();
            $table->string('video')->nullable();
            $table->integer('gateway_id');

            $table->foreign('gateway_id', 'raffles_gateway_id_fkey')->references('id')->on('gateways');
            $table->foreign('user_id', 'raffles_user_id_fkey')->references('id')->on('users');

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
        Schema::dropIfExists('raffles');
    }
}
