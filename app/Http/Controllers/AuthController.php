<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\user;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Login
    public function showLogin()
    {
        return view('login');
    }

    public function login(Request $request)
{
    $credentials = [
        'email' => $request->username,
        'password' => $request->password
    ];

    // GANTI BLOK INI
    if (Auth::attempt($credentials)) {
        $user = Auth::user();

        if ($user->role == 'admin') {
            return redirect('/admin/dashboard')->with('success', 'Selamat datang Admin!');
        } elseif ($user->role == 'karyawan') {
            return redirect('/karyawan/dashboard')->with('success', 'Selamat bekerja, Karyawan!');
        } elseif ($user->role == 'pendaki') {
            return redirect('/pendaki/dbpendaki')->with('success', 'Halo Pendaki! Selamat datang kembali.');
        }

        // Kalau role kosong atau aneh (misal NULL), kita logout paksa
        Auth::logout();
        return back()->withErrors(['error' => 'Role akun tidak dikenali!']);
    }

    return back()->withErrors(['error' => 'Email atau password salah!']);
}

    // Register
    public function showRegister()
    {
        return view('register');
    }

    public function register(Request $request)
{
    // ... proses validasi ...

    User::create([
        'id_user'   => $this->generateId(), // ID otomatis kamu
        'nama_user' => $request->nama_user,
        'email'     => $request->email,
        'password'  => bcrypt($request->password),
        'role'      => 'pendaki', // <--- DIKUNCI DI SINI
    ]);

    return redirect('/login')->with('success', 'Berhasil daftar, Silakan login.');
}
// Tambahkan ini di dalam class AuthController

private function generateId()
{
    // Ambil ID user terakhir
    $lastUser = \App\Models\User::orderBy('id_user', 'desc')->first();

    if (!$lastUser) {
        return 'USR001';
    }

    // Ambil angka dari ID terakhir (misal USR011 -> jadi 11)
    $number = substr($lastUser->id_user, 3);

    // Tambah 1 dan buat format 3 digit (012)
    $newNumber = str_pad((int)$number + 1, 3, '0', STR_PAD_LEFT);

    return 'USR' . $newNumber;
}
    // Forgot Password
    public function showForgot()
    {
        return view('forgot');
    }
    public function forgot(Request $request)
{
    $request->validate([
        'email' => 'required|email|exists:user,email',
        'password' => 'required|min:4|confirmed'
    ]);

    $user = User::where('email', $request->email)->first();

    if ($user) {
        $user->password = Hash::make($request->password);
        $user->save(); // Ini akan berhasil setelah Primary Key di Model diset
        return redirect('/login')->with('success', 'Password berhasil diubah!');
    }

    return back()->withErrors(['error' => 'User tidak ditemukan']);
}
    // Logout
    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
