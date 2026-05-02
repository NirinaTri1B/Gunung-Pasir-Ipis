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
        'status'
    ];
    // Relasi ke tabel user
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
