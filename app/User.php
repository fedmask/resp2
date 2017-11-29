<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Carbon\Carbon;
use App\Pazienti;
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
        return $this->hasOne("App\Tipologie", "tipologia_descrizione");
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
		switch($this->utente_tipologia){
			case 1:
				return Pazienti::findByIdUser(Auth::id())->paziente_nome;
			default:
				return 'Undefined';
		}
	}
	
	/**
	* Ritorna il cognome dell'utente loggato
	*/
	public function getSurname(){
		switch($this->utente_tipologia){
			case 1:
				return Pazienti::findByIdUser(Auth::id())->paziente_cognome;
			default:
				return 'Undefined';
		}
	}
	
	/**
	* Ritorna il codice fiscale dell'utente loggato
	*/
	public function getFiscalCode(){
		switch($this->utente_tipologia){
			case 1:
				return Pazienti::findByIdUser(Auth::id())->paziente_codfiscale;
			default:
				return 'Undefined';
		}
	}
	
	/**
	* Ritorna la data di nascita dell'utente loggato
	*/
	public function getBirthdayDate(){
		switch($this->utente_tipologia){
			case 1:
				return Pazienti::findByIdUser(Auth::id())->paziente_nascita;
			default:
				return 'Undefined';
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
				return isset(Pazienti::findByIdUser(Auth::id())->contacts->paziente_telefono) ? Pazienti::findByIdUser(Auth::id())->contacts->paziente_telefono : 'Non pervenuto';
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
				return Pazienti::findByIdUser(Auth::id())->paziente_sesso;
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
				return Pazienti::findByIdUser(Auth::id())->paziente_stato_matrimoniale;
			default:
				return 'Undefined';
		}
    }
	
	/**
	* Ritorna il gruppo sanguigno e il tipo di rh dell'utente loggato
	*/
 	public function getFullBloodType(){
			switch($this->utente_tipologia){
			case 1:
				return Pazienti::findByIdUser(Auth::id())->paziente_gruppo. " " .Pazienti::findByIdUser(Auth::id())->paziente_rh;
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
				return (Pazienti::findByIdUser(Auth::id())->paziente_donatore_organi === 0) ? false : true;
			default:
				return 'Undefined';
		}
    }
    
}
