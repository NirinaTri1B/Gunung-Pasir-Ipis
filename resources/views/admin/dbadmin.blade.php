@extends('layouts.admin_master')

@section('page_title', 'Dashboard Admin')

@section('content')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">

<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div style="background: white; padding: 20px; border-radius: 15px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); display: flex; align-items: center; gap: 15px;">
                <div class="d-flex align-items-center">
                    <label class="mr-2 mb-0 font-weight-bold">DARI:</label>
                    <input type="date" id="tgl_mulai" class="form-control" style="width: 160px;">
                </div>
                <div class="d-flex align-items-center">
                    <label class="mr-2 mb-0 font-weight-bold">SAMPAI:</label>
                    <input type="date" id="tgl_selesai" class="form-control" style="width: 160px;">
                </div>
                <div class="d-flex align-items-center">
                    <label class="mr-2 mb-0 font-weight-bold">METODE:</label>
                    <select id="filter_metode" class="form-control" style="width: 120px;">
                        <option value="semua">Semua</option>
                        <option value="qris">QRIS</option>
                        <option value="cash">CASH</option>
                    </select>
                </div>
                <button class="btn font-weight-bold" style="background: #936639; color: white;" onclick="filterData()">
                    <i class="fas fa-filter"></i> FILTER
                </button>

                <button type="button" class="btn btn-success ml-2" style="background-color: #2e7d32; border: none; font-weight: 600;" onclick="bukaModalCetak()">
                    <i class="fas fa-print mr-1"></i> CETAK
                </button>

                <div class="modal fade" id="modalCetakLaporan" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header" style="background-color: #656D4A; color: white;">
                                <h5 class="modal-title font-weight-bold"><i class="fas fa-print mr-2"></i> Pengaturan Cetak Laporan</h5>
                                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p class="text-muted">Laporan akan dicetak berdasarkan rentang tanggal dan metode pembayaran yang sedang kamu pilih di filter.</p>
                                <hr>
                                <div class="form-group">
                                    <label class="font-weight-bold">Opsi Tambahan:</label>
                                    <div class="custom-control custom-checkbox mt-1">
                                        <input type="checkbox" class="custom-control-input" id="chk_pengunjung" checked>
                                        <label class="custom-control-label" for="chk_pengunjung">Sertakan Total Jumlah Pengunjung dalam Laporan</label>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                <button type="button" class="btn text-white" style="background-color: #656D4A;" onclick="prosesCetakLaporan()">Mulai Cetak</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-4">
            <div style="background: white; padding: 20px; border-radius: 15px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); border-bottom: 5px solid #936639; min-height: 110px;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p style="font-size: 11px; color: #888; margin: 0; font-weight: 600;">TOTAL PENDAPATAN</p>
                        <h3 id="txt_pendapatan" style="font-weight: 700; font-size: 20px; margin-top: 5px; color: #333;">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
                    </div>
                    <i class="fas fa-money-bill-wave" style="font-size: 28px; color: #936639; opacity: 0.2;"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div style="background: white; padding: 20px; border-radius: 15px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); border-bottom: 5px solid #656D4A; min-height: 110px;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p style="font-size: 11px; color: #888; margin: 0; font-weight: 600;">TOTAL PENGUNJUNG</p>
                        <h3 id="txt_pengunjung" style="font-weight: 700; font-size: 22px; margin-top: 5px; color: #333;">{{ $jumlahPengunjung }} Orang</h3>
                    </div>
                    <i class="fas fa-users" style="font-size: 28px; color: #656D4A; opacity: 0.2;"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div style="background: white; padding: 20px; border-radius: 15px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); border-bottom: 5px solid #A94442; min-height: 110px;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p style="font-size: 11px; color: #888; margin: 0; font-weight: 600;">SOS AKTIF</p>
                        <h3 style="font-weight: 700; color: #A94442; font-size: 22px; margin-top: 5px;">{{ $sosAktif ?? 0 }} Kejadian</h3>
                    </div>
                    <i class="fas fa-exclamation-triangle" style="font-size: 28px; color: #A94442; opacity: 0.2;"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-7">
            <div style="background: white; padding: 20px; border-radius: 15px; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
                <h6 class="font-weight-bold mb-3">TREN PENDAPATAN</h6>
                <div style="height: 250px;">
                    <canvas id="chartPendapatan"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div style="background: white; padding: 20px; border-radius: 15px; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
                <h6 class="font-weight-bold mb-3">STATISTIK SOS</h6>
                <div style="height: 250px;">
                    <canvas id="chartSOS"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div style="background: white; padding: 25px; border-radius: 15px; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
                <h5 class="font-weight-bold mb-4">RIWAYAT TRANSAKSI</h5>
                <div class="table-responsive">
                    <table id="tabelTransaksiAdmin" class="table table-hover table-striped w-100">
                        <thead style="background: #656D4A; color: white;">
                            <tr>
                                <th>NO</th>
                                <th>PENDAKI</th>
                                <th>TANGGAL</th>
                                <th>METODE</th>
                                <th class="text-right">DENDA</th>
                                <th class="text-right">TOTAL BAYAR</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($riwayatTransaksi as $t)
                                @php
                                    // Logika Pintar: Cek apakah transaksi ini memuat pembayaran denda
                                    $dendaAsli = $t->registrasi->total_denda ?? 0;
                                    $tampilkanDenda = ($dendaAsli > 0 && $t->total_bayar == $dendaAsli) ? $dendaAsli : 0;
                                @endphp
                                <tr>
                                    <td class="font-weight-bold" style="color: #936639;">{{ $loop->iteration }}</td>
                                    <td>{{ $t->registrasi->user->nama_user ?? 'Pendaki' }}</td>
                                    <td>{{ $t->created_at->format('d M Y, H:i') }}</td>
                                    <td><span class="badge badge-light border">{{ strtoupper($t->metode_pembayaran) }}</span></td>
                                    <td class="text-right text-{{ $tampilkanDenda > 0 ? 'danger' : 'muted' }}">
                                        Rp {{ number_format($tampilkanDenda, 0, ',', '.') }}
                                    </td>
                                    <td class="text-right font-weight-bold">
                                        Rp {{ number_format($t->total_bayar, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('scripts')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    let myIncomeChart;
    $(document).ready(function() {
        console.log("Sistem Siap!");

        // 1. Inisialisasi DataTables
        if ($.fn.DataTable) {
            $('#tabelTransaksiAdmin').DataTable({
                "pageLength": 10,
                "language": {
                    "sEmptyTable":   "Tidak ada data transaksi",
                    "sProcessing":   "Sedang memproses...",
                    "sLengthMenu":   "Tampilkan _MENU_ data",
                    "sZeroRecords":  "Tidak ditemukan data yang sesuai",
                    "sInfo":         "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    "sInfoEmpty":    "Menampilkan 0 sampai 0 dari 0 data",
                    "sInfoFiltered": "(disaring dari _MAX_ entri keseluruhan)",
                    "sSearch":       "Cari:",
                    "oPaginate": {
                        "sFirst":    "«",
                        "sPrevious": "‹",
                        "sNext":     "›",
                        "sLast":     "»"
                    }
                }
            });
        } else {
            console.error("DataTables tidak ditemukan. Pastikan library sudah ter-load dengan benar.");
        }

        // 2. Grafik Pendapatan
        const ctxIncome = document.getElementById('chartPendapatan');
        if (ctxIncome) {
            // GANTI 'new Chart' menjadi 'myIncomeChart = new Chart'
            myIncomeChart = new Chart(ctxIncome.getContext('2d'), {
                type: 'line',
                data: {
                    labels: {!! json_encode($labelGrafik) !!},
                    datasets: [{
                        label: 'Pendapatan (Rp)',
                        data: {!! json_encode($dataPendapatan) !!},
                        borderColor: '#936639',
                        backgroundColor: 'rgba(147, 102, 57, 0.1)',
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } }
                }
            });
        } else {
            console.error("Elemen canvas untuk grafik pendapatan tidak ditemukan.");
        }

        // 3. Grafik SOS
        const ctxSOS = document.getElementById('chartSOS');
        if (ctxSOS) {
            new Chart(ctxSOS.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: {!! json_encode($sosLabels) !!},
                    datasets: [{
                        data: {!! json_encode($sosCounts) !!},
                        backgroundColor: ['#A94442', '#936639', '#656D4A']
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { position: 'bottom' } }
                }
            });
        }
    });

    // 4. Fungsi Filter Data
    function filterData() {
        let mulai = document.getElementById('tgl_mulai').value;
        let selesai = document.getElementById('tgl_selesai').value;
        let metode = document.getElementById('filter_metode').value; // Tambahin ini

        if(!mulai || !selesai) {
            alert("Pilih tanggal mulai dan selesai dulu ya!");
            return;
        }

        // Selipin &metode=${metode} di ujung URL
        fetch(`/admin/dashboard/filter?tgl_mulai=${mulai}&tgl_selesai=${selesai}&metode=${metode}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('txt_pendapatan').innerText = data.pendapatan;
                document.getElementById('txt_pengunjung').innerText = data.pengunjung;

                if (myIncomeChart) {
                    myIncomeChart.data.labels = data.chart_labels;
                    myIncomeChart.data.datasets[0].data = data.chart_data;
                    myIncomeChart.update(); // Perintah animasi perubahannya
                }

                let table = $('#tabelTransaksiAdmin').DataTable();
                table.clear().draw();

                if (data.transaksi.length > 0) {
                    data.transaksi.forEach((t, index) => {
                        let dateObj = new Date(t.created_at);
                        let tgl = dateObj.toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' }) + ", " +
                                dateObj.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });

                        // LOGIKA PINTAR UNTUK JAVASCRIPT
                        let dendaAsli = t.registrasi ? parseInt(t.registrasi.total_denda || 0) : 0;
                        let totalBayar = parseInt(t.total_bayar || 0);
                        let tampilkanDenda = (dendaAsli > 0 && totalBayar == dendaAsli) ? dendaAsli : 0;

                        let dendaText = tampilkanDenda > 0
                            ? `<span class="text-danger text-right d-block">Rp ${tampilkanDenda.toLocaleString('id-ID')}</span>`
                            : `<span class="text-muted text-right d-block">Rp 0</span>`;

                        table.row.add([
                            `<span style="font-weight: 600; color: #936639;">${index + 1}</span>`,
                            t.registrasi?.user?.nama_user ?? 'Pendaki',
                            tgl,
                            `<span class="badge badge-light border">${t.metode_pembayaran.toUpperCase()}</span>`,
                            dendaText,
                            `<span class="font-weight-bold text-right d-block">Rp ${parseInt(t.total_bayar).toLocaleString('id-ID')}</span>`
                        ]).draw(false);
                    });
                }
            })
            .catch(error => {
                console.error("Error:", error);
                alert("Gagal memfilter data, pastikan format tanggal benar.");
            });
    }
    function bukaModalCetak() {
        $('#modalCetakLaporan').modal('show');
    }

    function prosesCetakLaporan() {
        let mulai = document.getElementById('tgl_mulai').value;
        let selesai = document.getElementById('tgl_selesai').value;
        let metode = document.getElementById('filter_metode').value;
        let cetakPengunjung = document.getElementById('chk_pengunjung').checked ? 'ya' : 'tidak';

        $('#modalCetakLaporan').modal('hide');

        // Kirim tanggal apa adanya (kalau kosong ya terkirim kosong, tidak apa-apa)
        let urlCetak = `/admin/dashboard/cetak?tgl_mulai=${mulai}&tgl_selesai=${selesai}&metode=${metode}&cetak_pengunjung=${cetakPengunjung}`;
        window.open(urlCetak, '_blank');
    }
</script>
@endsection
