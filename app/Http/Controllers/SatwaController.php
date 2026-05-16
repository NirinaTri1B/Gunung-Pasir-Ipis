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

        // Cek apakah user sedang mendaki agar Sidebar tidak error
        $isAktif = \App\Models\Registrasi::where('id_user', $userId)
                    ->where('status_pendakian', 'aktif')
                    ->exists();

        // Ambil data laporan satwa milik user ini
        $laporans = LaporanSatwa::where('id_user', $userId)->get();

        return view('pendaki.satwa', compact('laporans', 'isAktif'));
    }

    // 2. Simpan laporan dari Pendaki (PASTIKAN FUNGSI INI ADA)
    public function store(Request $request)
    {
        $request->validate([
            'nama_satwa' => 'required',
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Proses Upload Foto
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

        return redirect()->back()->with('success', 'Laporan berhasil dikirim!');
    }

    // 3. Update Status jadi Selesai (Untuk Karyawan)
    public function tandaiSelesai($id)
    {
        $laporan = LaporanSatwa::findOrFail($id);
        $laporan->update(['status' => 'selesai']);

        return redirect()->back()->with('info', 'Laporan telah diselesaikan.');
    }
}
