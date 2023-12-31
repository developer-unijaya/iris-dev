<?php

namespace App\Models\Reference;

use Illuminate\Database\Eloquent\Model;

class Institution extends Model
{
    protected $table = 'ruj_institusi';

    protected $fillable = [
        'code',
        'name',
        'type',
        'ref_country_code',
        'pemerolehan_code',
        'category',
        'created_by',
        'updated_by',
        'is_active',
    ];
}
