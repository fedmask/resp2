<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 25 Dec 2017 12:47:05 +0000.
 */
namespace App\Models\CareProviders;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class CareProvider
 *
 * @property int $id_cpp
 * @property int $id_cpp_tipologia
 * @property int $id_utente
 * @property string $cpp_nome
 * @property string $cpp_cognome
 * @property \Carbon\Carbon $cpp_nascita_data
 * @property string $cpp_codfiscale
 * @property string $cpp_sesso
 * @property string $cpp_n_iscrizione
 * @property string $cpp_localita_iscrizione
 *
 * @property \App\Models\Utenti $tbl_utenti
 * @property \App\Models\CppTipologie $tbl_cpp_tipologie
 * @property \Illuminate\Database\Eloquent\Collection $tbl_cpp_diagnosis
 * @property \Illuminate\Database\Eloquent\Collection $tbl_cpp_pazientes
 * @property \Illuminate\Database\Eloquent\Collection $tbl_pazienti_visites
 * @property \Illuminate\Database\Eloquent\Collection $tbl_vaccinaziones
 *
 * @package App\Models
 */
class CareProvider extends Eloquent {
	protected $table = 'tbl_care_provider';
	protected $primaryKey = 'id_cpp';
	public $incrementing = false;
	public $timestamps = false;
	protected $casts = [ 
			'id_cpp' => 'int',
			'id_cpp_tipologia' => 'int',
			'id_utente' => 'int' 
	];
	protected $dates = [ 
			'cpp_nascita_data' 
	];
	protected $fillable = [ 
			'id_cpp_tipologia',
			'id_utente',
			'cpp_nome',
			'cpp_cognome',
			'cpp_nascita_data',
			'cpp_codfiscale',
			'cpp_sesso',
			'cpp_n_iscrizione',
			'cpp_localita_iscrizione' 
	];
	public function users() {
		return $this->belongsTo ( \App\Models\CurrentUser\User::class, 'id_utente' );
	}
	public function careprovider_types() {
		return $this->belongsTo ( \App\Models\CareProvider\CppTipologie::class, 'id_cpp_tipologia' );
	}
	public function carprovider_diagnosis() {
		return $this->hasMany ( \App\Models\CareProvider\CppDiagnosi::class, 'id_cpp' );
	}
	public function careprovider_patients() {
		return $this->hasMany ( \App\Models\CareProvider\CppPaziente::class, 'id_cpp' );
	}
	public function patient_visits() {
		return $this->hasMany ( \App\Models\Patient\PazientiVisite::class, 'id_cpp' );
	}
	public function vaccines() {
		return $this->hasMany ( \App\Models\Vaccine\Vaccinazione::class, 'id_cpp' );
	}
	public function contacts() {
		return $this->hasMany ( \App\Models\CurrentUser\Recapiti::class, 'id_utente' );
	}
	public function getID() {
		return $this->id_cpp;
	}
	public function getId_cpp_tipologia() {
		return $this->id_cpp_tipologia;
	}
	public function getCpp_nome() {
		return $this->cpp_nome;
	}
	public function getCpp_cognome() {
		return $this->cpp_cognome;
	}
	public function getCpp_nascita_data() {
		return $this->cpp_nascita_data;
	}
	public function getCpp_codfiscale() {
		return $this->cpp_codfiscale;
	}
	public function getCpp_sesso() {
		return $this->cpp_sesso;
	}
	public function getCpp_n_iscrizione() {
		return $this->cpp_n_iscrizione;
	}
	public function getCpp_localita_iscrizione() {
		return $this->cpp_localita_iscrizione;
	}
	public function getUser() {
		return $this->id_utente;
	}
	public function setID($ID) {
		$this->id_cpp = $ID;
	}
	public function setCpp_nome($Nome) {
		$this->cpp_nome = $Nome;
	}
	public function setCpp_cognome($Cognome) {
		$this->cpp_cognome = $Cognome;
	}
	public function setCpp_nascita_data($DataN) {
		$this->cpp_nascita_data = $DataN;
	}
	public function setCpp_codfiscale($CF) {
		if (CareProvider::checkCF ( $CF )) {
			$this->cpp_codfiscale = $CF;
		}
	}
	public function setCpp_sesso($Sesso) {
		$this->cpp_sesso = $Sesso;
	}
	public function setCpp_n_iscrizione($N_Iscrizione) {
		$this->cpp_n_iscrizione = $N_Iscrizione;
	}
	public function setCpp_localita_iscrizione($Località) {
		$this->cpp_localita_iscrizione = $Località;
	}
	
<<<<<<< HEAD
	// @TODO Effettuare antri controlli
	public static function checkCF($CF) {
		if ($length ( CF ) == 16) {
			return true;
		}
	}
=======
	public function tbl_proc_ter()
	{
	    return $this->hasMany(\App\Models\ProcedureTerapeutiche::class, 'id_Procedure_Terapeutiche');
	}
	

>>>>>>> 86804395382bb422ac0bf3d6c318cb56d9dd9580
}

