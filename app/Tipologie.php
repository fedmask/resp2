<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipologie extends Model
{
    protected $table        = "tbl_tipologie";
    protected $primaryKey   = "id_tipologia";
    public $timestamps      = false;
}
