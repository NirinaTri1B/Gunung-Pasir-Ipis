<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Sos;
use App\Models\LaporanSatwa;
use App\Models\Registrasi;
use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;

class KaryawanController extends Controller
{
    // Halaman Utama
    public function index(Request $request)
    {
        // 1. Mulai Query: Ambil user pendaki & data registrasi aktifnya
        $query = User::where('role', 'pendaki')
                     ->with(['registrasi' => function($q) {
                         $q->where('status_pendakian', 'aktif');
                     }]);

        // 2. LOGIKA SEARCH
        if ($request->has('search') && $request->search != '') {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('nama_user', 'like', "%$search%")
                  ->orWhere('no_telp', 'like', "%$search%")
                  ->orWhere('alamat', 'like', "%$search%");
            });
        }

        // 3. Ambil hasil data pendaki (Pisahkan jadi 5 data per halaman)
        $pendakis = $query->paginate(5)->appends($request->all());

        // Menghitung pendaki yang statusnya sedang di gunung
        $totalAktif = Registrasi::where('status_pendakian', 'aktif')->count();

        // Menghitung SOS yang butuh bantuan (status aktif atau ditangani)
        $totalNotif = Sos::whereIn('status', ['aktif', 'ditangani'])->count();

        // Menghitung Laporan Satwa yang sedang aktif (belum selesai)
        $totalSatwa = LaporanSatwa::where('status', 'aktif')->count();

        // 5. Kirim semua variabel (tambahkan totalSatwa) ke view
        return view('karyawan.db', compact('pendakis', 'totalAktif', 'totalNotif', 'totalSatwa'));
    }

    // 1. Proses Registrasi (Naik Gunung)
    public function prosesRegistrasi(Request $request)
    {
        try {
            $id_reg = 'REG-' . date('Ymd') . '-' . rand(100, 999);
            $id_trs = 'TRS-' . date('Ymd') . '-' . rand(100, 999);

            // 1. Simpan ke Tabel Registrasi
            Registrasi::create([
                'id_registrasi'   => $id_reg,
                'id_user'         => $request->id_user,
                'jenis_pendakian' => $request->jenis,
                'lama_menginap'   => $request->hari,
                'jumlah_pendaki'  => $request->jumlah,
                'jumlah_sampah'   => $request->sampah,
                'tgl_naik'        => now()->format('Y-m-d'),
                'status_pendakian'=> 'aktif',
            ]);

            // 2. Simpan ke Tabel Transaksi
            Transaksi::create([
                'id_transaksi'      => $id_trs,
                'id_registrasi'     => $id_reg,
                'total_bayar'       => $request->total,
                // Menggunakan null coalescing (??) agar aman jika kosong
                'metode_pembayaran' => $request->pembayaran ?? 'Cash',
                'tgl_transaksi'     => now()->format('Y-m-d'),
            ]);

            return response()->json(['success' => true, 'message' => 'Data berhasil disimpan!']);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
    public function riwayatRegistrasi(Request $request)
    {
        $query = Registrasi::with(['user', 'transaksi']);

        // 1. Logika Search Nama
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function($q) use ($search) {
                $q->where('nama_user', 'like', "%$search%");
            });
        }

        // 2. Filter Tanggal
        if ($request->filled('tgl_mulai')) {
            $mulai = $request->tgl_mulai;
            // Kalau tgl_selesai kosong, pakai hari ini. Kalau ada, pakai inputannya.
            $selesai = $request->filled('tgl_selesai') ? $request->tgl_selesai : now()->format('Y-m-d');

            $query->whereBetween('tgl_naik', [$mulai, $selesai]);
        }

        // 3. Filter Status
        if ($request->filled('status')) {
            $query->where('status_pendakian', $request->status);
        }

        $riwayat = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('karyawan.riwayat', compact('riwayat'));
    }

    public function kirimPetugas(Request $request)
    {
        // Validasi input
        $request->validate([
            'id_sos' => 'required',
            'id_petugas' => 'required'
        ]);

        // 1. Cari data SOS-nya
        $sos = \App\Models\Sos::find($request->id_sos);

        if ($sos) {
            // 2. Update kolom id_petugas dan status_sos
            // PASTIKAN NAMA KOLOM DI DATABASE KAMU ADALAH 'id_petugas'
            $sos->id_petugas = $request->id_petugas;

            // Kita set statusnya jadi 'waiting' agar muncul di dashboard petugas
            $sos->status = 'ditangani';
            $sos->status_sos = 'waiting';

            // 3. SIMPAN KE DATABASE (Ini yang sering ketinggalan!)
            $sos->save();

            return redirect()->back()->with('success', 'Petugas berhasil ditugaskan ke lokasi!');
        }

        return redirect()->back()->with('error', 'Gagal menemukan data laporan SOS.');
    }

    // 2. Validasi Sampah (Turun Gunung)
    public function validasiSampah(Request $request, $id)
    {
        try {
            $reg = Registrasi::where('id_user', $id)->where('status_pendakian', 'aktif')->first();

            if (!$reg) {
                return response()->json(['success' => false, 'message' => 'Data registrasi aktif tidak ditemukan.'], 404);
            }

            $statusPendakian = $reg->status_pendakian;

            // Cek instruksi selesai dari JavaScript ('sesuai', 'denda', atau sinyal paksa 'selesai')
            if ($request->selesai == true || (!$request->has('simpan_sementara') && in_array($request->status_sampah, ['sesuai', 'denda']))) {
                $statusPendakian = 'selesai';
            }

            // Update data registrasi
            $reg->update([
                'status_pendakian'    => $statusPendakian,
                'jumlah_sampah_akhir' => $request->akhir,
                'status_sampah'       => $request->status_sampah,
                'total_denda'         => $request->denda,
                'deskripsi'           => $request->deskripsi
            ]);

            // Logika simpan Denda ke Transaksi
            if ($request->denda > 0 && $statusPendakian == 'selesai') {
                $id_trs = 'TRS-' . date('Ymd') . '-' . rand(100, 999);
                Transaksi::create([
                    'id_transaksi'      => $id_trs,
                    'id_registrasi'     => $reg->id_registrasi,
                    'total_bayar'       => $request->denda, // Nominal denda masuk sebagai transaksi baru
                    'metode_pembayaran' => $request->metode_pembayaran_denda ?? 'Cash',
                    'tgl_transaksi'     => now()->format('Y-m-d'),
                ]);
            }

            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // ==========================================
    // MENU LAPORAN SOS
    // ==========================================
    public function laporanSos()
    {
        // 1. KOORDINAT BASECAMP PUNCAK PASIR IPIS
        $basecampLat = -6.747504;
        $basecampLon = 107.676028;

        // 2. Ambil data dari database
        $sosBaru = \App\Models\Sos::with('user')
                    ->whereIn('status', ['aktif', 'ditangani'])
                    ->orderBy('created_at', 'desc')
                    ->get();

        $sosSelesai = \App\Models\Sos::with('user')
                    ->where('status', 'selesai')
                    ->orderBy('updated_at', 'desc')
                    ->get();

        // 3. Hitung jarak untuk masing-masing SOS Baru
        $sosBaru->map(function ($item) use ($basecampLat, $basecampLon) {
            $item->jarak = $this->hitungJarak($basecampLat, $basecampLon, $item->latitude, $item->longitude);
            return $item;
        });

        // 4. Hitung jarak untuk masing-masing SOS Selesai
        $sosSelesai->map(function ($item) use ($basecampLat, $basecampLon) {
            $item->jarak = $this->hitungJarak($basecampLat, $basecampLon, $item->latitude, $item->longitude);
            return $item;
        });
        $petugas_lapangan = \App\Models\User::where('role', 'petugas_lapangan')->get();

        return view('karyawan.sos', compact('sosBaru', 'sosSelesai', 'petugas_lapangan'));
    }

    // ==========================================
    // FUNGSI RUMUS MENGHITUNG JARAK (KILOMETER)
    // ==========================================
    private function hitungJarak($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371; // Radius Bumi dalam Kilometer

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat/2) * sin($dLat/2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon/2) * sin($dLon/2);
        $c = 2 * atan2(sqrt($a), sqrt(1-$a));

        $jarak = $earthRadius * $c;

        return round($jarak, 2); // Dibulatkan jadi 2 angka di belakang koma
    }
    // ==========================================
    // PROSES RESPON SOS OLEH TIM BASECAMP
    // ==========================================
    public function responSos($id)
    {
        // Cari data SOS berdasarkan ID
        $sos = \App\Models\Sos::where('id_sos', $id)->first();

        if($sos) {
            // Ubah statusnya menjadi 'ditangani'
            $sos->status = 'ditangani';
            $sos->save();

            // Kembali ke halaman sebelumnya dengan pesan sukses
            return redirect()->back()->with('success', 'Tim Rescue berhasil diberangkatkan! Status SOS diubah menjadi Ditangani.');
        }

        return redirect()->back()->with('error', 'Data SOS tidak ditemukan.');
    }
    // ==========================================
    // PROSES SOS SELESAI
    // ==========================================
    public function selesaiSos($id)
    {
        $sos = \App\Models\Sos::find($id);
        $sos->update(['status' => 'selesai', 'status_sos' => 'selesai']);

        // Cek siapa yang klik
        if (auth()->user()->role == 'petugas_lapangan') {
            return redirect()->route('petugas.dblap')->with('success', 'Tugas berhasil diselesaikan!');
        }

        return redirect()->back()->with('success', 'Laporan SOS ditutup.');
    }
    public function laporanSatwa()
    {
        // Mengambil laporan yang statusnya 'aktif'
        $satwaAktif = \DB::table('laporan_satwa')
            ->join('user', 'laporan_satwa.id_user', '=', 'user.id_user')
            ->where('laporan_satwa.status', 'aktif')
            ->select('laporan_satwa.*', 'user.nama_user')
            ->orderBy('laporan_satwa.created_at', 'desc')
            ->get();

        // Mengambil laporan yang statusnya 'selesai'
        $satwaSelesai = \DB::table('laporan_satwa')
            ->join('user', 'laporan_satwa.id_user', '=', 'user.id_user')
            ->where('laporan_satwa.status', 'selesai')
            ->select('laporan_satwa.*', 'user.nama_user')
            ->orderBy('laporan_satwa.updated_at', 'desc')
            ->get();

        return view('karyawan.satwa', compact('satwaAktif', 'satwaSelesai'));
    }

    // Fungsi untuk hapus laporan satwa (karena hoax atau salah input)
    public function hapusSatwa($id)
    {
        // Cari dulu datanya buat ambil nama file fotonya
        $laporan = \DB::table('laporan_satwa')->where('id_laporan', $id)->first();

        if ($laporan) {
            // 1. Hapus file fotonya dari folder storage biar gak menuh-menuhin hosting
            if ($laporan->foto) {
                \Storage::delete('public/satwa/' . $laporan->foto);
            }

            // 2. Hapus datanya dari database
            \DB::table('laporan_satwa')->where('id_laporan', $id)->delete();

            return redirect()->back()->with('success', 'Laporan palsu berhasil dihapus!');
        }

        return redirect()->back()->with('error', 'Gagal menghapus data.');
    }

    // Tambahkan fungsi untuk mengubah status menjadi selesai
    public function selesaiSatwa($id)
    {
        \DB::table('laporan_satwa')
            ->where('id_laporan', $id)
            ->update(['status' => 'selesai', 'updated_at' => now()]);

        return redirect()->back()->with('success', 'Laporan satwa ditandai selesai.');
    }
    public function cekSosTerbaru()
    {
        $user = auth()->user();

        // Jika yang nanya adalah pendaki
        if($user->role == 'pendaki') {
            $sos = \App\Models\Sos::where('id_user', $user->id_user)
                                    ->whereIn('status', ['aktif', 'ditangani'])
                                    ->first();
        } else {
            // Jika yang nanya adalah petugas
            $sos = \App\Models\Sos::where('id_petugas', $user->id_user)
                                    ->whereIn('status', ['aktif', 'ditangani'])
                                    ->first();
        }

        return response()->json([
            'ada_sos'     => $sos ? true : false,
            'lat_petugas' => $sos ? $sos->lat_petugas : null,
            'lng_petugas' => $sos ? $sos->lng_petugas : null,
            'lat_pendaki' => $sos ? $sos->latitude : null,
            'lng_pendaki' => $sos ? $sos->longitude : null,
            'status_sos'  => $sos ? $sos->status_sos : null,
        ]);
    }
    public function updateLokasiPetugas(Request $request)
    {
        try {
            $sos = \App\Models\Sos::find($request->id_sos);
            if ($sos) {
                $sos->update([
                    'lat_petugas' => $request->lat,
                    'lng_petugas' => $request->lng
                ]);
                return response()->json(['success' => true]);
            }
            return response()->json(['success' => false], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
