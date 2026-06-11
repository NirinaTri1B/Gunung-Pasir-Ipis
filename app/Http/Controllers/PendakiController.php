<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Sos;
use App\Models\User;

class PendakiController extends Controller
{
    // 1. Menampilkan Halaman Dashboard
    public function index()
    {
        // 1. Ambil data user yang sedang login
        $user = \Auth::user();

        // 2. Cek apakah ada laporan SOS milik user ini yang belum selesai
        $sosAktif = \App\Models\Sos::where('id_user', $user->id_user)
                    ->whereIn('status', ['aktif', 'ditangani'])
                    ->first();

        // 3. Cek apakah pendaki ini punya registrasi yang statusnya 'aktif'
        // Ini buat kunci/buka menu SOS & Satwa
        $isAktif = \App\Models\Registrasi::where('id_user', $user->id_user)
                    ->where('status_pendakian', 'aktif')
                    ->exists();

        return view('pendaki.dbpendaki', compact('user', 'sosAktif', 'isAktif'));
    }

        public function showProfil()
    {
        $user = Auth::user();

        // ini buat cek apakah pendaki ini punya registrasi yang statusnya 'aktif' (buat kunci/buka menu SOS & Satwa)
        $isAktif = \App\Models\Registrasi::where('id_user', $user->id_user)
                    ->where('status_pendakian', 'aktif')
                    ->exists();

        return view('pendaki.profil', compact('user', 'isAktif'));
    }

    public function update(Request $request)
    {
        $user = \App\Models\User::find(auth()->user()->id_user);

        // 1. Validasi input
        $request->validate([
            'nama_user' => 'required|string|max:255',
            'no_telp'   => 'nullable|numeric',
            'alamat'    => 'nullable|string',
            'password'  => 'nullable|confirmed|min:6', // Pastikan password & konfirmasi cocok
        ]);

        // 2. Update data dasar
        $user->nama_user = $request->nama_user;
        $user->no_telp   = $request->no_telp;
        $user->alamat    = $request->alamat;

        // 3. Logika Ganti Password
        if ($request->filled('password')) {
            $user->password = \Illuminate\Support\Facades\Hash::make($request->password);
        }

        $user->save();

        return redirect()->back()->with('success', 'Profil akun berhasil diperbarui!');
    }

        public function destroyAccount()
    {
        $userId = auth()->id();
        $user = \App\Models\User::find($userId);

        if ($user) {

            \DB::table('laporan_satwa')->where('id_user', $userId)->delete();
            \DB::table('ulasan')->where('id_user', $userId)->delete();
            \DB::table('sos')->where('id_user', $userId)->delete();

            // Tambahan: Hapus juga pendaftaran hiking kalau ada
            if (\Schema::hasTable('pendaftaran_hiking')) {
                \DB::table('pendaftaran_hiking')->where('id_user', $userId)->delete();
            }

            // 2. Setelah semua tabel pendukung bersih, baru hapus user utamanya
            $user->delete();

            // 3. Logout
            auth()->logout();

            return redirect('/')->with('success', 'Akun kamu dan seluruh data terkait telah dihapus.');
        }

        return redirect()->back()->with('error', 'User tidak ditemukan.');
    }

    public function kirimSos(Request $request)
    {
        // Cari data registrasi si pendaki yang statusnya masih 'mendaki'
        $registrasi = \App\Models\Registrasi::where('id_user', auth()->user()->id_user)
                                            ->where('status_pendakian', 'aktif') // nama kolom & status di DB
                                            ->first();

        \App\Models\Sos::create([
            'id_user' => auth()->user()->id_user,
            'id_registrasi' => $registrasi ? $registrasi->id_registrasi : null,
            'jenis_sos' => $request->jenis_sos,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'status' => 'aktif',
            'status_sos' => 'pending'
        ]);

        return response()->json(['success' => true]);
    }

    public function updateLokasiPendaki(Request $request)
    {
        $sos = Sos::where('id_user', auth()->user()->id_user)
                ->whereIn('status', ['aktif', 'ditangani'])
                ->first();

        if ($sos) {
            $sos->update([
                'latitude' => $request->lat,
                'longitude' => $request->lng
            ]);
            return response()->json(['status' => 'success']);
        }
        return response()->json(['status' => 'error'], 404);
    }
    public function aktivitas()
    {
        $userId = auth()->user()->id_user;

        // Ambil data aktivitas
        $aktivitas = \App\Models\Registrasi::with('transaksi')
                    ->where('id_user', $userId)
                    ->orderBy('created_at', 'desc')
                    ->get();

        $isAktif = \App\Models\Registrasi::where('id_user', $userId)
                    ->where('status_pendakian', 'aktif')
                    ->exists();

        return view('pendaki.aktivitas', compact('aktivitas', 'isAktif'));
    }
    public function informasiUmum()
    {
        // 1. Ambil ID user yang sedang login
        $userId = auth()->user()->id_user;

        // 2. Cek apakah pendaki ini punya registrasi yang statusnya masih 'aktif'
        $isAktif = \App\Models\Registrasi::where('id_user', $userId)
                    ->where('status_pendakian', 'aktif')
                    ->exists();

        $konten = \App\Models\Konten::all()->keyBy('key');

        // 3. Kirim variabel $isAktif ke view informasi
        return view('pendaki.informasi', compact('isAktif', 'konten'));
    }

    //     public function halamanSos()
    // {
    //     $idUser = auth()->user()->id_user;

    //     $sosAktif = \App\Models\Sos::where('id_user', $idUser)
    //                 ->whereIn('status', ['aktif', 'ditangani'])
    //                 ->first();

    //     $isAktif = \App\Models\Registrasi::where('id_user', $idUser)
    //                 ->where('status_pendakian', 'aktif')
    //                 ->exists();

    //     return view('pendaki.sos', compact('sosAktif', 'isAktif'));
    // }
}
