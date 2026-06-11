<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';
    protected $primaryKey = 'id_transaksi';
    public $incrementing = false;
    protected $keyType = 'string';

    // KOLOM YANG DIIZINKAN DIISI
    protected $fillable = [
        'id_transaksi',
        'id_registrasi',
        'total_bayar',
        'metode_pembayaran',
        'tgl_transaksi'
    ];
    public function registrasi()
    {
        return $this->belongsTo(Registrasi::class, 'id_registrasi', 'id_registrasi');
    }
}
