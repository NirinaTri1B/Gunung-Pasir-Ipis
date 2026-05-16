@extends('layouts.karyawan_master')

@section('page_title', 'Riwayat Registrasi Pendaki')

@section('content')
<style>
    /* CSS PAGINATION AGAR RAPI */
    .pagination { display: flex; list-style: none; padding-left: 0; gap: 5px; margin-top: 20px; justify-content: flex-end; }
    .page-item .page-link { padding: 8px 14px; border: 1px solid #ddd; color: #414833; border-radius: 8px; text-decoration: none; font-weight: 600; }
    .page-item.active .page-link { background: #656D4A; color: white; border-color: #656D4A; }
    .page-item.disabled .page-link { color: #ccc; }
    nav div:first-child { display: none; } /* Sembunyikan text "Showing..." */

    /* Badge Style */
    .badge-tektok { background: #E3F2FD; color: #1976D2; padding: 4px 8px; border-radius: 6px; font-size: 10px; font-weight: 700; }
    .badge-camping { background: #FFF3E0; color: #E65100; padding: 4px 8px; border-radius: 6px; font-size: 10px; font-weight: 700; }
</style>

<div class="container-fluid">
    <div style="background: white; padding: 20px; border-radius: 15px; margin-bottom: 25px; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
        <form action="{{ route('karyawan.riwayat') }}" method="GET" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; align-items: end;">

            <div>
                <label style="font-size: 11px; font-weight: 700; color: #414833;">CARI NAMA:</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Ketik nama pendaki..." style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 12px;">
            </div>

            <div>
                <label style="font-size: 11px; font-weight: 700; color: #414833;">STATUS:</label>
                <select name="status" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 12px; font-family: 'Poppins';">
                    <option value=""> Semua Status </option>
                    <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Di Gunung</option>
                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>

            <div>
                <label style="font-size: 11px; font-weight: 700; color: #414833;">DARI:</label>
                <input type="date" name="tgl_mulai" value="{{ request('tgl_mulai') }}" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 12px;">
            </div>

            <div>
                <label style="font-size: 11px; font-weight: 700; color: #414833;">SAMPAI:</label>
                <input type="date" name="tgl_selesai" value="{{ request('tgl_selesai') ?? date('Y-m-d') }}" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 12px;">
            </div>

            <div style="display: flex; gap: 10px;">
                <button type="submit" style="flex: 2; background: #656D4A; color: white; border: none; padding: 11px; border-radius: 8px; font-weight: 700; cursor: pointer; font-size: 12px;">
                    <i class="fas fa-search"></i> CARI
                </button>
                <a href="{{ route('karyawan.riwayat') }}" style="flex: 1; text-align: center; text-decoration: none; background: #f0f0f0; color: #666; padding: 11px; border-radius: 8px; font-weight: 600; font-size: 12px;">
                    RESET
                </a>
            </div>

        </form>
    </div>

    <div style="background: white; padding: 25px; border-radius: 15px; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; font-size: 13px;">
                <thead>
                    <tr style="background-color: #F4F7F0; color: #414833; border-bottom: 2px solid #A4AC86; text-align: center;">
                        <th style="padding: 12px; width: 50px;">NO</th>
                        <th style="padding: 12px;">PENDAKI</th>
                        <th style="padding: 12px;">JENIS PENDAKIAN</th>
                        <th style="padding: 12px; text-align: center;">JUMLAH ORANG</th>
                        <th style="padding: 12px;">TANGGAL NAIK</th>
                        <th style="padding: 12px;">STATUS</th>
                        <th style="padding: 12px; text-align: right;">DENDA</th>
                        <th style="padding: 12px; text-align: right;">TOTAL BAYAR</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($riwayat as $r)
                    <tr style="border-bottom: 1px solid #eee;">
                        <td style="padding: 12px; font-weight: 700; color: #936639; text-align: center;">
                            {{ ($riwayat->currentPage() - 1) * $riwayat->perPage() + $loop->iteration }}
                        </td>
                        <td style="padding: 12px;">
                            <div style="font-weight: 600;">{{ $r->user->nama_user }}</div>
                            <div style="font-size: 10px; color: #aaa;">{{ $r->id_registrasi }}</div>
                        </td>
                        <td style="padding: 12px; text-align: center;">
                            <span class="{{ $r->jenis_pendakian == 'tektok' ? 'badge-tektok' : 'badge-camping' }}">
                                {{ strtoupper($r->jenis_pendakian) }}
                            </span>
                        </td>
                        <td style="padding: 12px; text-align: center; font-weight: 600;">
                            {{ $r->jumlah_pendaki }}
                        </td>
                        <td style="padding: 12px; text-align: center;">{{ \Carbon\Carbon::parse($r->tgl_naik)->format('d M Y') }}</td>
                        <td style="padding: 12px; text-align: center;">
                            <span style="color: {{ $r->status_pendakian == 'aktif' ? '#2E7D32' : '#757575' }}; font-weight: 700;">
                                {{ $r->status_pendakian == 'aktif' ? 'DI GUNUNG' : 'SELESAI' }}
                            </span>
                        </td>
                        <td style="padding: 12px; text-align: right; color: {{ ($r->total_denda ?? 0) > 0 ? '#dc3545' : '#888' }}; font-weight: 600;">
                            Rp {{ number_format($r->total_denda ?? 0, 0, ',', '.') }}
                        </td>
                        <td style="padding: 12px; text-align: right; font-weight: 700; color: #333D29;">
                            Rp {{ number_format($r->transaksi->sum('total_bayar'), 0, ',', '.') }}
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="8" style="text-align:center; padding:30px; color: #999;">Belum ada data riwayat.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination">
            {{ $riwayat->links() }}
        </div>
    </div>
</div>
@endsection
