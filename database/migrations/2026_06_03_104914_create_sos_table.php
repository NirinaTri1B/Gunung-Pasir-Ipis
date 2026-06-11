<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('sos', function (Blueprint $table) {
            $table->id('id_sos');
            $table->string('id_user');
            $table->string('id_registrasi')->nullable();
            $table->string('jenis_sos');
            $table->string('latitude');
            $table->string('longitude');
            $table->text('pesan_tambahan')->nullable();
            $table->enum('status', ['aktif', 'ditangani', 'selesai'])->default('aktif');
            $table->string('id_petugas')->nullable();
            $table->string('lat_petugas')->nullable();
            $table->string('lng_petugas')->nullable();
            $table->enum('status_sos', ['pending', 'waiting', 'on_the_way', 'selesai'])->default('pending');
            $table->timestamps();

            // Relasi
            $table->foreign('id_user')->references('id_user')->on('user')->onDelete('cascade');
            $table->foreign('id_registrasi')->references('id_registrasi')->on('registrasi')->onDelete('set null');
            $table->foreign('id_petugas')->references('id_user')->on('user')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('sos');
    }
};
