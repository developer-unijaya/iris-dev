<?php

namespace App\Models\Candidate;

use Illuminate\Database\Eloquent\Model;

class CandidateProfessional extends Model
{
    protected $table = 'calon_profesional';

    protected $fillable = [
    	'no_pengenalan',
        'kod_ruj_kelulusan',
        'no_ahli',
        'tarikh',
        'created_by',
        'updated_by',
    ];

    public function qualification() {
        return $this->belongsTo('App\Models\Reference\Qualification', 'kod_ruj_kelulusan', 'code');
    }
}
