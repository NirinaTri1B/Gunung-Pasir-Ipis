@extends('layouts.pendaki_master')

@section('page_title', 'Riwayat Aktivitas Pendakian')

@section('content')
<div style="padding: 20px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
    <h2 style="color: #414833; font-weight: bold; margin-bottom: 25px;">Aktivitas Pendakian</h2>

    @forelse($aktivitas as $item)
        <div style="background: white; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); margin-bottom: 25px; overflow: hidden; border: 1px solid #eee;">

            <!-- Header Card: Status -->
            <div style="background: {{ $item->status_pendakian == 'aktif' ? '#656D4A' : '#414833' }}; padding: 12px 20px; color: white; display: flex; justify-content: space-between; align-items: center;">
                <span style="font-size: 14px; font-weight: 500;">ID: {{ $item->id_registrasi }}</span>
                <span style="background: rgba(255,255,255,0.2); padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: bold; text-transform: uppercase; letter-spacing: 1px;">
                    {{ $item->status_pendakian }}
                </span>
            </div>

            <div style="padding: 20px;">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">

                    <!-- Kolom Kiri: Detail Pendakian -->
                    <div>
                        <h4 style="margin: 0 0 10px 0; color: #656D4A; font-size: 16px;">
                            <i class="fas fa-hiking"></i> Detail Perjalanan
                        </h4>
                        <table style="width: 100%; font-size: 14px; color: #555; border-collapse: collapse;">
                            <tr>
                                <td style="padding: 5px 0; width: 40%;">Tanggal Naik</td>
                                <td style="padding: 5px 0;">: <strong>{{ date('d M Y', strtotime($item->tgl_naik)) }}</strong></td>
                            </tr>
                            <tr>
                                <td style="padding: 5px 0;">Jenis</td>
                                <td style="padding: 5px 0;">: {{ $item->jenis_pendakian }} ({{ $item->lama_menginap }} Hari)</td>
                            </tr>
                            <tr>
                                <td style="padding: 5px 0;">Anggota</td>
                                <td style="padding: 5px 0;">: {{ $item->jumlah_pendaki }} Orang</td>
                            </tr>
                        </table>
                    </div>

                    <!-- Kolom Kanan: Detail Sampah & Biaya -->
                    <div>
                        <h4 style="margin: 0 0 10px 0; color: #656D4A; font-size: 16px;">
                            <i class="fas fa-wallet"></i> Logistik & Biaya
                        </h4>
                        <table style="width: 100%; font-size: 14px; color: #555; border-collapse: collapse;">
                            <tr>
                                <td style="padding: 5px 0; width: 40%;">Sampah Awal</td>
                                <td style="padding: 5px 0;">: {{ $item->jumlah_sampah }} Kantong</td>
                            </tr>
                            <tr>
                                <td style="padding: 5px 0;">Total Bayar</td>
                                <td style="padding: 5px 0;">: <strong>Rp {{ number_format($item->transaksi->sum('total_bayar'), 0, ',', '.') }}</strong></td>
                            </tr>
                            <tr>
                                <td style="padding: 5px 0;">Metode</td>
                                <td style="padding: 5px 0;">: {{ $item->transaksi->first()->metode_pembayaran ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- BAGIAN CATATAN PELANGGARAN / APRESIASI -->
                <div style="margin-top: 20px; border-top: 1px dashed #ddd; padding-top: 15px;">
                    @if($item->total_denda > 0)
                        <div style="background: #fff5f5; border: 1px solid #feb2b2; padding: 12px; border-radius: 8px; display: flex; align-items: flex-start; gap: 10px;">
                            <span style="font-size: 20px;">⚠️</span>
                            <div>
                                <h5 style="color: #c53030; margin: 0; font-size: 14px; font-weight: bold;">Catatan Pelanggaran Sampah</h5>
                                <p style="margin: 3px 0 0 0; font-size: 13px; color: #742a2a;">
                                    Dikenakan denda <strong>Rp {{ number_format($item->total_denda, 0, ',', '.') }}</strong> karena anda tidak membawa kembali <strong>{{ $item->jumlah_sampah - $item->jumlah_sampah_akhir }} Sampah.</strong>
                                </p>
                                @if($item->deskripsi)
                                    <small style="display: block; margin-top: 5px; color: #9b2c2c; font-style: italic;">"{{ $item->deskripsi }}"</small>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @empty
        <div style="text-align: center; padding: 50px; background: white; border-radius: 15px; color: #999;">
            <i class="fas fa-mountain" style="font-size: 40px; margin-bottom: 15px; color: #eee;"></i>
            <p>Belum ada riwayat pendakian. Yuk, mulai petualanganmu!</p>
            <a href="{{ route('pendaki.registrasi') }}" style="display: inline-block; margin-top: 10px; color: #656D4A; font-weight: bold; text-decoration: none;">Daftar Sekarang →</a>
        </div>
    @endforelse
</div>
@endsection
