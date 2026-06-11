<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ulasan', function (Blueprint $table) {
            $table->id('id_ulasan');
            $table->string('id_user');
            $table->text('komentar');
            $table->integer('rating');
            $table->text('balasan')->nullable();
            $table->integer('tampilkan')->default(1);
            $table->timestamps();

            // Relasi
            $table->foreign('id_user')->references('id_user')->on('user')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('ulasan');
    }
};
