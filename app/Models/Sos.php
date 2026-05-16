<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sos extends Model
{
    protected $table = 'sos';
    protected $primaryKey = 'id_sos';
    protected $fillable = [
        'id_user',
        'id_registrasi',
        'jenis_sos',
        'latitude',
        'longitude',
        'pesan_tambahan',
        'status',
        'id_petugas',
        'lat_petugas',
        'lng_petugas',
        'status_sos'
    ];

    // relasi ke tabel registrasi
    public function registrasi()
    {
        return $this->belongsTo(\App\Models\Registrasi::class, 'id_registrasi');
    }
    public function petugas()
    {
        return $this->belongsTo(\App\Models\User::class, 'id_petugas');
    }

    // Relasi ke tabel user
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
