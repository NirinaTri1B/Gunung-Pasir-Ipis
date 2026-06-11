<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Keuangan - G. Puncak Pasir Ipis</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; font-size: 12px; color: #000; background: #fff; padding: 30px 40px; }

        /* KOP SURAT */
        .kop { display: flex; align-items: center; border-bottom: 3px double #000; padding-bottom: 12px; margin-bottom: 20px; }
        .kop-logo { width: 70px; height: 70px; margin-right: 20px; }
        .kop-text { text-align: center; flex: 1; }
        .kop-text h2 { font-size: 15px; font-weight: bold; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 3px; }
        .kop-text h3 { font-size: 12px; font-weight: normal; margin-bottom: 2px; }
        .kop-text p  { font-size: 11px; color: #333; }

        /* INFO LAPORAN */
        .info-laporan { margin-bottom: 16px; }
        .info-laporan table { border-collapse: collapse; }
        .info-laporan td { padding: 2px 8px 2px 0; font-size: 12px; vertical-align: top; }
        .info-laporan td:first-child { font-weight: bold; width: 160px; }

        /* JUDUL TABEL */
        .judul-tabel { text-align: center; font-size: 13px; font-weight: bold; text-transform: uppercase;
                       letter-spacing: 0.5px; margin-bottom: 8px; text-decoration: underline; }

        /* TABEL UTAMA */
        table.lap { width: 100%; border-collapse: collapse; margin-bottom: 0; }
        table.lap th, table.lap td { border: 1px solid #000; padding: 5px 8px; font-size: 11.5px; }
        table.lap thead tr { background-color: #d9d9d9; text-align: center; font-weight: bold; }
        table.lap tbody tr:nth-child(even) { background-color: #f5f5f5; }
        table.lap tbody td.number { text-align: right; }
        table.lap tbody td.center { text-align: center; }
        table.lap tfoot tr { background-color: #d9d9d9; font-weight: bold; }
        table.lap tfoot td { border: 1px solid #000; padding: 5px 8px; }

        /* RINGKASAN */
        .ringkasan { margin-top: 16px; border: 1px solid #000; width: 340px; margin-left: auto; }
        .ringkasan table { width: 100%; border-collapse: collapse; }
        .ringkasan table td { padding: 5px 10px; font-size: 12px; border-bottom: 1px solid #ccc; }
        .ringkasan table td:last-child { text-align: right; font-weight: bold; }
        .ringkasan table tr:last-child td { border-bottom: none; background: #d9d9d9; font-weight: bold; font-size: 13px; }
        .ringkasan-title { background: #414833; color: white; text-align: center; padding: 5px; font-weight: bold; font-size: 12px; }

        /* TTD */
        .ttd-section { margin-top: 50px; display: flex; justify-content: flex-end; }
        .ttd-box { text-align: center; width: 220px; }
        .ttd-box .ttd-nama { border-top: 1px solid #000; padding-top: 4px; font-weight: bold; margin-top: 60px; }

        @media print {
            body { padding: 15px 20px; }
        }
    </style>
</head>
<body>

    {{-- ===================== KOP SURAT ===================== --}}
    <div class="kop">
        <img src="{{ asset('img/logo.jpg') }}" class="kop-logo" alt="Logo">
        <div class="kop-text">
            <h2>Laporan Keuangan dan Transaksi</h2>
            <h3>Sistem Monitoring Keamanan Pendakian Gunung Puncak Pasir Ipis</h3>
            <p>Desa Cibeusi, Kecamatan Ciater, Kabupaten Subang, Jawa Barat</p>
        </div>
    </div>

    {{-- ===================== INFO LAPORAN ===================== --}}
    <div class="info-laporan">
        <table>
            <tr>
                <td>Periode Laporan</td>
                <td>: {{ $periodeTeks }}</td>
            </tr>
            <tr>
                <td>Total Transaksi</td>
                <td>: {{ $totalTransaksi }} Transaksi</td>
            </tr>
            @if($cetakPengunjung == 'ya')
            <tr>
                <td>Total Pendaki</td>
                <td>: {{ $totalPengunjung }} Orang</td>
            </tr>
            @endif
        </table>
    </div>

    {{-- ===================== TABEL TRANSAKSI ===================== --}}
    <div class="judul-tabel">Rincian Penerimaan Kas</div>

    <table class="lap">
        <thead>
            <tr>
                <th style="width:5%">No.</th>
                <th style="width:20%">Nama Pendaki</th>
                <th style="width:15%">Tanggal Transaksi</th>
                <th style="width:12%">Jenis Transaksi</th>
                <th style="width:12%">Metode Bayar</th>
                <th style="width:12%">Penerimaan Tiket</th>
                <th style="width:12%">Denda Sampah</th>
                <th style="width:12%">Total Penerimaan</th>
            </tr>
        </thead>
        <tbody>
            @php $grandTotal = 0; $totalDenda = 0; $totalTiket = 0; @endphp
            @forelse($riwayatTransaksi as $index => $t)
                @php
                    $dendaAsli      = $t->registrasi->total_denda ?? 0;
                    $tampilkanDenda = ($dendaAsli > 0 && $t->total_bayar == $dendaAsli) ? $dendaAsli : 0;
                    $nilaiTiket     = $t->total_bayar - $tampilkanDenda;
                    $grandTotal    += $t->total_bayar;
                    $totalDenda    += $tampilkanDenda;
                    $totalTiket    += $nilaiTiket;
                    $jenisTrx       = $tampilkanDenda > 0 ? 'Denda Sampah' : 'Tiket Masuk';
                @endphp
                <tr>
                    <td class="center">{{ $index + 1 }}</td>
                    <td>{{ $t->registrasi->user->nama_user ?? 'Pendaki' }}</td>
                    <td class="center">{{ $t->created_at->format('d/m/Y') }}</td>
                    <td class="center">{{ $jenisTrx }}</td>
                    <td class="center">{{ strtoupper($t->metode_pembayaran) }}</td>
                    <td class="number">Rp {{ number_format($nilaiTiket, 0, ',', '.') }}</td>
                    <td class="number">{{ $tampilkanDenda > 0 ? 'Rp ' . number_format($tampilkanDenda, 0, ',', '.') : '-' }}</td>
                    <td class="number">Rp {{ number_format($t->total_bayar, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="center" style="padding: 20px;">Tidak ada data transaksi pada periode ini.</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5" style="text-align:right; padding-right:10px;">JUMLAH TOTAL</td>
                <td class="number">Rp {{ number_format($totalTiket, 0, ',', '.') }}</td>
                <td class="number">Rp {{ number_format($totalDenda, 0, ',', '.') }}</td>
                <td class="number">Rp {{ number_format($grandTotal, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    {{-- ===================== RINGKASAN ===================== --}}
    <div class="ringkasan">
        <div class="ringkasan-title">RINGKASAN PENERIMAAN</div>
        <table>
            <tr>
                <td>Pendapatan Tiket Masuk</td>
                <td>Rp {{ number_format($totalTiket, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Pendapatan Denda Sampah</td>
                <td>Rp {{ number_format($totalDenda, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Total Penerimaan</td>
                <td>Rp {{ number_format($grandTotal, 0, ',', '.') }}</td>
            </tr>
        </table>
    </div>

    {{-- ===================== TTD (TIDAK DIUBAH) ===================== --}}
    <div class="ttd-section">
        <div class="ttd-box">
            <p>Subang, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}<br>Mengetahui, <strong>Admin Puncak Pasir Ipis</strong></p>
            <p class="ttd-nama">Muhammad Ridwan Firmansyah</p>
        </div>
    </div>

        <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>
