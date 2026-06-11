<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;

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

    if (Auth::attempt($credentials)) {
        $user = Auth::user();

        if ($user->role == 'admin') {
            return redirect('/admin/dashboard')->with('success', 'Selamat datang Admin!');
        } elseif ($user->role == 'karyawan') {
            return redirect('/karyawan/db')->with('success', 'Selamat bekerja, Karyawan!');
        } elseif ($user->role == 'pendaki') {
            return redirect('/pendaki/dbpendaki')->with('success', 'Halo Pendaki! Selamat datang kembali.');
        } elseif ($user->role == 'petugas_lapangan') {
            return redirect('/petugas/dashboard')->with('success', 'Selamat bekerja, Petugas Lapangan!');
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
        // VALIDASI
        $request->validate([
            'nama_user' => 'required',
            'email' => 'required|email|unique:user,email',
            'password' => 'required|min:4'
        ], [
            'email.unique' => 'Email sudah terdaftar!',
            'email.email' => 'Format email tidak valid!',
            'password.min' => 'Password minimal 4 karakter!'
        ]);

        // SIMPAN USER
        User::create([
            'id_user'   => $this->generateId(),
            'nama_user' => $request->nama_user,
            'email'     => $request->email,
            'password'  => bcrypt($request->password),
            'role'      => 'pendaki',
        ]);

        return redirect('/login')->with('success', 'Berhasil daftar, silakan login.');
    }

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

// 1. Kirim OTP ke Email
public function sendOtp(Request $request)
{
    $request->validate([
        'email' => 'required|email|exists:user,email',
    ], [
        'email.exists' => 'Email tidak terdaftar di sistem kami.'
    ]);

    $otp = rand(100000, 999999);

    session([
        'otp_code' => $otp,
        'otp_email' => $request->email,
        'otp_expires_at' => now()->addMinutes(5)
    ]);

    try {
        Mail::to($request->email)->send(new OtpMail($otp));
        return redirect()->route('otp.verify')->with('success', 'Kode OTP telah dikirim ke email Anda.');
    } catch (\Exception $e) {
        return back()->withErrors(['error' => 'Gagal mengirim email: ' . $e->getMessage()]);
    }
}

// 2. Tampilkan Halaman Input OTP
public function showVerifyOtp()
{
    if (!session()->has('otp_email')) {
        return redirect('/forgot')->withErrors(['error' => 'Silahkan masukkan email Anda terlebih dahulu.']);
    }
    return view('verify-otp');
}

// 3. Proses Verifikasi OTP dari Form
public function verifyOtp(Request $request)
{
    $request->validate([
        'otp' => 'required|numeric'
    ]);

    if (now()->isAfter(session('otp_expires_at'))) {
        session()->forget(['otp_code', 'otp_email', 'otp_expires_at']);
        return redirect('/forgot')->withErrors(['error' => 'Kode OTP sudah kadaluarsa, silahkan minta baru.']);
    }

    if ((string)$request->otp === (string)session('otp_code')) {
        session(['otp_verified' => true]);
        return redirect()->route('password.reset');
    }

    return back()->withErrors(['error' => 'Kode OTP yang Anda masukkan salah.']);
}

// Resend OTP
public function resend(Request $request)
{
    // 1. Ambil email dari session
    $email = session('otp_email');

    if (!$email) {
        // Diarahkan ke /forgot karena kalau session habis, sistem tidak tahu mau kirim ke email mana
        return redirect('/forgot')->withErrors(['error' => 'Sesi telah berakhir, silakan masukkan email kembali.']);
    }

    // 2. Logika generate kode OTP baru
    $otp = rand(100000, 999999);

    // Simpan OTP baru ke Session
    session([
        'otp_code' => $otp,
        'otp_email' => $email, // Menggunakan $email dari session
        'otp_expires_at' => now()->addMinutes(5)
    ]);

    try {
        // Kirim ke $email, bukan $request->email
        Mail::to($email)->send(new OtpMail($otp));
    } catch (\Exception $e) {
        return back()->withErrors(['error' => 'Gagal mengirim email: ' . $e->getMessage()]);
    }

    // 3. Kembali ke halaman OTP dengan pesan sukses
    return redirect('/verify-otp')->with('success', 'Kode OTP baru telah dikirim ke email Anda!');
}

// 4. Tampilkan Halaman Input Password Baru
public function showResetPassword()
{
    if (!session('otp_verified')) {
        return redirect('/forgot')->withErrors(['error' => 'Akses ditolak. Silahkan verifikasi OTP terlebih dahulu.']);
    }
    return view('reset-password');
}

// 5. Proses Simpan Password Baru ke Database
public function resetPassword(Request $request)
{
    if (!session('otp_verified')) {
        return redirect('/forgot');
    }

    $request->validate([
        'password' => 'required|min:4|confirmed'
    ]);

    $user = User::where('email', session('otp_email'))->first();

    if ($user) {
        $user->password = Hash::make($request->password);
        $user->save();

        session()->forget(['otp_code', 'otp_email', 'otp_expires_at', 'otp_verified']);

        return redirect('/login')->with('success', 'Password berhasil diubah! Silahkan login.');
    }

    return redirect('/forgot')->withErrors(['error' => 'User tidak ditemukan.']);
}
    // Logout
    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
