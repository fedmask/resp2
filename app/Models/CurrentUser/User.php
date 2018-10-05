<?php
namespace App\Models\CurrentUser;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Carbon\Carbon;
use App\Models\Patient\Pazienti;
use App\Models\UtentiTipologie;
use App\Models\Domicile\Comuni;
use App\Models\Patient\StatiMatrimoniali;
use App\Models\Patient\PazientiVisite;
use App\Models\Patient\ParametriVitali;
use App\Models\Diagnosis\Diagnosi;
use App\Models\CareProviders\CppDiagnosi;
use App\Models\CareProviders\CppPaziente;
use App\Models\CareProviders\CareProvider;
use App\Models\Diagnosis\DiagnosiEliminate;
use App\Models\InvestigationCenter\Indagini;
use App\Models\InvestigationCenter\CentriIndagini;
use App\Models\InvestigationCenter\CentriContatti;
use DB;
use Auth;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'tbl_utenti';

    protected $primaryKey = 'id_utente';

    public $timestamps = false;

    const PATIENT_ID = "ass";

    const PATIENT_DESCRIPTION = "Assistito";

    const CAREPROVIDER_ID = "cpp";

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
     * Recupera i dati dell'utente loggato nel caso sia un paziente.
     */
    public function data_patient()
    {
        return $this->patient;
    }

    /*
     * Restituisce il ruolo dell'utente loggato.
     */
    public function getRole()
    {
        return $this->user_type->tipologia_nome;
    }

    /*
     * Restituisce la descrizione del ruolo dell'utente loggato.
     */
    public function getDescription()
    {
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
        if (! $isRememberTokenAttribute) {
            parent::setAttribute($key, $value);
        }
    }

    public function getEmailForPasswordReset()
    {
        return $this->utente_email;
    }

    /**
     * Ritorna il nome dell'utente loggato
     */
    public function getName()
    {
        switch ($this->getRole()) {
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
    public function getSurname()
    {
        switch ($this->getRole()) {
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
    public function getFiscalCode()
    {
        switch ($this->getRole()) {
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
    public function getBirthdayDate()
    {
        switch ($this->getRole()) {
            case $this::PATIENT_ID:
                return $this->data_patient()->first()->paziente_nascita;
            case $this::CAREPROVIDER_ID:
                return $this->care_providers()->first()->cpp_nascita_data;
            default:
                break;
        }
    }

    /**
     * Ritorna l'età dell'utente loggato calcolandola dall'anno attuale e dalla data di nascita
     */
    public function getAge($date)
    {
        $age = Carbon::parse($date);
        return $age->diffInYears(Carbon::now());
    }

    /**
     * Ritorna il numero di telefono dell'utente loggato
     */
    public function getTelephone()
    {
        switch ($this->getRole()) {
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
    public function getEmail()
    {
        return $this->utente_email;
    }

    /**
     * Ritorna il sesso dell'utente loggato
     */
    public function getGender()
    {
        switch ($this->getRole()) {
            case $this::PATIENT_ID:
                return $this->data_patient()->first()->paziente_sesso;
            case $this::CAREPROVIDER_ID:
                return $this->care_providers()->first()->cpp_sesso;
            default:
                break;
        }
    }

    /**
     * Ritorna la città di nascita dell'utente loggato
     */
    public function getBirthTown()
    {
        $result = $this->contacts()->first()->id_comune_nascita;
        return Comuni::find($result)->comune_nominativo;
    }

    /**
     * Ritorna la città dove risiede l'utente loggato
     */
    public function getLivingTown()
    {
        $result = $this->contacts()->first()->id_comune_residenza;
        return Comuni::find($result)->comune_nominativo;
    }

    public function getCapLivingTown()
    {
        $result = $this->contacts()->first()->id_comune_residenza;
        return Comuni::find($result)->comune_cap;
    }

    /**
     * Ritorna l'indirizzo dove risiede l'utente loggato
     */
    public function getAddress()
    {
        return $this->contacts()->first()->contatto_indirizzo;
    }

    /**
     * Ritorna lo stato matrimoniale dell'utente loggato
     */
    public function getMaritalStatus()
    {
        switch ($this->id_tipologia) {
            case $this::PATIENT_ID:
                return StatiMatrimoniali::where('id_stato_matrimoniale', $this->patient()->first()->id_stato_matrimoniale)->first()->stato_matrimoniale_nome;
            default:
                return 'Undefined';
        }
    }

    /**
     * Ritorna il gruppo sanguigno e il tipo di rh dell'utente loggato
     */
    public function getFullBloodType()
    {
        switch ($this->id_tipologia) {
            case $this::PATIENT_ID:
                return $this->getBloodGroup($this->data_patient()
                    ->first()->paziente_gruppo) . " " . $this->data_patient()->first()->pazinte_rh;
            default:
                return 'Undefined';
                break;
        }
    }

    /**
     * Associa il valore numerico registrato nel db per i gruppi sanguigni
     * al valore nominale.
     */
    private function getBloodGroup($group)
    {
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
    public function getOrgansDonor()
    {
        switch ($this->id_tipologia) {
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

    /**
     * Ritorna un array con tutte le visite effettuate dall'utente loggato
     */
    public function visiteUser()
    {
        $array = array();
        $lista = PazientiVisite::orderBy('visita_data', 'desc')->get();
        ;
        switch ($this->getRole()) {
            case $this::PATIENT_ID:
                foreach ($lista as $la) {
                    if ($la->id_paziente == $this->data_patient()->first()->id_paziente) {
                        array_push($array, $la);
                    }
                }
                return $array;
            
            case $this::CAREPROVIDER_ID:
                foreach ($lista as $la) {
                    if ($la->id_cpp == $this->care_providers()->first()->id_cpp) {
                        array_push($array, $la);
                    }
                }
                return $array;
            
            default:
                break;
        }
    }

    /**
     * Restituisce un array multidimensionale in cui le chiavi sono le date delle visite e i valori sono
     * i parametri vitali
     */
    public function paramVitaliToDate()
    {
        $visite = $this->visiteUser();
        $array = array();
        $param = ParametriVitali::all();
        $data;
        foreach ($visite as $v) {
            foreach ($param as $p) {
                if (($v->id_paziente == $p->id_paziente) && ($v->id_visita == $p->id_parametro_vitale)) {
                    $data = date('d/m/y', strtotime($v->visita_data));
                    $array["$data"] = $p;
                }
            }
        }
        return $array;
    }

    /**
     * Restituisce un array con le data delle visite
     */
    public function dateVisite()
    {
        $date = array_keys($this->paramVitaliToDate());
        return $date;
    }

    /**
     * restituisce un array con tutte le diagnosi del'utente loggato
     */
    public function diagnosi()
    {
        $arrayPazienti = array();
        $arrayPazienti = Pazienti::all();
        $idPaziente;
        $diagnosi = array();
        $diagnosi = Diagnosi::all();
        
        $ret = array();
        
        foreach ($arrayPazienti as $paz) {
            if ($paz->id_utente == $this->id_utente) {
                $idPaziente = $paz->id_paziente;
            }
        }
        
        foreach ($diagnosi as $d) {
            if ($idPaziente == $d->id_paziente) {
                array_push($ret, $d);
            }
        }
        
        return $ret;
    }

    /**
     * restituisce i cpp che ha contribuito alla diagnosi
     */
    public function getCppDiagnosi($idDiagnosi)
    {
        $arrayCppDiagnosi = array();
        $arrayCppDiagnosi = CppDiagnosi::all();
        $cpp;
        
        foreach ($arrayCppDiagnosi as $c) {
            if ($c->id_diagnosi == $idDiagnosi) {
                $cpp = $c;
            }
        }
        
        return $cpp;
    }

    /**
     * restituisce l'ultimo cpp che contribuito ad una data diagnosi
     */
    public function lastCppDiagnosi($idDiagnosi)
    {
        $cpp = ($this->getCppDiagnosi($idDiagnosi))->careprovider;
        $cpp = explode("-", $cpp);
        
        $ret;
        
        foreach ($cpp as $c) {
            $ret = $c;
        }
        
        $ret = explode("/", $ret);
        
        return $ret[0];
    }

    /**
     * restituisce l'id_paziente dell'utente loggato
     */
    public function idPazienteUser()
    {
        $arrayPazienti = array();
        $arrayPazienti = Pazienti::all();
        $idPaziente;
        $diagnosi = array();
        $diagnosi = Diagnosi::all();
        
        foreach ($arrayPazienti as $paz) {
            if ($paz->id_utente == $this->id_utente) {
                $idPaziente = $paz->id_paziente;
            }
        }
        
        return $idPaziente;
    }

    /**
     * restituisce un array con tutte le indagini del'utente loggato
     */
    public function indagini()
    {
        $arrayPazienti = array();
        $arrayPazienti = Pazienti::all();
        $idPaziente;
        $indagini = array();
        $indagini = Indagini::all();
        
        $ret = array();
        
        foreach ($arrayPazienti as $paz) {
            if ($paz->id_utente == $this->id_utente) {
                $idPaziente = $paz->id_paziente;
            }
        }
        
        foreach ($indagini as $i) {
            if ($idPaziente == $i->id_paziente) {
                array_push($ret, $i);
            }
        }
        
        return $ret;
    }

    /**
     * restituisce nome e cognome dei cpp che hanno contribuito ad una diagnosi in una indagine
     */
    public function cppIndagine($idDiagnosi)
    {
        $diagnosi = array();
        $diagnosi = CppDiagnosi::all();
        $cpp;
        
        foreach ($diagnosi as $d) {
            if ($idDiagnosi == $d->id_diagnosi) {
                $cpp = $d->careprovider;
            }
        }
        return $cpp;
    }

    /**
     * restituisce il nome del centro dove avrà luogo l'indagine
     */
    public function nomeCentroInd($idCentroInd)
    {
        $centri = array();
        $centri = CentriIndagini::all();
        $ret;
        
        foreach ($centri as $c) {
            if ($idCentroInd == $c->id_centro) {
                $ret = $c->centro_nome;
            }
        }
        
        return $ret;
    }

    /**
     * restituisce un array con tutti i centri indagini
     */
    public function centriIndagini()
    {
        $centri = array();
        $centri = CentriIndagini::all();
        
        return $centri;
    }

    /**
     * torna il contatto del centro
     */
    public function contattoCentro($idCentro)
    {
        $centriCont = array();
        $centriCont = CentriContatti::all();
        $ret = array();
        
        foreach ($centriCont as $c) {
            if ($c->id_centro == $idCentro) {
                array_push($ret, $c->contatto_valore);
            }
        }
        
        return $ret;
    }

    /**
     * restituisce nome e cognome dei cpp di un dato centro indagini
     */
    public function cppPersCont($idCentro)
    {
        $centri = array();
        $centri = CentriIndagini::all();
        $a;
        $cpp = array();
        $cpp = CareProvider::all();
        $ret;
        
        foreach ($centri as $c) {
            if ($c->id_centro == $idCentro) {
                $a = $c->id_ccp_persona;
            }
        }
        
        foreach ($cpp as $c) {
            if ($a == $c->id_cpp) {
                $ret = $c->cpp_nome . ' ' . $c->cpp_cognome;
            }
        }
        
        return $ret;
    }

    /**
     * restituisce nome e cognome di tutti i cpp che hanno contribuito ad una indagine del paziente loggato
     */
    public function cppToUserInd()
    {
        $cpp = CppPaziente::all();
        $cppUs = CareProvider::all();
        $id;
        $array = array();
        
        foreach($cpp as $c){
            if($c->id_paziente == $this->data_patient()->first()->id_paziente){
                $id = $c->id_cpp;
                foreach($cppUs as $cu){
                    if($cu->id_cpp == $id){
                        $a = $cu->cpp_nome." ".$cu->cpp_cognome."-".$cu->id_cpp;
                        array_push($array, $a);
                    }
                }
            }
        }
        
        return $array;
    }

    /**
     * restituisce nome, cognome e id del cpp che ha contribuito ad una data indagine
     */
    public function cppInd($idDiagnosi)
    {
        $indagini = Indagini::all();
        $ret = array();
        
        foreach ($indagini as $ind) {
            if ($ind->id_diagnosi == $idDiagnosi) {
                $ret = $ind->careprovider . "-" . $ind->id_cpp;
            }
        }
        
        return $ret;
    }
}
