<?php

use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PendakiController;
use App\Http\Controllers\SatwaController;
use App\Http\Controllers\UlasanController;
use App\Http\Controllers\KaryawanController;
use Illuminate\Support\Facades\Route;

// Redirection awal
Route::get('/', function () {
    return redirect('/landing');
});

// Route Publik (Bisa diakses tanpa login)
Route::get('landing', [LandingPageController::class, 'index']);

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/forgot', [AuthController::class, 'showForgot'])->name('password.request');
Route::post('/forgot', [AuthController::class, 'forgot']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route yang WAJIB LOGIN
Route::middleware(['auth'])->group(function () {

    // --- Dashboard Pendaki ---
    Route::get('/pendaki/dbpendaki', [PendakiController::class, 'index'])->name('pendaki.dbpendaki');
    Route::post('/kirim-sos', [PendakiController::class, 'kirimSos'])->name('sos.kirim');

    // --- Laporan Satwa & Ulasan ---
    Route::get('/laporan-satwa', [SatwaController::class, 'index'])->name('laporan.satwa');
    Route::post('/laporan-satwa/simpan', [SatwaController::class, 'store']);
    Route::get('/pendaki/ulasan', [UlasanController::class, 'index'])->name('pendaki.ulasan');
    Route::post('/pendaki/ulasan', [UlasanController::class, 'store'])->name('ulasan.store');
    Route::put('/pendaki/ulasan/{id}', [UlasanController::class, 'update'])->name('ulasan.update');
    Route::delete('/pendaki/ulasan/{id}', [UlasanController::class, 'destroy'])->name('ulasan.destroy');

    // --- Aktivitas Pendakian ---
    Route::get('/pendaki/aktivitas', [App\Http\Controllers\PendakiController::class, 'aktivitas'])->name('pendaki.aktivitas');
    // --- Profil ---
    Route::get('/pendaki/profil', [PendakiController::class, 'showProfil'])->name('pendaki.profil');
    Route::put('/pendaki/update', [PendakiController::class, 'update'])->name('pendaki.update');
    Route::delete('/pendaki/hapus-akun', [PendakiController::class, 'destroyAccount'])->name('pendaki.destroy.account');

    // --- DASHBOARD KARYAWAN
    Route::get('/karyawan/db', [KaryawanController::class, 'index'])->name('karyawan.db');

    // Proses Simpan Registrasi (POST untuk AJAX Fetch)
    Route::post('/karyawan/registrasi-proses', [KaryawanController::class, 'prosesRegistrasi'])->name('karyawan.registrasi_proses');

    // Proses Validasi Sampah
    Route::post('/karyawan/validasi-proses/{id}', [KaryawanController::class, 'validasiSampah'])->name('karyawan.validasi_proses');

    // SOS
    Route::get('/karyawan/sos', [KaryawanController::class, 'laporanSos'])->name('karyawan.sos');
    Route::post('/karyawan/sos/{id}/respon', [App\Http\Controllers\KaryawanController::class, 'responSos'])->name('karyawan.sos.respon');
    Route::post('/karyawan/sos/{id}/selesai', [App\Http\Controllers\KaryawanController::class, 'selesaiSos'])->name('karyawan.sos.selesai');

    // Laporan Satwa
    Route::get('/karyawan/satwa', [App\Http\Controllers\KaryawanController::class, 'laporanSatwa'])->name('karyawan.satwa.index');
    Route::post('/karyawan/laporan-satwa/{id}/hapus', [App\Http\Controllers\KaryawanController::class, 'hapusSatwa'])->name('karyawan.satwa.hapus');
    Route::post('/karyawan/satwa/{id}/selesai', [App\Http\Controllers\KaryawanController::class, 'selesaiSatwa'])->name('karyawan.satwa.selesai');
});
