<?php

namespace App\Models\Emergency;

use Illuminate\Database\Eloquent\Model;
use App\Models\CodificheFHIR\Language;
use App\Models\FHIR\CppQualification;

class Emergency extends Model
{
    protected $table = 'tbl_emergency';
    protected $primaryKey = 'id_emer';
    public $incrementing = false;
    public $timestamps = false;

    protected $casts = [
        'id_emer' => 'int',
        'id_emer_tipologia' => 'int',
        'id_utente' => 'int',
        'active' => 'bool'
    ];

    protected $dates = [
        'emer_nascita_data'
    ];

    protected $fillable = [
        'id_emer_tipologia',
        'id_utente',
        'emer_nome',
        'emer_cognome',
        'emer_nascita_data',
        'emer_codfiscale',
        'emer_sesso',
        'emer_n_iscrizione',
        'emer_localita_iscrizione',
        'active',
        'emer_lingua'
    ];
}
