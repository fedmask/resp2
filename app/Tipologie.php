<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipologie extends Model
{
    protected $table        = "tbl_utenti_tipologie";
    protected $primaryKey   = "id_tipologia";
    public $timestamps      = false;
	
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_tipologia', 'tipologia_descrizione',
    ];
	
	public static function findById($id_tipologia){
        return Tipologie::where('id_tipologia', '=' , $id_tipologia)->firstOrFail();
    }
}
