@extends('layouts.admin_master')

@section('page_title', 'Manajemen Master')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="font-weight-bold" style="color: #333D29;"><i class="fas fa-users-cog mr-2"></i> Kelola Akun Internal</h4>
    <button type="button" class="btn text-white font-weight-bold shadow-sm"
            style="background-color: #936639; border-radius: 8px;"
            data-toggle="modal" data-target="#modalTambahAkun">
        <i class="fas fa-user-plus mr-2"></i> Tambah Akun Baru
    </button>
</div>

@if ($errors->any())
    <div class="alert alert-danger border-0 shadow-sm mb-4" style="border-radius: 8px;">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card p-4 shadow-sm border-0" style="border-radius: 12px; background: #ffffff;">
    <table class="table align-middle" id="tabelUsersAdmin" style="border-collapse: separate; border-spacing: 0 10px; width:100%;">
        <thead style="text-align: center; background-color: #656D4A; border-radius: 8px;">
            <tr style="font-size: 13px; font-weight: 700; border-bottom: 2px solid #eef0eb; color: #ffffff;">
                <th class="p-3" style="width: 5%;">No</th>
                <th class="p-3">Nama Lengkap</th>
                <th class="p-3">Email</th>
                <th class="p-3">Jabatan</th>
                <th class="p-3">Tanggal Dibuat</th>
                <th class="p-3 text-center" style="width: 15%;">Aksi</th>
            </tr>
        </thead>
        <tbody style="font-size: 14px; color: #4a5568;">
            @forelse($users as $index => $u)
            <tr style="border-bottom: 1px solid #f4f6f0;">
                <td class="p-3 font-weight-bold text-muted text-center">{{ $index + 1 }}</td>

                <td class="p-3 font-weight-bold" style="color: #2d3748;">{{ $u->nama_user }}</td>
                <td class="p-3">{{ $u->email }}</td>

                <td class="p-3">
                    @if($u->jabatan == 'Admin Utama' || $u->role == 'admin')
                        <span style="color: #2d3748; font-weight: 600;">
                            <i class="fas fa-user-shield mr-1" style="font-size: 12px;"></i> Admin Utama
                        </span>
                    @elseif($u->jabatan == 'Karyawan' || $u->role == 'karyawan')
                        <span style="color: #556b2f; font-weight: 600;">
                            <i class="fas fa-user mr-1" style="font-size: 12px;"></i> Karyawan
                        </span>
                    @else
                        <span style="color: #718096; font-weight: 600;">
                            <i class="fas fa-hiking mr-1" style="font-size: 12px;"></i> Petugas Lapangan
                        </span>
                    @endif
                </td>

                <td class="p-3 text-center text-muted">{{ \Carbon\Carbon::parse($u->created_at)->format('d M Y') }}</td>

                <td class="p-3 text-center">
                    @if($u->jabatan == 'Admin Utama' || $u->role == 'admin')
                        <span class="text-muted" style="font-style: italic; font-size: 13px;">Tidak Dapat Diubah</span>
                    @else
                        <button type="button" class="btn btn-link text-success p-1 mx-1" title="Edit Akun" style="text-decoration: none;"
                                onclick="bukaModalEdit('{{ $u->id_user }}', '{{ $u->nama_user }}', '{{ $u->email }}', '{{ $u->role ?? $u->jabatan }}')">
                            <i class="fas fa-edit" style="font-size: 16px;"></i>
                        </button>

                        <form action="{{ route('admin.users.delete', $u->id_user) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus akun ini?')" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-link text-danger p-1 mx-1" title="Hapus Akun" style="border: none; background: none; outline: none;">
                                <i class="fas fa-trash" style="font-size: 16px;"></i>
                            </button>
                        </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center p-4 text-muted">Belum ada data akun internal.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="modal fade" id="modalTambahAkun" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 12px; border: none;">
            <div class="modal-header text-white" style="background-color: #936639; border-radius: 12px 12px 0 0;">
                <h5 class="modal-title font-weight-bold"><i class="fas fa-user-plus mr-2"></i> Form Tambah Akun Baru</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <div class="modal-body bg-light">
                    <div class="form-group">
                        <label class="font-weight-bold">Nama Lengkap</label>
                        <input type="text" name="nama_user" class="form-control" placeholder="Masukkan nama lengkap..." required style="border-radius: 8px;">
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Email / Username</label>
                        <input type="email" name="email" class="form-control" placeholder="contoh: ranger@gmail.com" required style="border-radius: 8px;">
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Password Sistem</label>
                        <input type="password" name="password" class="form-control" placeholder="Minimal 6 karakter..." required style="border-radius: 8px;">
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Hak Akses / Role Jabatan</label>
                        <select name="role" class="form-control" required style="border-radius: 8px;">
                            <option value="" disabled selected>-- Pilih Jabatan Tugas --</option>
                            <option value="karyawan">Karyawan (Staf Basecamp)</option>
                            <option value="petugas_lapangan">Petugas Lapangan (Tim Rescue)</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer bg-white" style="border-radius: 0 0 12px 12px;">
                    <button type="button" class="btn btn-secondary font-weight-bold" data-dismiss="modal" style="border-radius: 8px;">Batal</button>
                    <button type="submit" class="btn text-white font-weight-bold" style="background-color: #936639; border-radius: 8px;">Simpan Akun</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditAkun" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 12px; border: none;">
            <div class="modal-header text-white" style="background-color: #414833; border-radius: 12px 12px 0 0;">
                <h5 class="modal-title font-weight-bold"><i class="fas fa-edit mr-2"></i> Form Edit Data Akun</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formEditAkun" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body bg-light">
                    <div class="form-group">
                        <label class="font-weight-bold">Nama Lengkap</label>
                        <input type="text" id="edit_nama" name="nama_user" class="form-control" required style="border-radius: 8px;">
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Email / Username</label>
                        <input type="email" id="edit_email" name="email" class="form-control" required style="border-radius: 8px;">
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Password Baru <span class="text-muted font-italic" style="font-size: 11px;">(Kosongkan jika tidak ingin diubah)</span></label>
                        <input type="password" name="password" class="form-control" placeholder="Masukkan password baru jika mau ganti..." style="border-radius: 8px;">
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Hak Akses / Role Jabatan</label>
                        <select id="edit_role" name="role" class="form-control" required style="border-radius: 8px;">
                            <option value="karyawan">Karyawan (Staf Basecamp)</option>
                            <option value="petugas_lapangan">Petugas Lapangan (Tim Rescue)</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer bg-white" style="border-radius: 0 0 12px 12px;">
                    <button type="button" class="btn btn-secondary font-weight-bold" data-dismiss="modal" style="border-radius: 8px;">Batal</button>
                    <button type="submit" class="btn text-white font-weight-bold" style="background-color: #656D4A; border-radius: 8px;">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>

<style>
    .dataTables_wrapper .row:first-child {
        display: flex !important;
        justify-content: space-between !important;
        align-items: center !important;
        margin-bottom: 15px !important;
        padding: 0 5px !important;
    }
    .dataTables_wrapper .dataTables_filter {
        text-align: right !important;
    }
    .dataTables_wrapper .dataTables_paginate {
        margin-top: 15px !important;
        display: flex !important;
        justify-content: flex-end !important;
    }
</style>

<script>
    (function($) {
        $(document).ready(function() {
            if ($.fn.DataTable) {
                if ($.fn.DataTable.isDataTable('#tabelUsersAdmin')) {
                    $('#tabelUsersAdmin').DataTable().destroy();
                }

                $('#tabelUsersAdmin').DataTable({
                    "dom": "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                           "<'row'<'col-sm-12'tr>>" +
                           "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                    "pageLength": 10,
                    "searching": true,
                    "paging": true,
                    "info": true,
                    "ordering": true,
                    "language": {
                        "sLengthMenu":   "Tampilkan _MENU_ data",
                        "sZeroRecords":  "Tidak ditemukan akun internal",
                        "sInfo":         "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                        "sInfoEmpty":    "Menampilkan 0 sampai 0 dari 0 data",
                        "sSearch":       "Cari Akun:",
                        "oPaginate": {
                            "sPrevious": "<i class='fas fa-chevron-left'></i>",
                            "sNext":     "<i class='fas fa-chevron-right'></i>"
                        }
                    }
                });
            }
        });
    })(jQuery);

    function bukaModalEdit(id, nama, email, role) {
        document.getElementById('edit_nama').value = nama;
        document.getElementById('edit_email').value = email;
        document.getElementById('edit_role').value = role;
        document.getElementById('formEditAkun').action = `/admin/users/update/${id}`;
        jQuery('#modalEditAkun').modal('show');
    }
</script>
@endsection
