<?php

namespace App\Models\Candidate;

use Illuminate\Database\Eloquent\Model;

class CandidateMatriculation extends Model
{
    protected $table = 'calon_matrikulasi';

    protected $fillable = [
    	'no_pengenalan',
        'tahun_lulus',
        'no_matrik',
        'jenis_sijil',
        'jurusan',
        'sesi',
        'semester',
        'kolej',
        'kod_subjek',
        'gred',
        'pngk',
        'created_by',
        'updated_by',
    ];

    public function course(){
        return $this->belongsTo('App\Models\Reference\MatriculationCourse', 'jurusan', 'code');
    }

    public function college(){
        return $this->belongsTo('App\Models\Reference\Matriculation', 'kolej', 'code');
    }

    public function subject(){
        return $this->belongsTo('App\Models\Reference\MatriculationSubject', 'kod_subjek', 'code');
    }
}
