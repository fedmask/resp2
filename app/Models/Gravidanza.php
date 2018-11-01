<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gravidanza extends Model
{
    protected $table = 'tbl_gravidanze';
    protected $primaryKey = 'id_gravidanza';
    public $incrementing = true;
    public $timestamps = false;
    protected $casts = [
        'id_gravidanza' => 'int',
        'id_paziente' => 'int',
        'esito' => 'string',
        'eta' => 'string',
        'inizio_gravidanza' => 'date',
        'fine_gravidanza' => 'date',
        'sesso_bambino' => 'string',
        'note_gravidanza' => 'string'
    ];

    protected $dates = [
        'inizio_gravidanza',
        'fine_gravidanza'
    ];

    protected $fillable = [
        'id_gravidanza',
        'id_paziente',
        'esito',
        'eta',
        'inizio_gravidanza',
        'fine_gravidanza',
        'sesso_bambino',
        'note_gravidanza'
    ];


}
