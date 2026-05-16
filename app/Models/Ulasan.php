<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ulasan extends Model
{
    // 1. Kasih tahu Laravel kalau tabelnya namanya 'ulasan'
    protected $table = 'ulasan';

    // 2. Primay key-nya sesuai SQL tadi
    protected $primaryKey = 'id_ulasan';

    // 3. Kolom yang boleh diisi lewat form ulasan
    protected $fillable = [
        'id_user',
        'komentar',
        'rating',
        'balasan'
    ];

    /**
     * Relasi ke User (Opsional tapi berguna)
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'id_user');
    }
}
