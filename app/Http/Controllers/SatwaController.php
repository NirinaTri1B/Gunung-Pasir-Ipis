<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LaporanSatwa;
use Illuminate\Support\Facades\Auth;

class SatwaController extends Controller
{
    // 1. Menampilkan Halaman Laporan Satwa
    public function index()
    {
        $userId = Auth::id();

        // Cek apakah user sedang mendaki
        $isAktif = \App\Models\Registrasi::where('id_user', $userId)
                    ->where('status_pendakian', 'aktif')
                    ->exists();

        return view('pendaki.satwa', compact('isAktif'));
    }

    // 2. Simpan laporan dari Pendaki
    public function store(Request $request)
    {
        $request->validate([
            'nama_satwa' => 'required',
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Upload Foto
        $file = $request->file('foto');
        $nama_foto = time() . "_" . $file->getClientOriginalName();
        $file->move(public_path('img/satwa'), $nama_foto);

        // Simpan ke Database
        LaporanSatwa::create([
            'id_user'    => Auth::id(),
            'nama_satwa' => $request->nama_satwa,
            'lokasi'     => $request->lokasi,
            'deskripsi'  => $request->deskripsi,
            'foto'       => $nama_foto,
            'status'     => 'aktif',
        ]);

        return redirect()->back()->with('success', 'Laporan berhasil terkirim!');
    }
    // // 3. Update Status jadi Selesai (Untuk Karyawan)
    public function tandaiSelesai($id)
    {
        $laporan = LaporanSatwa::findOrFail($id);
        $laporan->update(['status' => 'selesai']);

        return redirect()->back()->with('info', 'Laporan telah diselesaikan.');
    }
}
