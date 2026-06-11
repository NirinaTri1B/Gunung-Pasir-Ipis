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
        $galeri = Galeri::withTrashed()->latest()->get();
        return view('admin.galeri', compact('galeri'));
    }

    // 2. Proses Simpan Foto Baru (BAGIAN INI YANG DIUBAH)
    public function store(Request $request)
    {
        // Pengecekan kuota: Hitung foto galeri yang aktif (tidak termasuk yang di recycle bin)
        $jumlahFotoAktif = Galeri::count();

        // Jika jumlah foto yang aktif sudah mencapai atau lebih dari 15, gagalkan proses
        if ($jumlahFotoAktif >= 15) {
            return redirect()->back()->with('error', 'Gagal unggah! Kuota maksimal galeri wisata adalah 15 foto. Silakan hapus atau bersihkan foto lama terlebih dahulu.');
        }

        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required',
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Generate ID Otomatis (Format: GAL001)
        $idTerakhir = Galeri::withTrashed()->latest('id_galeri')->first();
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
        $galeri = Galeri::findOrFail($id);

        $galeri->delete();

        return back()->with('success', 'Foto berhasil dihapus, anda dapat memulihkan kembali foto tersebut di Recycle Bin.');
    }

    public function restore($id)
    {
        $galeri = Galeri::withTrashed()->findOrFail($id);

        // CEK SAAT RESTORE: Jangan sampai memulihkan foto lewat recycle bin membuat jumlahnya tembus > 15
        if (Galeri::count() >= 15) {
            return back()->with('error', 'Gagal memulihkan! Jumlah foto aktif di galeri saat ini sudah pas 15 foto.');
        }

        $galeri->restore();

        return back()->with('success', 'Foto berhasil dipulihkan.');
    }

    public function restoreAll()
    {
        $jumlahAktif = Galeri::count();
        $jumlahBakalDirestore = Galeri::onlyTrashed()->count();

        // Jika dipulihkan semua malah bikin jebol batas 15 foto, batalkan
        if (($jumlahAktif + $jumlahBakalDirestore) > 15) {
            return redirect()->back()->with('error', 'Gagal memulihkan semua! Total foto akan melebihi batas kuota 15 foto.');
        }

        Galeri::onlyTrashed()->restore();

        return redirect()->back()->with('success', 'Semua foto berhasil dipulihkan!');
    }

    public function forceDelete($id)
    {
        $galeri = Galeri::withTrashed()->findOrFail($id);

        // hapus file fisik
        if(Storage::exists('public/galeri/' . $galeri->foto)){
            Storage::delete('public/galeri/' . $galeri->foto);
        }

        $galeri->forceDelete();

        return back()->with('success', 'Foto dihapus permanen.');
    }

    public function forceDeleteAll()
    {
        $allDeleted = Galeri::onlyTrashed()->get();

        foreach ($allDeleted as $galeri) {
            // hapus file fisik
            if ($galeri->foto) {
                Storage::delete('public/galeri/' . $galeri->foto);
            }

            // hapus permanen database
            $galeri->forceDelete();
        }

        return redirect()->back()->with('success', 'Semua foto berhasil dihapus permanen!');
    }
}
