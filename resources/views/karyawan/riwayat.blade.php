@extends('layouts.karyawan_master')

@section('page_title', 'Riwayat Registrasi Pendaki')

@section('content')
<style>
    .pagination { display: flex; list-style: none; padding-left: 0; gap: 5px; margin-top: 20px; justify-content: flex-end; }
    .page-item .page-link { padding: 8px 14px; border: 1px solid #ddd; color: #414833; border-radius: 8px; text-decoration: none; font-weight: 600; }
    .page-item.active .page-link { background: #656D4A; color: white; border-color: #656D4A; }
    .page-item.disabled .page-link { color: #ccc; }
    nav div:first-child { display: none; }

    .badge-tektok  { background: #E3F2FD; color: #1976D2; padding: 4px 10px; border-radius: 6px; font-size: 10px; font-weight: 700; }
    .badge-camping { background: #FFF3E0; color: #E65100; padding: 4px 10px; border-radius: 6px; font-size: 10px; font-weight: 700; }
    .badge-aktif   { background: #E8F5E9; color: #2E7D32; padding: 4px 10px; border-radius: 6px; font-size: 10px; font-weight: 700; }
    .badge-selesai { background: #F5F5F5; color: #757575; padding: 4px 10px; border-radius: 6px; font-size: 10px; font-weight: 700; }
    .badge-warning { background: #FFF3E0; color: #E65100; padding: 4px 10px; border-radius: 6px; font-size: 10px; font-weight: 700; }

    .section-card { background: white; padding: 25px; border-radius: 15px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); margin-bottom: 25px; }
    .section-header { display: flex; align-items: center; gap: 10px; padding: 12px 18px; border-radius: 10px; margin-bottom: 20px; }
    .section-header h5 { margin: 0; font-weight: 700; font-size: 15px; }

    table { width: 100%; border-collapse: collapse; font-size: 13px; }
    thead tr { border-bottom: 2px solid #A4AC86; text-align: center; }
    thead th { padding: 12px; color: #414833; }
    tbody tr { border-bottom: 1px solid #f0f0f0; }
    tbody td { padding: 12px; }
</style>

<div class="container-fluid">

    {{-- ===== FILTER ===== --}}
    <div style="background: white; padding: 20px; border-radius: 15px; margin-bottom: 25px; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
        <form action="{{ route('karyawan.riwayat') }}" method="GET"
              style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; align-items: end;">
            <div>
                <label style="font-size: 11px; font-weight: 700; color: #414833;">CARI NAMA:</label>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Ketik nama pendaki..."
                       style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 12px;">
            </div>
            <div>
                <label style="font-size: 11px; font-weight: 700; color: #414833;">STATUS:</label>
                <select name="status" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 12px; font-family: 'Poppins';">
                    <option value="">Semua Status</option>
                    <option value="aktif"   {{ request('status') == 'aktif'   ? 'selected' : '' }}>Di Gunung</option>
                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>
            <div>
                <label style="font-size: 11px; font-weight: 700; color: #414833;">DARI:</label>
                <input type="date" name="tgl_mulai" value="{{ request('tgl_mulai') }}"
                       style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 12px;">
            </div>
            <div>
                <label style="font-size: 11px; font-weight: 700; color: #414833;">SAMPAI:</label>
                <input type="date" name="tgl_selesai" value="{{ request('tgl_selesai') ?? date('Y-m-d') }}"
                       style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 12px;">
            </div>
            <div style="display: flex; gap: 10px;">
                <button type="submit"
                        style="flex: 2; background: #656D4A; color: white; border: none; padding: 11px; border-radius: 8px; font-weight: 700; cursor: pointer; font-size: 12px;">
                    <i class="fas fa-search"></i> CARI
                </button>
                <a href="{{ route('karyawan.riwayat') }}"
                   style="flex: 1; text-align: center; text-decoration: none; background: #f0f0f0; color: #666; padding: 11px; border-radius: 8px; font-weight: 600; font-size: 12px;">
                    RESET
                </a>
            </div>
        </form>
    </div>

    {{-- ===== TABEL TEKTOK ===== --}}
    <div class="section-card">
        <div class="section-header" style="background: #E3F2FD;">
            <i class="fas fa-hiking" style="color: #1976D2; font-size: 18px;"></i>
            <h5 style="color: #1976D2;">Pendakian Tektok (Harian)</h5>
            <small style="color: #888; margin-left: auto;"><i class="fas fa-exclamation-circle" style="color: #E65100;"></i> Batas kembali ke basecamp: <strong>17.00 WIB</strong></small>
        </div>

        <div style="overflow-x: auto;">
            <table>
                <thead>
                    <tr style="background: #F4F7F0;">
                        <th style="width: 40px;">NO</th>
                        <th style="text-align: left;">PENDAKI</th>
                        <th>JUMLAH ORANG</th>
                        <th>TANGGAL & JAM NAIK</th>
                        <th>STATUS</th>
                        <th>KETERANGAN</th>
                        <th style="text-align: right;">DENDA</th>
                        <th style="text-align: right;">TOTAL BAYAR</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($riwayatTektok as $r)
                    @php
                        $jamNaik = \Carbon\Carbon::parse($r->tgl_naik);
                        $batasJam = $jamNaik->copy()->setTime(17, 0, 0);
                        $sekarang = now();

                        // Cek apakah sudah melewati batas 17.00 dan masih aktif
                        $lewatBatas = ($r->status_pendakian === 'aktif' && $sekarang->gt($batasJam));
                    @endphp
                    <tr style="{{ $lewatBatas ? 'background: #fff5f5;' : '' }}">
                        <td style="text-align: center; font-weight: 700; color: #936639;">
                            {{ ($riwayatTektok->currentPage() - 1) * $riwayatTektok->perPage() + $loop->iteration }}
                        </td>
                        <td>
                            <div style="font-weight: 600;">{{ $r->user->nama_user }}</div>
                            <div style="font-size: 10px; color: #aaa;">{{ $r->id_registrasi }}</div>
                        </td>
                        <td style="text-align: center; font-weight: 600;">{{ $r->jumlah_pendaki }} orang</td>
                        <td style="text-align: center;">
                            <div style="font-weight: 600;">{{ $jamNaik->format('d M Y') }}</div>
                            {{-- Jam naik ditampilkan --}}
                            <div style="font-size: 11px; color: #555;">
                                <i class="fas fa-clock"></i> {{ $jamNaik->format('H:i') }} WIB
                            </div>
                        </td>
                        <td style="text-align: center;">
                            @if($r->status_pendakian === 'aktif')
                                <span class="badge-aktif">DI GUNUNG</span>
                            @else
                                <span class="badge-selesai">SELESAI</span>
                            @endif
                        </td>
                        <td style="text-align: center;">
                            @if($lewatBatas)
                                <span class="badge-warning"><i class="fas fa-exclamation-triangle"></i> LEWAT BATAS JAM</span>
                            @elseif($r->status_pendakian === 'aktif')
                                <span style="font-size: 11px; color: #2E7D32;">Dalam batas waktu</span>
                            @else
                                <span style="font-size: 11px; color: #aaa;">-</span>
                            @endif
                        </td>
                        <td style="text-align: right; color: {{ ($r->total_denda ?? 0) > 0 ? '#dc3545' : '#888' }}; font-weight: 600;">
                            Rp {{ number_format($r->total_denda ?? 0, 0, ',', '.') }}
                        </td>
                        <td style="text-align: right; font-weight: 700; color: #333D29;">
                            Rp {{ number_format($r->transaksi->sum('total_bayar'), 0, ',', '.') }}
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="8" style="text-align:center; padding:30px; color:#999;">Tidak ada data tektok.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div>{{ $riwayatTektok->appends(request()->query())->links() }}</div>
    </div>

    {{-- ===== TABEL CAMPING ===== --}}
    <div class="section-card">
        <div class="section-header" style="background: #FFF3E0;">
            <i class="fas fa-campground" style="color: #E65100; font-size: 18px;"></i>
            <h5 style="color: #E65100;">Pendakian Camping (Menginap)</h5>
            <small style="color: #888; margin-left: auto;"><i class="fas fa-sort-amount-up" style="color: #656D4A;"></i> Diurutkan berdasarkan yang paling lama di gunung</small>
        </div>

        <div style="overflow-x: auto;">
            <table>
                <thead>
                    <tr style="background: #FFF9F0;">
                        <th style="width: 40px;">NO</th>
                        <th style="text-align: left;">PENDAKI</th>
                        <th>JUMLAH ORANG</th>
                        <th>TANGGAL NAIK</th>
                        <th>LAMA MENGINAP</th>
                        <th>STATUS</th>
                        <th>KETERANGAN</th>
                        <th style="text-align: right;">DENDA</th>
                        <th style="text-align: right;">TOTAL BAYAR</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($riwayatCamping as $r)
                    @php
                        $tglNaik  = \Carbon\Carbon::parse($r->tgl_naik);
                        $sekarang = now();

                        // Hitung berapa hari sudah di gunung
                        $hariDiGunung = $tglNaik->diffInDays($sekarang);

                        // Anggap camping normal max lama_menginap hari
                        $lamaRencana  = $r->lama_menginap ?? 1;
                        $lewatRencana = ($r->status_pendakian === 'aktif' && $hariDiGunung > $lamaRencana);
                    @endphp
                    <tr style="{{ $lewatRencana ? 'background: #fff5f5;' : '' }}">
                        <td style="text-align: center; font-weight: 700; color: #936639;">
                            {{ ($riwayatCamping->currentPage() - 1) * $riwayatCamping->perPage() + $loop->iteration }}
                        </td>
                        <td>
                            <div style="font-weight: 600;">{{ $r->user->nama_user }}</div>
                            <div style="font-size: 10px; color: #aaa;">{{ $r->id_registrasi }}</div>
                        </td>
                        <td style="text-align: center; font-weight: 600;">{{ $r->jumlah_pendaki }} orang</td>
                        <td style="text-align: center;">
                            <div style="font-weight: 600;">{{ $tglNaik->format('d M Y') }}</div>
                            <div style="font-size: 11px; color: #888;">{{ $tglNaik->format('H:i') }} WIB</div>
                        </td>
                        <td style="text-align: center;">
                            @if($r->status_pendakian === 'aktif')
                                {{-- Hitung real-time hari di gunung --}}
                                <span style="font-weight: 700; color: {{ $lewatRencana ? '#dc3545' : '#2E7D32' }};">
                                    {{ $hariDiGunung }} hari
                                </span>
                                <div style="font-size: 10px; color: #aaa;">Rencana: {{ $lamaRencana }} hari</div>
                            @else
                                <span style="color: #aaa;">{{ $lamaRencana }} hari</span>
                            @endif
                        </td>
                        <td style="text-align: center;">
                            @if($r->status_pendakian === 'aktif')
                                <span class="badge-aktif">DI GUNUNG</span>
                            @else
                                <span class="badge-selesai">SELESAI</span>
                            @endif
                        </td>
                        <td style="text-align: center;">
                            @if($lewatRencana)
                                <span class="badge-warning"><i class="fas fa-exclamation-triangle"></i> MELEBIHI RENCANA</span>
                            @elseif($r->status_pendakian === 'aktif')
                                <span style="font-size: 11px; color: #2E7D32;">Sesuai rencana</span>
                            @else
                                <span style="font-size: 11px; color: #aaa;">-</span>
                            @endif
                        </td>
                        <td style="text-align: right; color: {{ ($r->total_denda ?? 0) > 0 ? '#dc3545' : '#888' }}; font-weight: 600;">
                            Rp {{ number_format($r->total_denda ?? 0, 0, ',', '.') }}
                        </td>
                        <td style="text-align: right; font-weight: 700; color: #333D29;">
                            Rp {{ number_format($r->transaksi->sum('total_bayar'), 0, ',', '.') }}
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="9" style="text-align:center; padding:30px; color:#999;">Tidak ada data camping.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div>{{ $riwayatCamping->appends(request()->query())->links() }}</div>
    </div>

</div>
@endsection
