<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Anamnesi extends Model
{
    protected $table = 'tbl_anamnesi_familiare';
    protected $primaryKey = 'id_paziente';
    public $incrementing = true;
    public $timestamps = false;
    protected $casts = [
        'id_paziente' => 'int',
        'id_anamnesi_log' => 'int',
        'anamnesi_contenuto' => 'string'
    ];

    protected $fillable = [
        'id_paziente',
        'id_anamnesi_log',
        'anamnesi_contenuto'
    ];

    //getter function
    public function getID()
    {
        return $this->id_paziente;
    }

    public function getID_anamnesi_log()
    {
        return $this->id_anamnesi_log;
    }

    public function getAnamnesi_contenuto()
    {
        return $this->anamnesi_contenuto;
    }
}




