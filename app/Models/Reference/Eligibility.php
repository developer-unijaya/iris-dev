<?php

namespace App\Models\Reference;

use Illuminate\Database\Eloquent\Model;

class Eligibility extends Model
{
    protected $table = 'ruj_kelayakan';

    protected $fillable = [
        'code',
        'name',
        'ref_skim_code',
        'category',
        'equivalent',
        'pemerolehan_code',
        'rank',
        'created_by',
        'updated_by',
        'is_active',
    ];
}
