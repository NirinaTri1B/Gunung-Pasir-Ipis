<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Galeri extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'galeri';
    protected $primaryKey = 'id_galeri';
    protected $dates = ['deleted_at'];

    public $incrementing = false;
    protected $keyType = 'string';
        protected $fillable = [
        'id_galeri',
        'judul',
        'foto',
        'kategori',
    ];
}

