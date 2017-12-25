<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Carbon\Carbon;
use App\Models\Pazienti;
use App\Models\ContattiPazienti;
use App\Models\UtentiTipologie;
use App\Models\Comuni;
use App\Models\StatiMatrimoniali;
use DB;
use Auth;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'tbl_utenti';
	protected $primaryKey = 'id_utente';
	public $timestamps = false;

	protected $casts = [
		'utente_tipologia' => 'int',
		'utente_stato' => 'int'
	];

	protected $dates = [
		'utente_scadenza'
	];

	protected $hidden = [
		'utente_password'
	];

	protected $fillable = [
		'utente_tipologia',
		'utente_nome',
		'utente_password',
		'utente_stato',
		'utente_scadenza',
		'utente_email'
	];

    /**
    * Identifica l'oggetto che definisce l'account dell'utente loggato.
    * Es. Paziente, CareProvider, etc...
    */
    private $_user_concrete_account = null;

    /**
    * A seconda della tipologia di account dell'utente loggato
    * restituisce un oggetto, appartenente alla classe di tale tipologia,
    * contenente tutte le informazioni ad esso associate.
    *
    */
    private function getUserConcreteAccount(){
    	switch($this->utente_tipologia){
			case 1:
				$this->_user_concrete_account = $this->patient;
				return;
			default:
				return 'Undefined';
		}
    }

    
    /**
     * 
     * Recupera i dati di paziente dell'utente
     */
    public function data_patient(){
        return $this->patient;
    }
	
    /*
	* Restituisce la tipologia di account dell'utente loggato
	*/
    public function getRole(){
    	return $this->user_type->tipologia_descrizione;
    }

    /**
     * Al momento ho voluto disattivare la funzionalità per ricordare l'accesso via token.
     * Attualmente si memorizza il token in una colonna, soluzione che rischia di avere
     * tanti valori NULL su molti utenti che NON desiderano memorizzare il proprio login.
     * E' necessario informarsi meglio per capire se via DB è l'unico modo "(sicuro)" di
     * consentire questa funzionalità.
     * Rimuovere questa funzione per riattivare il RememberMe. Ci sarà un errore di DB
     * in fase di logout.
     */
    public function setAttribute($key, $value)
    {
        $isRememberTokenAttribute = $key == $this->getRememberTokenName();
        if (!$isRememberTokenAttribute)
        {
            parent::setAttribute($key, $value);
        }
    }
    
    
    public function getEmailForPasswordReset(){
        return $this->utente_email;
    }
	
	/**
	* Ritorna il nome dell'utente loggato
	*/
	public function getName(){
		switch($this->utente_tipologia){
			case 1:
				return $this->data_patient()->first()->paziente_nome;
			default:
				return 'Undefined';
				break;
		}
	}
	
	/**
	* Ritorna il cognome dell'utente loggato
	*/
	public function getSurname(){
		switch($this->utente_tipologia){
			case 1:
				return $this->data_patient()->first()->paziente_cognome;
			default:
				return 'Undefined';
				break;
		}
	}
	
	/**
	* Ritorna il codice fiscale dell'utente loggato
	*/
	public function getFiscalCode(){
		switch($this->utente_tipologia){
			case 1:
				return $this->data_patient()->first()->paziente_codfiscale;
			default:
				return 'Undefined';
				break;
		}
	}
	
	/**
	* Ritorna la data di nascita dell'utente loggato
	*/
	public function getBirthdayDate(){
		switch($this->utente_tipologia){
			case 1:
				return $this->data_patient()->first()->paziente_nascita;
			default:
				return 'Undefined';
				break;
		}
	}
	
	/**
	* Ritorna l'età dell'utente loggato calcolandola dall'anno attuale e dalla data di nascita
	*/
	public function getAge($date) {
		$age=Carbon::parse($date);
    	return $age->diffInYears(Carbon::now());
	}
	
	/**
	* Ritorna il numero di telefono dell'utente loggato
	*/
 	public function getTelephone(){
		switch($this->utente_tipologia){
			case 1:
				return isset($this->contacts()->first()->contatto_telefono) ? $this->contacts()->first()->contatto_telefono : 'Non pervenuto';
			default:
				return 'Undefined';
		}
    }
	
	/**
	* Ritorna la mail dell'utente loggato
	*/
 	public function getEmail(){
			return $this->utente_email;
    }
	
	/**
	* Ritorna il sesso dell'utente loggato
	*/
 	public function getGender(){
		switch($this->utente_tipologia){
			case 1:
				return $this->data_patient()->first()->paziente_sesso;
			default:
				return 'Undefined';
				break;
		}
    }
	
	/**
	* Ritorna la città di nascita dell'utente loggato
	*/
 	public function getBirthTown(){
		$result = null;
			switch($this->utente_tipologia){
			case 1:
				$result = $this->contacts()->first()->id_comune_nascita;
				break;
			default:
				return 'Undefined';
				break;
			}
			return Comuni::find($result)->comune_nominativo;
    }
	
	/**
	* Ritorna la città dove risiede l'utente loggato
	*/
 	public function getLivingTown(){
		$result = null;
			switch($this->utente_tipologia){
			case 1:
				$result = $this->contacts()->first()->id_comune_residenza;
				break;
			default:
				return 'Undefined';
		}
		return Comuni::find($result)->comune_nominativo; // TODO: Se non funziona provare ad aggiungere first()
    }
	
	/**
	* Ritorna l'indirizzo dove risiede l'utente loggato
	*/
 	public function getAddress(){
		$result = null;
			switch($this->utente_tipologia){
			case 1:
				return Recapiti::find(Auth::id())->contatto_indirizzo; // TODO: Questa è vecchia!!
					break;
			default:
				return 'Undefined';
		}
    }
	
	/**
	* Ritorna lo stato matrimoniale dell'utente loggato
	*/
 	public function getMaritalStatus(){
 		switch($this->utente_tipologia){
			case 1:
				return StatiMatrimoniali::find($this->patient->id_stato_matrimoniale)->stato_matrimoniale_descrizione;
			default:
				return 'Undefined';
				break;
		}
    }
	
	/**
	* Ritorna il gruppo sanguigno e il tipo di rh dell'utente loggato
	*/
 	public function getFullBloodType(){
 		switch($this->utente_tipologia){
			case 1:
				return $this->data_patient()->first()->paziente_gruppo. " " .$this->data_patient()->first()->pazinte_rh;
			default:
				return 'Undefined';
				break;
		}
    }
	
	/**
	* Ritorna true se l'utente loggato acconsente alla donazione organi, false altrimenti
	*/
 	public function getOrgansDonor(){
			switch($this->utente_tipologia){
			case 1:
				return ($this->data_patient()->first()->paziente_donatore_organi == 0) ? false : true;
			default:
				return 'Undefined';
		}
    }

    public function user_type()
	{
		return $this->belongsTo(\App\Models\UtentiTipologie::class, 'utente_tipologia');
	}

	public function auditlog_logs()
	{
		return $this->hasMany(\App\Models\TblAuditlogLog::class, 'id_visitato');
	}

	public function care_providers()
	{
		return $this->hasMany(\App\Models\TblCareProvider::class, 'id_utente');
	}

	public function cpp_persona()
	{
		return $this->hasMany(\App\Models\CppPersona::class, 'id_utente');
	}

	public function patient()
	{
		return $this->hasMany(\App\Models\Pazienti::class, 'id_utente');
	}

	public function pazienti_familiarita()
	{
		return $this->hasMany(\App\Models\PazientiFamiliarita::class, 'id_parente');
	}

	public function contacts()
	{
		return $this->hasMany(\App\Models\Recapiti::class, 'id_utente');
	}
    
}
