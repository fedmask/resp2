<?php

namespace App\Models\Emergency;

use Illuminate\Database\Eloquent\Model as Eloquent;
use App\Models\CodificheFHIR\Language;
use App\Models\FHIR\CppQualification;


/**
 * Class Emergency
 *
 * @property int $id_emer
 * @property int $id_emer_tipologia
 * @property int $id_utente
 * @property string $emer_nome
 * @property string $emer_cognome
 * @property \Carbon\Carbon $emer_nascita_data
 * @property string $emer_codfiscale
 * @property string $emer_sesso
 * @property string $emer_n_iscrizione
 * @property string $emer_localita_iscrizione
 *
 * @property \App\Models\Utenti $tbl_utenti

 *
 * @package App\Models
 */

class Emergency extends Eloquent
{
    protected $table = 'tbl_emergency';
    protected $primaryKey = 'id_emer';
    public $incrementing = false;
    public $timestamps = false;

    protected $casts = [
        'id_emer' => 'int',
        'id_emer_tipologia' => 'int',
        'id_utente' => 'int',
        'active' => 'bool'
    ];

    protected $dates = [
        'emer_nascita_data'
    ];

    protected $fillable = [
        'id_emer_tipologia',
        'id_utente',
        'emer_nome',
        'emer_cognome',
        'emer_nascita_data',
        'emer_codfiscale',
        'emer_sesso',
        'emer_n_iscrizione',
        'emer_localita_iscrizione',
        'active',
        'emer_lingua'
    ];

    public function users()
    {
        return $this->belongsTo(\App\Models\CurrentUser\User::class, 'id_utente');
    }

    /**
     * FHIR
     */

    public function getIdCpp(){
        return $this->id_emer;
    }

    public function isActive(){
        $ret = "false";

        if(!$this->active){
            $ret = "true";
        }
        return $ret;
    }


    public function getName()
    {
        return $this->emer_nome;
    }

    public function getSurname()
    {
        return $this->emer_cognome;
    }

    public function getFullName()
    {
        return $this->getName() . " " . $this->getSurname();
    }

    public function getMail(){
        return $this->users ()->first ()->utente_email;
    }

    public function getPhone(){
        return $this->users ()->first ()->contacts ()->first ()->contatto_telefono;
    }

    public function getTelecom() {
        return $this->getPhone()." - ".$this->getMail();
    }

    public function getGender()
    {
        return $this->emer_sesso;
    }

    public function getBirth()
    {
        $data = date_format($this->emer_nascita_data,"Y-m-d");
        return $data;
    }

    public function getCodeLanguage()
    {
        return $this->emer_lingua;
    }

    public function getLanguage()
    {
        $language = Language::where('Code', $this->emer_lingua)->first()->Display;

        return $language;
    }

    public function getLine() {
        return $this->users ()->first ()->getAddress ();
    }

    public function getCity() {
        return $this->users ()->first ()->getLivingTown ();
    }

    public function getPostalCode() {
        return $this->users ()->first ()->getCapLivingTown ();
    }

    public function getCountryName() {
        return $this->users ()->first ()->contacts ()->first ()->town ()->first ()->tbl_nazioni ()->first ()->getCountryName ();
    }

    public function getAddress()
    {
        return $this->getLine()." ".$this->getCity()." ".$this->getCountryName()." ".$this->getPostalCode();
    }

    public function getQualifications()
    {
        $practictioner_qual = CppQualification::where('id_emer', $this->id_emer)->get();
        return $practictioner_qual;
    }

    public function getComune()
    {
        return $this->emer_localita_iscrizione;
    }

    public function getIdUtente()
    {
        return $this->id_utente;
    }

    /**
     * END FHIR
     */
}
