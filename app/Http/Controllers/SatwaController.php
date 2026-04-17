<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LaporanSatwa;
use Illuminate\Support\Facades\Auth; // Penting untuk ambil ID otomatis

class SatwaController extends Controller
{
    public function index()
{
    return view('pendaki.satwa');
}
    // 1. Simpan laporan dari Pendaki
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
            'id_user'    => Auth::id(), // INI OTOMATIS AMBIL ID USER LOGIN
            'nama_satwa' => $request->nama_satwa,
            'lokasi'     => $request->lokasi,
            'deskripsi'  => $request->deskripsi,
            'foto'       => $nama_foto,
            'status'     => 'aktif', // Default saat lapor
        ]);

        return redirect()->back()->with('success', 'Laporan berhasil dikirim!');
    }

    // 2. Update Status jadi Selesai (Untuk Karyawan)
    public function tandaiSelesai($id)
    {
        $laporan = LaporanSatwa::findOrFail($id);
        $laporan->update(['status' => 'selesai']);

        return redirect()->back()->with('info', 'Laporan telah diselesaikan.');
    }

}
