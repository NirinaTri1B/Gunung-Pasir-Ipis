@extends('layouts.petugas_master')

@section('page_title', 'Tugas Penyelamatan')

@section('content')
<div class="container-fluid">
    <h2 style="color: #414833; margin-bottom: 25px; font-weight: 700;">
        <i class="fas fa-running"></i> Daftar Tugas Aktif
    </h2>

    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 20px;">
        @forelse($tugasAktif as $tugas)
            <div class="stat-card" style="flex-direction: column; align-items: flex-start; border-left: 8px solid #d62828;">
                <div style="width: 100%; display: flex; justify-content: space-between; align-items: center;">
                    <h4 style="margin: 0; color: #333;">{{ $tugas->user->nama_user }}</h4>
                    <span style="font-size: 10px; background: #ffe5e5; color: #d62828; padding: 4px 10px; border-radius: 20px; font-weight: 800;">DARURAT</span>
                </div>

                <hr style="width: 100%; margin: 15px 0; border: 0; border-top: 1px solid #eee;">

                <p style="font-size: 14px; margin-bottom: 5px;"><strong>Kendala:</strong> {{ $tugas->jenis_sos }}</p>
                <p style="font-size: 13px; color: #666; margin-bottom: 15px;">
                    <i class="fas fa-map-marker-alt"></i> {{ $tugas->latitude }}, {{ $tugas->longitude }}
                </p>

                <form action="{{ route('petugas.konfirmasi', $tugas->id_sos) }}" method="POST" style="width: 100%;">
                    @csrf
                    <button type="submit" class="btn-reg-submit" style="width: 100%; background: #656D4A;">
                        KONFIRMASI & BERANGKAT
                    </button>
                </form>
            </div>
        @empty
            <div class="stat-card" style="justify-content: center; padding: 50px;">
                <div style="text-align: center; color: #A4AC86;">
                    <i class="fas fa-check-circle" style="font-size: 50px; display: block; margin-bottom: 15px;"></i>
                    <p style="font-weight: 600;">Belum ada tugas lapangan untuk saat ini.</p>
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection
