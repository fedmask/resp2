<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 25 Dec 2017 12:47:05 +0000.
 */
namespace App\Models\Patient;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Pazienti
 *
 * @property int $id_paziente
 * @property int $id_utente
 * @property int $id_stato_matrimoniale
 * @property string $paziente_nome
 * @property string $paziente_cognome
 * @property \Carbon\Carbon $paziente_nascita
 * @property string $paziente_codfiscale
 * @property string $paziente_sesso
 * @property bool $paziente_gruppo
 * @property string $pazinte_rh
 * @property bool $paziente_donatore_organi
 *
 * @property \App\Models\Utenti $tbl_utenti
 * @property \Illuminate\Database\Eloquent\Collection $tbl_contatti_pazientis
 * @property \Illuminate\Database\Eloquent\Collection $tbl_cpp_pazientes
 * @property \Illuminate\Database\Eloquent\Collection $tbl_diagnosis
 * @property \Illuminate\Database\Eloquent\Collection $tbl_diagnosi_eliminates
 * @property \Illuminate\Database\Eloquent\Collection $tbl_effetti_collateralis
 * @property \Illuminate\Database\Eloquent\Collection $tbl_esami_obiettivis
 * @property \Illuminate\Database\Eloquent\Collection $tbl_farmaci_vietatis
 * @property \Illuminate\Database\Eloquent\Collection $tbl_files
 * @property \Illuminate\Database\Eloquent\Collection $tbl_indaginis
 * @property \Illuminate\Database\Eloquent\Collection $tbl_parametri_vitalis
 * @property \App\Models\PazientiDecessi $tbl_pazienti_decessi
 * @property \Illuminate\Database\Eloquent\Collection $tbl_pazienti_familiarita
 * @property \Illuminate\Database\Eloquent\Collection $tbl_pazienti_visites
 * @property \Illuminate\Database\Eloquent\Collection $tbl_taccuinos
 * @property \Illuminate\Database\Eloquent\Collection $tbl_vaccinaziones
 *
 * @package App\Models
 */
class Pazienti extends Eloquent {
	protected $table = 'tbl_pazienti';
	protected $primaryKey = 'id_paziente';
	public $timestamps = false;
	protected $casts = [ 
			'id_utente' => 'int',
			'id_stato_matrimoniale' => 'int',
			'paziente_gruppo' => 'bool',
			'paziente_donatore_organi' => 'bool' 
	];
	protected $dates = [ 
			'paziente_nascita' 
	];
	protected $fillable = [ 
			'id_utente',
			'id_stato_matrimoniale',
			'paziente_nome',
			'paziente_cognome',
			'paziente_nascita',
			'paziente_codfiscale',
			'paziente_sesso',
			'paziente_gruppo',
			'pazinte_rh',
			'paziente_donatore_organi' 
	];
	
	/**
	 * Costanti per i gruppi sanguigni e fattori RH
	 */
	const BLOODGROUP_0 = 0;
	const BLOODGROUP_A = 1;
	const BLOODGROUP_B = 2;
	const BLOODGROUP_AB = 3;
	const BLOODRH_POS = "POS";
	const BLOODRH_NEG = "NEG";
	
	/**
	 * FHIR FUNCTIONS *
	 */
	public function getPhone() {
		return $this->user ()->first ()->contacts ()->first ()->contatto_telefono;
	}
	public function getPhoneType() {
		return $this->user ()->first ()->contacts ()->first ()->get_phone_type ();
	}
	public function isDeceased() {
		$deceased = "false";
		
		if ($this->tbl_pazienti_decessi ()->first ()) {
			$deceased = $paziente->tbl_pazienti_decessi ()->first ()->paziente_data_decesso;
		}
		
		return $deceased;
	}
	public function getLine() {
		return $this->user ()->first ()->getAddress ();
	}
	public function getCity() {
		return $this->user ()->first ()->getLivingTown ();
	}
	public function getPostalCode() {
		return $this->user ()->first ()->getCapLivingTown ();
	}
	public function getCountryName() {
		return $this->user ()->first ()->contacts ()->first ()->town ()->first ()->tbl_nazioni ()->first ()->getCountryName ();
	}
	public function getStatusWedding() {
		return $this->statusWedding ()->first ()->stato_matrimoniale_nome;
	}
	public function getStatusWeddingCode() {
		return $this->id_stato_matrimoniale;
	}
	public function getName() {
		return $this->paziente_nome;
	}
	public function getSurname() {
		return $this->paziente_cognome;
	}
	public function getFullName() {
		return $this->getName () . " " . $this->getSurname ();
	}
	public function getID_Paziente() {
		return $this->id_paziente;
	}
	public function getID() {
		return $this->id_utente;
	}
	public function getSex() {
		return $this->paziente_sesso;
	}
	public function getBirth() {
		return $this->paziente_nascita;
	}
	public function getFiscalCode() {
		return $this->paziente_codfiscale;
	}
	public function setBirth($date) {
		$this->paziente_nascita = $date;
	}
	public function setFiscalCode($fiscalCode) {
		$this->paziente_codfiscale = $fiscalCode;
	}
	public function setSex($sex) {
		$this->paziente_sesso = $sex;
	}
	public function setID($id) {
		$this->id_utente = $id;
	}
	public function setSurname($surname) {
		$this->paziente_cognome = $surname;
	}
	public function setName($name) {
		$this->paziente_nome = $name;
	}
	
	/**
	 * END FHIR *
	 */
	public function user() {
		return $this->belongsTo ( \App\Models\CurrentUser\User::class, 'id_utente' );
	}
	public function statusWedding() {
		return $this->belongsTo ( \App\Models\Patient\StatiMatrimoniali::class, 'id_stato_matrimoniale' );
	}
	public function patient_contacts() {
		return $this->hasMany ( \App\Models\Patient\PazientiContatti::class, 'id_paziente' );
	}
	public function cpp_patients() {
		return $this->hasMany ( \App\Models\CareProvider\CppPaziente::class, 'id_paziente' );
	}
	public function diagnosis() {
		return $this->hasMany ( \App\Models\Diagnosis\Diagnosi::class, 'id_paziente' );
	}
	public function erased_diagnosis() {
		return $this->hasMany ( \App\Models\Diagnosis\DiagnosiEliminate::class, 'id_utente' );
	}
	public function collateral_effects() {
		return $this->hasMany ( \App\Models\EffettiCollaterali::class, 'id_paziente' );
	}
	public function tbl_esami_obiettivis() {
		return $this->hasMany ( \App\Models\EsamiObiettivi::class, 'id_paziente' );
	}
	public function tbl_farmaci_vietatis() {
		return $this->hasMany ( \App\Models\Drugs\FarmaciVietati::class, 'id_paziente' );
	}
	public function tbl_files() {
		return $this->hasMany ( \App\Models\File::class, 'id_paziente' );
	}
	public function tbl_indaginis() {
		return $this->hasMany ( \App\Models\InvestigationCenter\Indagini::class, 'id_paziente' );
	}
	public function tbl_parametri_vitalis() {
		return $this->hasMany ( \App\Models\Patient\ParametriVitali::class, 'id_paziente' );
	}
	public function tbl_pazienti_decessi() {
		return $this->hasOne ( \App\Models\Patient\PazientiDecessi::class, 'id_paziente' );
	}
	public function tbl_pazienti_familiarita() {
		return $this->hasMany ( \App\Models\Patient\PazientiFamiliarita::class, 'id_paziente' );
	}
	public function tbl_pazienti_visites() {
		return $this->hasMany ( \App\Models\Patient\PazientiVisite::class, 'id_paziente' );
	}
	public function tbl_taccuinos() {
		return $this->hasMany ( \App\Models\Patient\Taccuino::class, 'id_paziente' );
	}
	public function tbl_vaccinaziones() {
		return $this->hasMany ( \App\Models\Vaccine\Vaccinazione::class, 'id_paziente' );
	}
}
