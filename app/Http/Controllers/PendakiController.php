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
        // Ambil data user yang sedang login
        $user = Auth::user();
        return view('pendaki.dbpendaki', compact('user'));
    }

    // 2. Menyimpan Perubahan Profil (Alamat & No Telp)
    public function update(Request $request)
    {
        $user = Auth::user();

        // Validasi simpel
        $request->validate([
            'nama_user' => 'required|string|max:30',
            'no_telp'   => 'nullable|numeric',
            'alamat'    => 'nullable|string',
        ]);

        // Proses Update ke Database
        $user->update([
            'nama_user' => $request->nama_user,
            'no_telp'   => $request->no_telp,
            'alamat'    => $request->alamat,
        ]);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }
    // app/Http/Controllers/PendakiControlsler.php

    public function showProfil()
    {
        $user = Auth::user();
        // Arahkan ke file resources/views/pendaki/profil.blade.php
        return view('pendaki.profil', compact('user'));
    }
    public function kirimSos(Request $request)
    {
        \App\Models\Sos::create([
            'id_user'        => Auth::id(),
            'jenis_sos'      => $request->jenis_sos,
            'latitude'       => $request->latitude,
            'longitude'      => $request->longitude,
            'pesan_tambahan' => $request->pesan_tambahan,
            'status'         => 'aktif'
        ]);

        return response()->json(['success' => true, 'message' => 'Bantuan sedang dalam perjalanan!']);
    }
    public function destroyAccount()
    {
        $userId = auth()->id();
        $user = \App\Models\User::find($userId);

        if ($user) {
            // 1. SAPU BERSIH semua data di tabel lain yang pakai id_user ini
            // Urutannya: Hapus "Anak" dulu, baru "Bapak" (User) bisa dihapus

            \DB::table('notifikasi')->where('id_user', $userId)->delete(); // Error yang barusan
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
}
