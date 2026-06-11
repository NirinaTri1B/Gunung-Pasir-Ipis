<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Konten extends Model
{
    protected $table = 'konten';
    protected $primaryKey = 'id';
    protected $fillable = ['key', 'value', 'label', 'grup'];
}
