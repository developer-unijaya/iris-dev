<?php

namespace App\Models\Reference;

use Illuminate\Database\Eloquent\Model;

class JenisPerkhidmatan extends Model
{
    protected $table = 'ruj_jenis_perkhidmatan';

    protected $fillable = [
        'name',
        'sah_yt',
        'created_by',
        'updated_by',
    ];
}
