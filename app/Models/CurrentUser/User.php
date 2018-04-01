<?php

namespace App\Models\CurrentUser;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Carbon\Carbon;
use App\Models\Patient\Pazienti;
use App\Models\UtentiTipologie;
use App\Models\Domicile\Comuni;
use App\Models\Patient\StatiMatrimoniali;
use DB;
use Auth;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'tbl_utenti';
	protected $primaryKey = 'id_utente';
	public $timestamps = false;

	const PATIENT_ID           = "ass";
	const PATIENT_DESCRIPTION  = "Assistito";
	const CAREPROVIDER_ID  = "cpp";
	
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
		'id_tipologia',
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
     * 
     * Recupera i dati dell'utente loggato nel caso sia un paziente.
     */
    public function data_patient(){
        return $this->patient;
    }

    /*
	* Restituisce il ruolo dell'utente loggato.
	*/
    public function getRole(){
    	return $this->user_type->tipologia_nome;
    }
	
    /*
	* Restituisce la descrizione del ruolo dell'utente loggato.
	*/
    public function getDescription(){
    	return $this->user_type->tipologia_descrizione;
    }

    /**
     * Al momento ho voluto disattivare la funzionalit� per ricordare l'accesso via token.
     * Attualmente si memorizza il token in una colonna, soluzione che rischia di avere
     * tanti valori NULL su molti utenti che NON desiderano memorizzare il proprio login.
     * E' necessario informarsi meglio per capire se via DB � l'unico modo "(sicuro)" di
     * consentire questa funzionalit�.
     * Rimuovere questa funzione per riattivare il RememberMe. Ci sar� un errore di DB
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
     * Restituisce la scadenza di validit� per questo utente
     */
    
    public function getExpireDate(){
        return $this->utente_scadenza;
    }
    
    public function setIDTipology($idTp){
        $this->id_tipologia = $idTp;
    }
    
    public function setUsername($username){
        $this->utente_nome = $username;
    }
    
    public function setPassword($password){
        $this->utente_password = $password;
    }
    
    public function setStatus($status){
        $this->utente_stato = $status;
    }
    
    public function setEmail($email){
        $this->utente_email = $email;
    }
    
    
    /**
     * Restituisce lo stato (1 o 0) boolean
     */
    
    public function getStatus(){
        return $this->utente_stato;
    }
    
    public function getID(){
        return $this->id_utente;
    }
    
    /**
     * Restituisce l'username
     */
	
    public function getUsername(){
        return $this->utente_nome;
    }
    
    /**
     * Restituisce la password
     */
    
    public function getPassword(){
        return $this->utente_password;
    }
    
	/**
	* Ritorna il nome dell'utente loggato
	*/
	public function getName(){
	    switch($this->getRole()){
	        case $this::PATIENT_ID:
				return $this->data_patient()->first()->paziente_nome;
			case $this::CAREPROVIDER_ID:
				return $this->care_providers()->first()->cpp_nome;
			default:
				break;
		}
	}
	
	/**
	* Ritorna il cognome dell'utente loggato
	*/
	public function getSurname(){
	    switch($this->getRole()){
	        case $this::PATIENT_ID:
				return $this->data_patient()->first()->paziente_cognome;
			case $this::CAREPROVIDER_ID:
				return $this->care_providers()->first()->cpp_cognome;
			default:
				break;
		}
	}
	
	/**
	* Ritorna il codice fiscale dell'utente loggato
	*/
	public function getFiscalCode(){
	    switch($this->getRole()){
	        case $this::PATIENT_ID:
				return $this->data_patient()->first()->paziente_codfiscale;
			case $this::CAREPROVIDER_ID:
				return $this->care_providers()->first()->cpp_codfiscale;
			default:
				break;
		}
	}
	
	/**
	* Ritorna la data di nascita dell'utente loggato
	*/
	public function getBirthdayDate(){

		switch($this->getRole()){
		    case $this::PATIENT_ID:
				return $this->data_patient()->first()->paziente_nascita;
			case $this::CAREPROVIDER_ID:
				return $this->care_providers()->first()->cpp_nascita_data;
			default:
				break;
		}
	}
	
	/**
	* Ritorna l'et� dell'utente loggato calcolandola dall'anno attuale e dalla data di nascita
	*/
	public function getAge($date) {
		$age=Carbon::parse($date);
    	return $age->diffInYears(Carbon::now());
	}
	
	/**
	* Ritorna il numero di telefono dell'utente loggato
	*/
 	public function getTelephone(){
		switch($this->getRole()){
		    case $this::PATIENT_ID:
				return isset($this->contacts()->first()->contatto_telefono) ? $this->contacts()->first()->contatto_telefono : 'Non pervenuto';
			case $this::CAREPROVIDER_ID:
				return isset($this->contacts()->first()->contatto_telefono) ? $this->contacts()->first()->contatto_telefono : 'Non pervenuto';
			default:
				break;
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
		switch($this->getRole()){
		    case $this::PATIENT_ID:
				return $this->data_patient()->first()->paziente_sesso;
			case $this::CAREPROVIDER_ID:
				return $this->care_providers()->first()->cpp_sesso;
			default:
				break;
		}
    }
	
	/**
	* Ritorna la citt� di nascita dell'utente loggato
	*/
 	public function getBirthTown(){
		$result = $this->contacts()->first()->id_comune_nascita;
		return Comuni::find($result)->comune_nominativo;
    }
	
	/**
	* Ritorna la citt� dove risiede l'utente loggato
	*/
 	public function getLivingTown(){
		$result = $this->contacts()->first()->id_comune_residenza;
		return Comuni::find($result)->comune_nominativo;
    }
    
    public function getCapLivingTown(){
        $result = $this->contacts()->first()->id_comune_residenza;
        return Comuni::find($result)->comune_cap;
    }
	
	/**
	* Ritorna l'indirizzo dove risiede l'utente loggato
	*/
 	public function getAddress(){
		return $this->contacts()->first()->contatto_indirizzo;
    }
	
	/**
	* Ritorna lo stato matrimoniale dell'utente loggato
	*/
 	public function getMaritalStatus(){
 		switch($this->id_tipologia){
 		    case $this::PATIENT_ID:
				return StatiMatrimoniali::where('id_stato_matrimoniale', $this->patient()->first()->id_stato_matrimoniale)->first()->stato_matrimoniale_nome;
			default:
				return 'Undefined';
		}
    }
	
	/**
	* Ritorna il gruppo sanguigno e il tipo di rh dell'utente loggato
	*/
 	public function getFullBloodType(){
 		switch($this->id_tipologia){
 		    case $this::PATIENT_ID:
				return $this->getBloodGroup($this->data_patient()->first()->paziente_gruppo). " " .$this->data_patient()->first()->pazinte_rh;
			default:
				return 'Undefined';
				break;
		}
    }

    /**
    * Associa il valore numerico registrato nel db per i gruppi sanguigni
    * al valore nominale.
    */
    private function getBloodGroup($group){
    	switch ($group) {
    		case '0':
    			return '0';
    			break;
    		case '1':
    			return 'A';
    			break;
    		case '2':
    			return 'B';
    			break;
    		case '3':
    			return 'AB';
    			break;
    		default:
    			return 'Undefined';
    			break;
    	}
    }
	
	/**
	* Ritorna true se l'utente loggato acconsente alla donazione organi, false altrimenti
	*/
 	public function getOrgansDonor(){
			switch($this->id_tipologia){
			    case $this::PATIENT_ID:
				return ($this->data_patient()->first()->paziente_donatore_organi == 0) ? false : true;
			default:
				return 'Undefined';
		}
    }

    /**
    * Gestisce la relazione con il model delle tipologie di utente (paziente, care provider, etc...)
    */
    public function user_type()
	{
		return $this->belongsTo(\App\Models\UtentiTipologie::class, 'id_tipologia');
	}

	/**
    * Gestisce la relazione con il model dei log per la registrazione delle operazioni effettuate
    * sulla piattaforma.
    */
	public function auditlog_logs()
	{
		return $this->hasMany(\App\Models\Log\AuditlogLog::class, 'id_visitato');
	}

	/**
    * Gestisce la relazione con il model dei care provider nel caso in cui l'utente loggato
    * sia un care provider.
    */
	public function care_providers()
	{
		return $this->hasMany(\App\Models\CareProviders\CareProvider::class, 'id_utente');
	}

	/**
    * Gestisce la relazione con il model dei care provider nel caso in cui l'utente loggato
    * sia un care provider.
    */
	public function cpp_persona()
	{
		return $this->hasMany(\App\Models\CareProvider\CppPersona::class, 'id_utente');
	}

	/**
    * Gestisce la relazione con il model dei pazienti nel caso in cui l'utente loggato
    * sia un paziente.
    */
	public function patient()
	{
		return $this->hasMany(\App\Models\Patient\Pazienti::class, 'id_utente');
	}

	/**
    * Gestisce la relazione con il model PazientiFamiliarita per la gestione delle
    * relazioni familiari dei pazienti. 
    */
	public function pazienti_familiarita()
	{
		return $this->hasMany(\App\Models\Patient\PazientiFamiliarita::class, 'id_parente');
	}

	/**
    * Gestisce la relazione con il model Recapiti per il recupero dei contatti, come telefono
    * o indirizzo, forniti dall'utente loggato.
    */
	public function contacts()
	{
		return $this->hasMany(\App\Models\CurrentUser\Recapiti::class, 'id_utente');
	}
    
}
