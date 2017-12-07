<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Carbon\Carbon;
use App\Pazienti;
use App\Contatti;
use DB;
use Auth;

class User extends Authenticatable
{
    use Notifiable;

    protected $table        = "tbl_utenti";
    protected $primaryKey   = "id_utente";
    public $timestamps      = false;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'utente_nome', 'utente_password', 'utente_tipologia','utente_scadenza', 'utente_email',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'utente_password',
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
				$this->_user_concrete_account = Pazienti::where('id_utente', Auth::id())->first();
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
        return $this->hasOne("App\Pazienti", "id_utente");
    }
	
    /*
	* Restituisce la tipologia di account dell'utente loggato
	*/
    public function getRole(){
		return Tipologie::find($this->utente_tipologia)->tipologia_descrizione;
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
        return "utente_email";
    }
	
	/**
	* Ritorna il nome dell'utente loggato
	*/
	public function getName(){
		if($this->_user_concrete_account == null)
			$this->getUserConcreteAccount();
		return $this->_user_concrete_account->paziente_nome;
	}
	
	/**
	* Ritorna il cognome dell'utente loggato
	*/
	public function getSurname(){
		if($this->_user_concrete_account == null)
			$this->getUserConcreteAccount();
		return $this->_user_concrete_account->paziente_cognome;
	}
	
	/**
	* Ritorna il codice fiscale dell'utente loggato
	*/
	public function getFiscalCode(){
		if($this->_user_concrete_account == null)
			$this->getUserConcreteAccount();
		return $this->_user_concrete_account->paziente_codfiscale;
	}
	
	/**
	* Ritorna la data di nascita dell'utente loggato
	*/
	public function getBirthdayDate(){
		if($this->_user_concrete_account == null)
			$this->getUserConcreteAccount();
		return $this->_user_concrete_account->paziente_nascita;
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
				return isset(Contatti::find(Auth::id())->paziente_telefono) ? Contatti::find(Auth::id())->paziente_telefono : 'Non pervenuto';
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
			if($this->_user_concrete_account == null)
			$this->getUserConcreteAccount();
		return $this->_user_concrete_account->paziente_sesso;
    }
	
	/**
	* Ritorna la città di nascita dell'utente loggato
	*/
 	public function getBirthTown(){
		$result = null;
			switch($this->utente_tipologia){
			case 1:
				$result = Contatti::find(Auth::id())->id_comune_nascita;
				break;
			default:
				return 'Undefined';
				break;
			}
			return DB::table('tbl_comuni')->where('id_comune', $result)->first()->comune_nominativo;
    }
	
	/**
	* Ritorna la città dove risiede l'utente loggato
	*/
 	public function getLivingTown(){
		$result = null;
			switch($this->utente_tipologia){
			case 1:
				$result = Contatti::find(Auth::id())->id_comune_residenza;
				break;
			default:
				return 'Undefined';
		}
		return DB::table('tbl_comuni')->where('id_comune', $result)->first()->comune_nominativo;
    }
	
	/**
	* Ritorna l'indirizzo dove risiede l'utente loggato
	*/
 	public function getAddress(){
		$result = null;
			switch($this->utente_tipologia){
			case 1:
				return Contatti::find(Auth::id())->paziente_indirizzo;
					break;
			default:
				return 'Undefined';
		}
    }
	
	/**
	* Ritorna lo stato matrimoniale dell'utente loggato
	*/
 	public function getMaritalStatus(){
		if($this->_user_concrete_account == null)
			$this->getUserConcreteAccount();
		return $this->_user_concrete_account->paziente_stato_matrimoniale;
    }
	
	/**
	* Ritorna il gruppo sanguigno e il tipo di rh dell'utente loggato
	*/
 	public function getFullBloodType(){
 		if($this->_user_concrete_account == null)
			$this->getUserConcreteAccount();
			switch($this->utente_tipologia){
			case 1:
				return $this->_user_concrete_account->paziente_gruppo. " " .$this->_user_concrete_account->paziente_rh;
			default:
				return 'Undefined';
		}
    }
	
	/**
	* Ritorna true se l'utente loggato acconsente alla donazione organi, false altrimenti
	*/
 	public function getOrgansDonor(){
			switch($this->utente_tipologia){
			case 1:
				return ($this->_user_concrete_account->paziente_donatore_organi == 0) ? false : true;
			default:
				return 'Undefined';
		}
    }
    
}
