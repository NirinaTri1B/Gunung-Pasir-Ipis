<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UlasanController extends Controller
{
    public function index()
    {
        $ulasan = \App\Models\Ulasan::with('user')->latest()->get();

        // Hitung rata-rata rating (dibulatkan 1 desimal)
        $rataRata = \App\Models\Ulasan::avg('rating') ?? 0;
        $rataRata = number_format($rataRata, 1);

        return view('pendaki.ulasan', compact('ulasan', 'rataRata'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'komentar' => 'required',
            'rating'   => 'required',
        ]);

        \App\Models\Ulasan::create([
            'id_user'  => auth()->id(),
            'komentar' => $request->komentar,
            'rating'   => $request->rating,
        ]);

        // PESAN INI YANG DITANGKAP OLEH SWEETALERT TADI
        return redirect()->back()->with('success', 'Ulasan/Komentar berhasil diunggah!');
    }
    public function update(Request $request, $id)
    {
        $ulasan = \App\Models\Ulasan::findOrFail($id);

        // Keamanan: Cek apakah user ini benar-benar pemilik ulasannya
        if($ulasan->id_user !== auth()->id()){
            return redirect()->back()->with('error', 'Tidak Boleh Edit Ulasan Orang Lain!');
        }

        $ulasan->update($request->all());
        return redirect()->back()->with('success', 'Ulasan diperbarui!');
    }

    public function destroy($id)
    {
        $ulasan = \App\Models\Ulasan::findOrFail($id);

        if($ulasan->id_user === auth()->id()){
            $ulasan->delete();
            return redirect()->back()->with('success', 'Ulasan sudah dihapus.');
        }

        return redirect()->back()->with('error', 'Gagal menghapus.');
    }
}
