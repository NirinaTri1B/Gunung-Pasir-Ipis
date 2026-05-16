<?php

namespace App\Http\Controllers;

use App\Models\Registrasi;
use App\Models\Sos;
use App\Models\User;
use App\Models\Ulasan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaksi;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // 1. Proteksi Admin
        if (Auth::user()->role !== 'admin') {
            Auth::logout();
            return redirect('/login')->withErrors(['error' => 'Akses terlarang!']);
        }

        // 2. Data Stat Card
        $totalPendapatan = Transaksi::sum('total_bayar');
        $pendapatanQris = Transaksi::where('metode_pembayaran', 'qris')->sum('total_bayar');
        $pendapatanCash = Transaksi::where('metode_pembayaran', 'cash')->sum('total_bayar');

        // PERBAIKAN 1: Hitung pengunjung berdasarkan transaksi yang masuk
        $jumlahPengunjung = Transaksi::count();

        $sosAktif = Sos::where('status', '!=', 'selesai')->count();

        // 3. Data Riwayat Transaksi
        // PERBAIKAN 2: Hapus ->limit(10) agar DataTables bisa membaca seluruh ke-23 datanya
        $riwayatTransaksi = Transaksi::with('registrasi.user')
                            ->orderBy('created_at', 'desc')
                            ->get(); // <-- HAPUS LIMIT-NYA

        // 4. LOGIKA GRAFIK TREN PENDAPATAN
        $labelGrafik = [];
        $dataPendapatan = [];

        for ($i = 5; $i >= 0; $i--) {
            $bulan = \Carbon\Carbon::now()->subMonths($i);
            $labelGrafik[] = $bulan->format('M');

            $total = Transaksi::whereMonth('created_at', $bulan->month)
                             ->whereYear('created_at', $bulan->year)
                             ->sum('total_bayar');
            $dataPendapatan[] = $total;
        }

        // 5. LOGIKA GRAFIK SOS
        $sosLabels = ['Tersesat', 'Cedera', 'Lainnya'];
        $sosCounts = [
            Sos::where('jenis_sos', 'Tersesat')->count(),
            Sos::where('jenis_sos', 'Cedera')->count(),
            Sos::where('jenis_sos', 'Bahaya Lainnya')->count(),
        ];

        return view('admin.dbadmin', compact(
            'totalPendapatan',
            'pendapatanQris',
            'pendapatanCash',
            'jumlahPengunjung',
            'sosAktif',
            'riwayatTransaksi',
            'labelGrafik',
            'dataPendapatan',
            'sosLabels',
            'sosCounts'
        ));
    }

    public function filterDashboard(Request $request)
    {
        $mulai = $request->tgl_mulai . ' 00:00:00';
        $selesai = $request->tgl_selesai . ' 23:59:59';
        $metode = $request->metode;

        $queryTransaksi = \App\Models\Transaksi::whereBetween('created_at', [$mulai, $selesai]);

        if ($metode && $metode !== 'semua') {
            $queryTransaksi->where('metode_pembayaran', $metode);
        }

        $pendapatan = (clone $queryTransaksi)->sum('total_bayar');
        $pengunjung = (clone $queryTransaksi)->count();

        $transaksi = (clone $queryTransaksi)->with('registrasi.user')
                    ->orderBy('created_at', 'desc')
                    ->get();

        // --- LOGIKA BARU BUAT UPDATE GRAFIK TREN ---
        $chartResult = (clone $queryTransaksi)
                    ->selectRaw('SUM(total_bayar) as total, MONTH(created_at) as bulan, YEAR(created_at) as tahun')
                    ->groupBy('tahun', 'bulan')
                    ->orderBy('tahun', 'asc')
                    ->orderBy('bulan', 'asc')
                    ->get();

        $chartLabels = [];
        $chartData = [];

        // Kalau di rentang tanggal itu kosong (kayak kasus 2025 kamu)
        if($chartResult->isEmpty()) {
            $chartLabels = ['Data Kosong'];
            $chartData = [0];
        } else {
            foreach($chartResult as $row) {
                // Biar formatnya jadi "May 25", "Jun 26"
                $namaBulan = \Carbon\Carbon::create()->month($row->bulan)->format('M');
                $chartLabels[] = $namaBulan . ' ' . substr($row->tahun, 2, 2);
                $chartData[] = $row->total;
            }
        }

        return response()->json([
            'pendapatan'   => 'Rp ' . number_format($pendapatan, 0, ',', '.'),
            'pengunjung'   => $pengunjung . ' Orang',
            'transaksi'    => $transaksi,
            'chart_labels' => $chartLabels, // Kirim label baru ke JS
            'chart_data'   => $chartData    // Kirim angka baru ke JS
        ]);
    }
    public function cetakLaporan(Request $request)
    {
        $mulaiInput = $request->tgl_mulai;
        $selesaiInput = $request->tgl_selesai;
        $metode = $request->metode ?? 'semua';
        $cetakPengunjung = $request->cetak_pengunjung ?? 'ya';

        // 1. Query dasar untuk data yang akan dicetak
        $query = \App\Models\Transaksi::query();

        if ($mulaiInput && $selesaiInput) {
            $query->whereBetween('created_at', [$mulaiInput . ' 00:00:00', $selesaiInput . ' 23:59:59']);
            $periodeTeks = date('d M Y', strtotime($mulaiInput)) . ' s/d ' . date('d M Y', strtotime($selesaiInput));
        } else {
            // JIKA TANPA FILTER: Ambil rentang otomatis dari data terkecil sampai terbesar di DB
            $transaksiPertama = \App\Models\Transaksi::orderBy('created_at', 'asc')->first();
            $transaksiTerakhir = \App\Models\Transaksi::orderBy('created_at', 'desc')->first();

            if ($transaksiPertama && $transaksiTerakhir) {
                $periodeTeks = $transaksiPertama->created_at->format('d M Y') . ' s/d ' . $transaksiTerakhir->created_at->format('d M Y');
            } else {
                $periodeTeks = 'Semua Periode (Data Kosong)';
            }
        }

        // Filter metode pembayaran jika ada
        if ($metode !== 'semua') {
            $query->where('metode_pembayaran', $metode);
        }

        // 2. Ambil angka kalkulasi statistik
        $totalPendapatan = (clone $query)->sum('total_bayar');
        $totalPengunjung = (clone $query)->count();
        $riwayatTransaksi = $query->with('registrasi.user')->orderBy('created_at', 'asc')->get();

        return view('admin.cetak', compact(
            'riwayatTransaksi',
            'totalPendapatan',
            'totalPengunjung',
            'periodeTeks',
            'metode',
            'cetakPengunjung'
        ));
    }
    public function riwayatSos()
    {
        // Kita ambil semua data SOS yang statusnya 'aktif', 'ditangani', maupun 'selesai'
        // Biar Admin bisa memantau semua pergerakan log SOS
        $sos = \App\Models\Sos::with(['registrasi.user', 'petugas'])
                    ->whereIn('status', ['aktif', 'ditangani', 'selesai'])
                    ->orderBy('created_at', 'desc')
                    ->get();

        return view('admin.sosadm', compact('sos'));
    }

    public function laporanSatwa()
    {
        $satwa = \App\Models\LaporanSatwa::with('user')
                    ->where('status', 'selesai')
                    ->orderBy('created_at', 'desc')
                    ->get();

        return view('admin.satwaadm', compact('satwa'));
    }
    public function users()
    {
        // Menggunakan orderByRaw agar role 'admin' dipaksa selalu paling atas,
        // baru setelah itu data lain diurutkan berdasarkan yang terbaru
        $users = User::whereIn('role', ['admin', 'karyawan', 'petugas_lapangan'])
                    ->orderByRaw("FIELD(role, 'admin', 'karyawan', 'petugas_lapangan') ASC")
                    ->orderBy('created_at', 'desc')
                    ->get();

        return view('admin.users', compact('users'));
    }

    public function storeUser(Request $request)
    {
        // 1. Validasi input form
        $request->validate([
            'nama_user' => 'required|string|max:255',
            'email'     => 'required|string|email|max:255|unique:user,email',
            'password'  => 'required|string|min:6',
            'role'      => 'required|in:karyawan,petugas_lapangan'
        ], [
            'email.unique' => 'Email/Username ini sudah terdaftar!',
            'password.min' => 'Password minimal harus 6 karakter.'
        ]);

        // 2. Simpan data ke database
        User::create([
            'nama_user' => $request->nama_user,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'role'      => $request->role,
        ]);

        // 3. Kembalikan dengan alert sukses (nanti ditangkap SweetAlert2 di master)
        return redirect()->back()->with('success', 'Akun ' . ucfirst($request->role) . ' baru berhasil didaftarkan!');
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->back()->with('success', 'Akun berhasil dihapus!');
    }
    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'nama_user' => 'required|string|max:255',
            'email'     => 'required|string|email|max:255|unique:user,email,' . $id . ',id_user',
            'role'      => 'required|in:karyawan,petugas_lapangan'
        ]);

        $user->nama_user = $request->nama_user;
        $user->email = $request->email;
        $user->role = $request->role;

        // Jika password diisi, baru kita update password-nya
        if ($request->filled('password')) {
            $request->validate(['password' => 'string|min:6']);
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->back()->with('success', 'Data akun ' . $user->nama_user . ' berhasil diperbarui!');
    }

    public function ulasan()
    {
        // Ambil semua ulasan, relasikan ke user untuk tahu siapa yang nulis
        $ulasan = \App\Models\Ulasan::with('user')->orderBy('created_at', 'desc')->get();
        return view('admin.ulasanadm', compact('ulasan'));
    }

    // 1. Admin membuat ulasan sendiri
    public function storeUlasan(Request $request)
    {
        $request->validate([
            'rating'   => 'required|integer|min:1|max:5',
            'komentar' => 'required|string',
        ]);

        \App\Models\Ulasan::create([
            'id_user'  => auth()->user()->id_user,
            'rating'   => $request->rating,
            'komentar' => $request->komentar,
        ]);

        return redirect()->back()->with('success', 'Ulasan admin berhasil diterbitkan!');
    }

    // 2. Admin membalas ulasan pendaki
    public function replyUlasan(Request $request, $id)
    {
        $request->validate(['balasan' => 'required|string']);

        $ulasan = \App\Models\Ulasan::findOrFail($id);
        $ulasan->balasan = $request->balasan; // Menyimpan teks balasan admin
        $ulasan->save();

        return redirect()->back()->with('success', 'Ulasan pendaki berhasil dibalas!');
    }

    // 3. Admin mengedit ulasan miliknya sendiri
    public function updateUlasan(Request $request, $id)
    {
        $request->validate([
            'komentar' => 'required|string',
            'rating'     => 'required|integer|min:1|max:5',
        ]);

        $ulasan = \App\Models\Ulasan::findOrFail($id);
        $ulasan->komentar = $request->komentar;
        $ulasan->rating = $request->rating;
        $user_id = auth()->user()->id_user;
        $ulasan->save();

        return redirect()->back()->with('success', 'Ulasan Anda berhasil diperbarui!');
    }

    // 4. Admin menghapus ulasan (Bisa ulasan pendaki atau ulasan sendiri)
    public function deleteUlasan($id)
    {
        $ulasan = \App\Models\Ulasan::findOrFail($id);
        $ulasan->delete();

        return redirect()->back()->with('success', 'Ulasan berhasil dihapus dari sistem!');
    }
    public function profil()
    {
        // Mengarah ke view resources/views/admin/profil.blade.php
        return view('admin.profil');
    }

    /**
     * Memproses perubahan data nama dan password akun pribadi
     */
    public function updateProfil(Request $request)
    {
        $user = Auth::user();

        // Validasi inputan form
        $request->validate([
            'nama' => 'required|string|max:255',
            'password_sekarang' => 'required',
            'password_baru' => 'nullable|min:6|confirmed', // confirmed berarti wajib sama dengan password_baru_confirmation
        ], [
            'password_sekarang.required' => 'Password sekarang wajib diisi untuk validasi.',
            'password_baru.min' => 'Password baru minimal harus 6 karakter.',
            'password_baru.confirmed' => 'Konfirmasi password baru tidak cocok.',
        ]);

        // Cek apakah password sekarang cocok dengan yang ada di database
        if (!Hash::check($request->password_sekarang, $user->password)) {
            return back()->withErrors(['password_sekarang' => 'Password saat ini yang Anda masukkan salah.']);
        }

        // === HAPUS LOGIKA IF-ELSE LAMA, GANTI LANGSUNG PAKAI INI ===
        // Kita langsung tembak ke nama kolom asli database kamu yaitu nama_user
        $user->nama_user = $request->nama;

        // Jika password baru diisi, maka update passwordnya
        if ($request->filled('password_baru')) {
            $user->password = Hash::make($request->password_baru);
        }

        $user->save();

        return redirect()->route('admin.profil')->with('success', 'Profil akun pribadi berhasil diperbarui!');
    }
}
