<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function index()
    {
        // 1. Ambil semua ulasan untuk dihitung totalnya
        $ulasan = \App\Models\Ulasan::with('user')->latest()->take(3)->get();

        // 2. Hitung rata-rata rating (biar variabel $rataRata terdefinisi)
        $rataRata = \App\Models\Ulasan::avg('rating') ?? 0;
        $rataRata = number_format($rataRata, 1);

        // 3. Kirim kedua variabel ke view index
        return view('index', compact('ulasan', 'rataRata'));
    }

}

