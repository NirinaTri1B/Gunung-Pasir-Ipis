<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sos extends Model
{
    protected $table = 'sos';
    protected $primaryKey = 'id_sos';
    protected $fillable = [
        'id_user', 'jenis_sos', 'latitude', 'longitude', 'pesan_tambahan', 'status'
    ];
}
