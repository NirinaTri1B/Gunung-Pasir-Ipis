<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('registrasi', function (Blueprint $table) {
            $table->string('id_registrasi')->primary();
            $table->string('id_user');
            $table->string('jenis_pendakian');
            $table->integer('lama_menginap');
            $table->integer('jumlah_pendaki');
            $table->integer('jumlah_sampah')->default(0);
            $table->integer('jumlah_sampah_akhir')->default(0);
            $table->enum('status_sampah', ['proses', 'sesuai', 'ambil_kembali', 'denda'])->default('proses');
            $table->integer('total_denda')->default(0);
            $table->enum('status_pendakian', ['aktif', 'tidak aktif', 'selesai'])->default('tidak aktif');
            $table->date('tgl_naik');
            $table->text('deskripsi')->nullable();
            $table->timestamps();

            // Relasi
            $table->foreign('id_user')->references('id_user')->on('user')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('registrasi');
    }
};
