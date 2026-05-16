<?php

use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PendakiController;
use App\Http\Controllers\SatwaController;
use App\Http\Controllers\UlasanController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\PetugasLapanganController;
use Illuminate\Support\Facades\Route;

// Redirection awal (Langsung arahkan jalurnya ke Controller)
Route::get('/', [LandingPageController::class, 'index']);

// Route Publik (Bisa diakses tanpa login)
Route::get('/landing', [LandingPageController::class, 'index'])->name('landing');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/forgot', [AuthController::class, 'showForgot'])->name('password.request');
Route::post('/forgot', [AuthController::class, 'forgot']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route yang WAJIB LOGIN
Route::middleware(['auth'])->group(function () {

    // --- Pendaki ---
    Route::get('/pendaki/dbpendaki', [PendakiController::class, 'index'])->name('pendaki.dbpendaki');
    Route::get('/pendaki/informasi', [PendakiController::class, 'informasiUmum'])->name('pendaki.informasi');
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

    // --- KARYAWAN
    Route::get('/karyawan/db', [KaryawanController::class, 'index'])->name('karyawan.db');

    // Proses Simpan Registrasi (POST untuk AJAX Fetch)
    Route::post('/karyawan/registrasi-proses', [KaryawanController::class, 'prosesRegistrasi'])->name('karyawan.registrasi_proses');
    // Riwayat Registrasi untuk Karyawan
    Route::get('/karyawan/riwayat-registrasi', [KaryawanController::class, 'riwayatRegistrasi'])->name('karyawan.riwayat');

    // Proses Validasi Sampah
    Route::post('/karyawan/validasi-proses/{id}', [KaryawanController::class, 'validasiSampah'])->name('karyawan.validasi_proses');

    // SOS
    Route::get('/karyawan/sos', [KaryawanController::class, 'laporanSos'])->name('karyawan.sos');
    Route::get('/karyawan/cek-sos-terbaru', [KaryawanController::class, 'cekSosTerbaru'])->middleware('auth');
    Route::post('/sos/update-lokasi-pendaki', [App\Http\Controllers\PendakiController::class, 'updateLokasiPendaki'])
      ->name('sos.update-lokasi-pendaki');
    Route::post('/karyawan/sos/{id}/respon', [App\Http\Controllers\KaryawanController::class, 'responSos'])->name('karyawan.sos.respon');
    Route::post('/karyawan/sos/{id}/selesai', [App\Http\Controllers\KaryawanController::class, 'selesaiSos'])->name('karyawan.sos.selesai');

    // Laporan Satwa
    Route::get('/karyawan/satwa', [App\Http\Controllers\KaryawanController::class, 'laporanSatwa'])->name('karyawan.satwa.index');
    Route::post('/karyawan/laporan-satwa/{id}/hapus', [App\Http\Controllers\KaryawanController::class, 'hapusSatwa'])->name('karyawan.satwa.hapus');
    Route::post('/karyawan/satwa/{id}/selesai', [App\Http\Controllers\KaryawanController::class, 'selesaiSatwa'])->name('karyawan.satwa.selesai');

    // --- KIRIM PETUGAS ---
    Route::get('/karyawan/cek-sos-terbaru', [KaryawanController::class, 'cekSosTerbaru'])
      ->middleware('auth')
      ->name('karyawan.cek-sos-terbaru');
    Route::post('/karyawan/sos/kirim-petugas', [KaryawanController::class, 'kirimPetugas'])->name('basecamp.kirim_petugas');

    // Petugas Lapangan
    Route::middleware(['auth'])->group(function () {
    Route::get('/petugas/dashboard', [PetugasLapanganController::class, 'index'])->name('petugas.dblap');
    Route::get('/petugas/riwayat', [PetugasLapanganController::class, 'riwayat'])->name('petugas.riwayat');
    Route::post('/petugas/konfirmasi/{id}', [PetugasLapanganController::class, 'konfirmasiBerangkat'])->name('petugas.konfirmasi');
    Route::get('/petugas/tracking/{id}', [PetugasLapanganController::class, 'tracking'])->name('petugas.tracking');
    Route::post('/petugas/update-lokasi', [App\Http\Controllers\KaryawanController::class, 'updateLokasiPetugas'])->name('petugas.update_lokasi');

    // --- DASHBOARD ADMIN ---
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dbadmin');
    Route::get('/admin/dashboard/cetak', [AdminController::class, 'cetakLaporan'])->name('admin.cetak');

    // Route Kelola Akun
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::post('/admin/users/store', [AdminController::class, 'storeUser'])->name('admin.users.store');
    Route::put('/admin/users/update/{id}', [AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::delete('/admin/users/delete/{id}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');

    // Route Kelola Ulasan
    Route::get('/admin/ulasan', [AdminController::class, 'ulasan'])->name('admin.ulasan');
    Route::post('/admin/ulasan/store', [AdminController::class, 'storeUlasan'])->name('admin.ulasan.store'); // Admin bikin ulasan sendiri
    Route::post('/admin/ulasan/reply/{id}', [AdminController::class, 'replyUlasan'])->name('admin.ulasan.reply'); // Admin balas ulasan pendaki
    Route::put('/admin/ulasan/update/{id}', [AdminController::class, 'updateUlasan'])->name('admin.ulasan.update'); // Admin edit ulasan sendiri
    Route::delete('/admin/ulasan/delete/{id}', [AdminController::class, 'deleteUlasan'])->name('admin.ulasan.delete'); // Hapus ulasan

    // 1. Route Kelola Galeri (Tambahkan /admin di depan URL-nya)
    Route::get('/admin/galeri', [GaleriController::class, 'index'])->name('admin.galeri');
    Route::post('/admin/galeri/store', [GaleriController::class, 'store'])->name('admin.galeri.store');
    Route::delete('/admin/galeri/destroy/{id}', [GaleriController::class, 'destroy'])->name('admin.galeri.destroy');

    // 2. Route Kelola Konten
    Route::get('/admin/konten', [AdminController::class, 'konten'])->name('admin.konten');

    Route::get('/admin/profil', [AdminController::class, 'profil'])->name('admin.profil');
    // Rute untuk memproses update data profil pribadi
    Route::put('/admin/profil/update', [AdminController::class, 'updateProfil'])->name('admin.profil.update');
    Route::get('/admin/dashboard/filter', [AdminController::class, 'filterDashboard'])->name('admin.dashboard.filter');
    Route::get('/admin/sos', [AdminController::class, 'riwayatSos'])->name('admin.sos');
    Route::get('/admin/satwa', [AdminController::class, 'laporanSatwa'])->name('admin.satwa');
    });
});


