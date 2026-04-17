<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanSatwa extends Model
{
    use HasFactory;

    //  nama tabelnya
    protected $table = 'laporan_satwa';

    // Tentukan kolom mana saja yang boleh diisi
    protected $fillable = [
        'id_user',
        'nama_satwa',
        'lokasi',
        'deskripsi',
        'foto',
        'status'
    ];

    // 3. Opsional: Kalau kamu mau otomatis ada jam laporannya
    // Laravel bakal nyari kolom 'created_at' dan 'updated_at' secara default
}
