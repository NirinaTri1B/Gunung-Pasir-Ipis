<?php

use App\Http\Controllers\GunungController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [GunungController::class, 'showLogin']);
Route::post('/login', [GunungController::class, 'login']);
Route::get('/register', [GunungController::class, 'showRegister']);
Route::post('/register', [GunungController::class, 'register']);
Route::get('/forgot', [GunungController::class, 'showForgot']);
Route::post('/forgot', [GunungController::class, 'forgot']);
Route::post('/logout', [GunungController::class, 'logout']);