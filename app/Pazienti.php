<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Pazienti extends Model
{
    protected $table        = 'tbl_pazienti';
    protected $primaryKey   = "id_paziente";
	public $timestamps 		= false;
	
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_utente', 'paziente_nome', 'paziente_cognome', 'paziente_nascita', 'paziente_codfiscale', 'paziente_sesso', 'paziente_gruppo',
		'paziente_rh', 'paziente_donatore_organi', 'paziente_stato_matrimoniale', 'id_paziente_contatti'
    ];

    
    public function contacts(){
        return $this->hasOne("App\Contatti", "id_paziente");
    }
    
    public static function findByIdUser($id_user){
        return Pazienti::where('id_utente', '=' , $id_user)->firstOrFail();
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
