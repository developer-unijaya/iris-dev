<?php

namespace App\Models\Candidate;

use Illuminate\Database\Eloquent\Model;

class CandidateSkm extends Model
{
    protected $table = 'calon_skm';

    protected $fillable = [
    	'no_pengenalan',
        'kod_ruj_kelulusan',
        'tahun_lulus',
        'created_by',
        'updated_by',
    ];

    public function qualification() {
        return $this->belongsTo('App\Models\Reference\Qualification', 'kod_ruj_kelulusan', 'code');
    }
}
