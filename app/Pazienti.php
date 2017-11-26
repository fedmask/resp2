<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Pazienti extends Model
{
    protected $table        = 'tbl_pazienti';
    protected $primaryKey   = "id_paziente";
    
    public function contacts(){
        return $this->hasOne("App\Contatti", "id_paziente");
    }
    
    public function getTelefono(){
        //L'eccezione potrebbe essere una proposta per gestire "errori" di questo tipo
        return isset($this->contacts->paziente_telefono) ? $this->contacts->paziente_telefono : 'Non pervenuto';
    }
    
    public function list(){
        $patient = $this::find(1);
       
        echo $patient->paziente_nome . "<- dalla tabella tbl_pazienti";
        echo $patient->contacts->paziente_telefono . "<- dalla tabella tbl_pazienti_contatti";
    }
	
	/**
	* Restituisce l'età del paziente calcolandola dall'anno attuale e dalla data di nascita
	*/
	public function age($date) {
		$age=Carbon::parse($date);
    	return $age->diffInYears(Carbon::now());
	}
	
}
