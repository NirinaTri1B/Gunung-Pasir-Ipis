<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Galeri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GaleriController extends Controller
{
    // 1. Tampilkan Halaman Utama Galeri
    public function index()
    {
        $galeri = Galeri::all(); // Mengambil data GAL001, GAL002, dst dari database
        return view('admin.galeri', compact('galeri'));
    }

    // 2. Proses Simpan Foto Baru
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required',
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Batas 2MB
        ]);

        // Generate ID Otomatis (Format: GAL001)
        $idTerakhir = Galeri::latest('id_galeri')->first();
        if ($idTerakhir) {
            $angka = substr($idTerakhir->id_galeri, 3);
            $idBaru = 'GAL' . sprintf('%03d', (int)$angka + 1);
        } else {
            $idBaru = 'GAL001';
        }

        // Proses Upload Foto ke folder public/storage/galeri
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $namaFoto = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/galeri', $namaFoto);
        }

        // Simpan ke Database
        Galeri::create([
            'id_galeri' => $idBaru,
            'judul' => $request->judul,
            'kategori' => $request->kategori,
            'foto' => $namaFoto
        ]);

        return redirect()->route('admin.galeri')->with('success', 'Foto galeri berhasil ditambahkan!');
    }

    // 3. Proses Hapus Foto
    public function destroy($id)
    {
        // Gunakan findOrFail untuk memastikan data GALXXX tersebut memang ada
        $galeri = Galeri::findOrFail($id);

        if (\Storage::exists('public/galeri/' . $galeri->foto)) {
            \Storage::delete('public/galeri/' . $galeri->foto);
        }

        $galeri->delete();
        return redirect()->route('admin.galeri')->with('success', 'Foto galeri berhasil dihapus!');
    }
}
