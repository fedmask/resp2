<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contatti extends Model
{
    protected $table        = 'tbl_pazienti_contatti';
    protected $primaryKey   = "id_paziente";
}
