<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registrasi extends Model
{
    use HasFactory;
    protected $table = 'registrasi';
    protected $primaryKey = 'id_registrasi';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'id_registrasi',
        'id_user',
        'jenis_pendakian',
        'lama_menginap',
        'jumlah_pendaki',
        'jumlah_sampah',
        'jumlah_sampah_akhir',
        'status_sampah',
        'total_denda',
        'status_pendakian',
        'tgl_naik',
        'deskripsi'
    ];

    public function transaksi()
    {
        // Satu registrasi bisa punya banyak transaksi (DP awal + denda jika ada)
        return $this->hasMany(Transaksi::class, 'id_registrasi', 'id_registrasi');
    }
    public function user()
    {
        // Sesuaikan 'id_user' dengan nama primary key di tabel users kamu
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
