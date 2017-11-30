<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contatti extends Model
{
    protected $table        = 'tbl_pazienti_contatti';
    protected $primaryKey   = "id_paziente";
	public $timestamps      = false;
    
    protected $fillable = [
        'id_paziente', 'id_comune_residenza', 'id_comune_nascita','paziente_telefono','paziente_indirizzo',
    ];
	
	public static function findByIdUser($id_user){
        return Contatti::where('id_paziente', '=' , $id_user)->firstOrFail();
    }
    
    
}
