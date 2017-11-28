<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

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
        return $this->hasOne("App\Pazienti", "id_paziente");
    }
    
    public function getRole(){
        return $this->hasOne("App\Tipologie", "utente_tipologia");
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
    
}
