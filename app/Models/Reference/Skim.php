<?php

namespace App\Models\Reference;

use Illuminate\Database\Eloquent\Model;

class Skim extends Model
{
    protected $table = 'ruj_skim';

    protected $fillable = [
        'code',
        'name',
        'created_by',
        'updated_by',
        'is_active',
    ];
}
