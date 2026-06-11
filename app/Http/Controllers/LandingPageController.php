<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Galeri;
use App\Models\Ulasan;

class LandingPageController extends Controller
{
    public function index()
    {
        // 1. Ambil semua ulasan untuk dihitung totalnya
        $ulasan = Ulasan::with('user')
            ->where('tampilkan', 1)
            ->latest()
            ->take(3)
            ->get();

        // 2. Hitung rata-rata rating (biar variabel $rataRata terdefinisi)
        $rataRata = Ulasan::where('tampilkan', 1)->avg('rating') ?? 0;
        $rataRata = number_format($rataRata, 1);

        // 3. Ambil semua gambar dari tabel galeri
        $galeri = Galeri::all();

        $konten = \App\Models\Konten::all()->keyBy('key');

        // 4. Kirim kedua variabel ke view index
        return view('index', compact('ulasan', 'rataRata', 'galeri', 'konten'));
    }

}

