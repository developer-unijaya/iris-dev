<?php

namespace App\Models\Reference;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisSkim extends Model
{
    protected $table = 'ruj_jenis_skim';

    protected $fillable = [
        'kod',
        'diskripsi',
        'id_pencipta',
        'pengguna',
        'sah_yt',
    ];

    const CREATED_AT = 'tarikh_cipta';
    const UPDATED_AT = 'tarikh_ubahsuai';
}
