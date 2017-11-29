<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipologie extends Model
{
    protected $table        = "tbl_utenti_tipologie";
    protected $primaryKey   = "id_tipologia";
    public $timestamps      = false;
}
