<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Galeri extends Model
{
    protected $table = 'galeri';
    protected $primaryKey = 'id_galeri';

    public $incrementing = false; // Beritahu Laravel ini BUKAN auto increment angka
    protected $keyType = 'string';  // Beritahu Laravel kalau ID-nya berupa TEXT/STRING
        protected $fillable = [
        'id_galeri',
        'judul',
        'foto',
        'kategori',
    ];
}

