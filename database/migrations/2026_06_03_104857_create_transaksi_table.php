<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->string('id_transaksi')->primary();
            $table->string('id_registrasi');
            $table->integer('total_bayar');
            $table->string('metode_pembayaran');
            $table->dateTime('tgl_transaksi');
            $table->timestamps();

            // Relasi
            $table->foreign('id_registrasi')->references('id_registrasi')->on('registrasi')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('transaksi');
    }
};
