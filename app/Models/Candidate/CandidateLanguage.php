<?php

namespace App\Models\Candidate;

use Illuminate\Database\Eloquent\Model;

class CandidateLanguage extends Model
{
    protected $table = 'calon_bahasa';

    protected $fillable = [
    	'no_pengenalan',
        'ref_language_code',
        'level',
        'created_by',
        'updated_by',
    ];

    public function language() {
        return $this->belongsTo('App\Models\Reference\Language', 'ref_language_code', 'kod');
    }

    public function kategori()
    {
        return $this->belongsTo('App\Models\Reference\KodPelbagai', 'level', 'kod');
    }
}
