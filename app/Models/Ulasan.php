<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ulasan extends Model
{
    protected $table = 'ulasan';

    protected $primaryKey = 'id_ulasan';

    protected $fillable = [
        'id_user',
        'komentar',
        'rating',
        'balasan',
        'tampilkan'
    ];

    /**
     * Relasi ke User
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'id_user');
    }
}
