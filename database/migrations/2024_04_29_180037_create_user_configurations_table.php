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
        Schema::create('user_configurations', function (Blueprint $table) {
            $table->id();
            $table->string('primary_color')->nullable();
            $table->text('logo')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->text('meta_image')->nullable();
            $table->text('favicon')->nullable();
            $table->text('site_title')->nullable();
            $table->text('site_subtitle')->nullable();
            $table->text('privacy')->nullable();
            $table->text('about_us')->nullable();
            $table->text('terms_conditions')->nullable();
            $table->text('facebook')->nullable();
            $table->text('instagram')->nullable();
            $table->text('twitter')->nullable();
            $table->text('youtube')->nullable();
            $table->text('google_analytics')->nullable();
            $table->text('facebook_pixel')->nullable();
            $table->bigInteger('user_id');

            $table->foreign('user_id', 'user_configurations_user_id_fkey')->references('id')->on('users');

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
        Schema::dropIfExists('user_configurations');
    }
};
