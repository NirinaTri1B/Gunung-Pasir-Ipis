<?php

use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PendakiController;
use App\Http\Controllers\SatwaController;
use App\Http\Controllers\UlasanController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', function () {
    return redirect('/landing');
});

Route::get('landing', [LandingPageController::class, 'index']);
Route::get('/login', [AuthController::class, 'showLogin']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/forgot', [AuthController::class, 'showForgot']);
Route::post('/forgot', [AuthController::class, 'forgot']);
Route::post('/logout', [AuthController::class, 'logout']);

// ... route login register dll ...

Route::middleware(['auth'])->group(function () {
    // Dashboard Utama
    Route::get('/pendaki/dbpendaki', [PendakiController::class, 'index'])->name('pendaki.dbpendaki');
    Route::post('/kirim-sos', [PendakiController::class, 'kirimSos'])->name('sos.kirim');

    // HALAMAN LAPORAN SATWA (Pindahin ke sini, Sa!)
    Route::get('/laporan-satwa', [SatwaController::class, 'index'])->name('laporan.satwa');
    Route::post('/laporan-satwa/simpan', [SatwaController::class, 'store']);

    // halaman ulasan
    // Route untuk menampilkan halaman ulasan
    Route::get('/pendaki/ulasan', [App\Http\Controllers\UlasanController::class, 'index'])->name('pendaki.ulasan');
    // TAMBAHKAN INI: Route untuk memproses pengiriman ulasan
    Route::post('/pendaki/ulasan', [App\Http\Controllers\UlasanController::class, 'store'])->name('ulasan.store');
    Route::put('/pendaki/ulasan/{id}', [UlasanController::class, 'update'])->name('ulasan.update');
    Route::delete('/pendaki/ulasan/{id}', [UlasanController::class, 'destroy'])->name('ulasan.destroy');

    // Halaman Profil
    Route::get('/pendaki/profil', [PendakiController::class, 'showProfil'])->name('pendaki.profil');
    Route::put('/pendaki/update', [PendakiController::class, 'update'])->name('pendaki.update');
    Route::delete('/pendaki/hapus-akun', [App\Http\Controllers\PendakiController::class, 'destroyAccount'])->name('pendaki.destroy.account');
});

