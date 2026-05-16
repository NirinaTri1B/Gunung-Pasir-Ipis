<?php
namespace App\Http\Controllers;

use App\Models\Sos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PetugasLapanganController extends Controller
{
    // 1. Menampilkan Daftar Tugas SOS yang masuk ke dia
    public function index()
    {
        $id_petugas = auth()->user()->id_user;

        // Cek apakah ada yang sudah OTW
        $sudahOtw = \App\Models\Sos::where('id_petugas', $id_petugas)
                                    ->where('status', 'ditangani')
                                    ->whereIn('status_sos', ['on_the_way'])
                                    ->first();

        if ($sudahOtw) {
            return redirect()->route('petugas.tracking', $sudahOtw->id_sos);
        }

        // Jika belum ada yang OTW, tampilkan daftar seperti biasa
        $tugasAktif = \App\Models\Sos::where('id_petugas', $id_petugas)
                                    ->where('status', 'ditangani')
                                    ->whereIn('status_sos', ['waiting', 'on_the_way'])
                                    ->get();

        return view('petugas.dblap', compact('tugasAktif'));
    }

    // 2. Konfirmasi Keberangkatan (Klik Berangkat)
    public function konfirmasiBerangkat($id_sos)
    {
        $sos = Sos::where('id_sos', $id_sos)
                  ->where('id_petugas', Auth::user()->id_user)
                  ->firstOrFail();

        $sos->update([
            'status_sos' => 'on_the_way'
        ]);

        return redirect()->route('petugas.tracking', $id_sos)->with('success', 'Hati-hati! GPS kamu sekarang terpantau pendaki.');
    }

    // 3. Halaman Tracking (Peta)
    public function tracking($id_sos)
    {
        $sos = Sos::with('user')->findOrFail($id_sos);
        return view('petugas.tracking', compact('sos'));
    }
    public function riwayat()
    {
        $id_petugas = auth()->user()->id_user;

        // Ambil SOS yang statusnya sudah 'selesai' dan ditangani oleh petugas ini
        $riwayatTugas = \App\Models\Sos::with('user')
                        ->where('id_petugas', $id_petugas)
                        ->where('status', 'selesai')
                        ->orderBy('updated_at', 'desc')
                        ->get();

        return view('petugas.riwayat', compact('riwayatTugas'));
    }
}
