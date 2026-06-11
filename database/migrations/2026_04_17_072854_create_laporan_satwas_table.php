<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('laporan_satwa', function (Blueprint $table) {
            $table->id();
            $table->string('id_user');
            $table->string('nama_satwa');
            $table->string('lokasi');
            $table->text('deskripsi')->nullable();
            $table->string('foto')->nullable();
            $table->string('status')->default('pending');
            $table->timestamps();

            // Relasi
            $table->foreign('id_user')->references('id_user')->on('user')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('laporan_satwa');
    }
};
