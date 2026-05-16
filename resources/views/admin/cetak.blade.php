<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Transaksi - G. Puncak Pasir Ipis</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body { font-family: 'Arial', sans-serif; background-color: #fff; color: #000; }
        .Kop-Surat { border-bottom: 3px double #000; padding-bottom: 10px; margin-bottom: 25px; }
        @media print {
            .btn-print-box { display: none; }
            body { padding: 0; margin: 0; }
        }
    </style>
</head>
<body onload="window.print()">

    <div class="container mt-4">
        <div class="Kop-Surat d-flex align-items-center justify-content-center text-center">
            <div>
                <h2 class="font-weight-bold uppercase mb-1">LAPORAN KEUANGAN DAN TRANSAKSI</h2>
                <h4 class="mb-1">Sistem Monitoring Keamanan Pendakian Gunung Puncak Pasir Ipis</h4>
                <p class="mb-0 text-muted">Periode: {{ $periodeTeks }}</p>
            </div>
        </div>

        <div class="row mb-4">
            <div class="{{ $cetakPengunjung == 'ya' ? 'col-6' : 'col-12' }}">
                <div class="card card-body text-center border-dark">
                    <h5 class="mb-1 font-weight-bold text-uppercase">Total Pendapatan</h5>
                    <h3 class="font-weight-bold mb-0">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
                </div>
            </div>
            @if($cetakPengunjung == 'ya')
            <div class="col-6">
                <div class="card card-body text-center border-dark">
                    <h5 class="mb-1 font-weight-bold text-uppercase">Total Jumlah Pengunjung</h5>
                    <h3 class="font-weight-bold mb-0">{{ $totalPengunjung }} Orang</h3>
                </div>
            </div>
            @endif
        </div>

        <h5 class="font-weight-bold mb-2">Rincian Pembayaran:</h5>
        <table class="table table-bordered table-striped text-center">
            <thead class="thead-dark">
                <tr>
                    <th>No</th>
                    <th>Nama Pendaki</th>
                    <th>Tanggal Transaksi</th>
                    <th>Metode</th>
                    <th>Denda</th>
                    <th>Total Bayar</th>
                </tr>
            </thead>
            <tbody>
                @forelse($riwayatTransaksi as $index => $t)
                    @php
                        $dendaAsli = $t->registrasi->total_denda ?? 0;
                        $tampilkanDenda = ($dendaAsli > 0 && $t->total_bayar == $dendaAsli) ? $dendaAsli : 0;
                    @endphp
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $t->registrasi->user->nama_user ?? 'Pendaki' }}</td>
                        <td>{{ $t->created_at->format('d M Y, H:i') }} WIB</td>
                        <td>{{ strtoupper($t->metode_pembayaran) }}</td>
                        <td>Rp {{ number_format($tampilkanDenda, 0, ',', '.') }}</td>
                        <td class="font-weight-bold">Rp {{ number_format($t->total_bayar, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada data transaksi pada rentang filter ini.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="row mt-5 pt-4">
            <div class="col-8"></div>
            <div class="col-4 text-center">
                <p class="mb-5">Subang, {{ date('d F Y') }}<br>Mengetahui, <strong>Admin Puncak Pasir Ipis</strong></p>
                <br><br>
                <p class="border-top border-dark pt-1 font-weight-bold">Muhammad Ridwan Firmansyah</p>
            </div>
        </div>
    </div>

</body>
</html>
