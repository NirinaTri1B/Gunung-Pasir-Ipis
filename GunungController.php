<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class GunungController extends Controller
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
            return redirect('/login')->with('success', 'Login berhasil!');
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
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:4|confirmed'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        Auth::login($user);
        return redirect('/login')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    // Forgot Password
    public function showForgot()
    {
        return view('forgot');
    }

    public function forgot(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:4|confirmed'
        ]);

        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect('/login')->with('success', 'Password berhasil diubah!');
    }

    // Logout
    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}