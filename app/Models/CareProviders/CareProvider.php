<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 25 Dec 2017 12:47:05 +0000.
 */
namespace App\Models\CareProviders;

use Reliese\Database\Eloquent\Model as Eloquent;
use App\Models\CodificheFHIR\Language;
use App\Models\FHIR\CppQualification;
use DB;
use App\Traits\Encryptable;

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
	
	use Encryptable;
	protected $table = 'tbl_care_provider';
	protected $primaryKey = 'id_cpp';
	public $incrementing = false;
	public $timestamps = false;
	protected $casts = [ 
			'id_cpp' => 'int',
			'id_cpp_tipologia' => 'int',
			'id_utente' => 'int',
			'active' => 'bool' 
	];
	protected $encryptable = [ 
			'cpp_nome',
			'cpp_cognome',
			'cpp_n_iscrizione' 
	
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
			'cpp_localita_iscrizione',
			'active',
			'cpp_lingua',
			'specializzation' 
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
	
	/**
	 * FHIR
	 */
	public function getIdCpp() {
		return $this->id_cpp;
	}
	public function isActive() {
		$ret = "false";
		
		if (! $this->active) {
			$ret = "true";
		}
		return $ret;
	}
	public function getName() {
		return $this->cpp_nome;
	}
	public function getSurname() {
		return $this->cpp_cognome;
	}
	public function getFullName() {
		return $this->getName () . " " . $this->getSurname ();
	}
	public function getMail() {
		return $this->users ()->first ()->utente_email;
	}
	public function getPhone() {
		return $this->users ()->first ()->contacts ()->first ()->contatto_telefono;
	}
	public function getTelecom() {
		return $this->getPhone () . " - " . $this->getMail ();
	}
	public function getGender() {
		return $this->cpp_sesso;
	}
	public function getBirth() {
		$data = date_format ( $this->cpp_nascita_data, "Y-m-d" );
		return $data;
	}
	public function getCodeLanguage() {
		return $this->cpp_lingua;
	}
	public function getLanguage() {
		$language = Language::where ( 'Code', $this->cpp_lingua )->first ()->Display;
		
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
	public function getAddress() {
		return $this->getLine () . " " . $this->getCity () . " " . $this->getCountryName () . " " . $this->getPostalCode ();
	}
	public function getQualifications() {
		// $practictioner_qual = CppQualification::where('id_cpp', $this->id_cpp)->get();
		
		// In mancanza di un Model recupero le istanze della tabella intermedia CppQualifiations
		$QualificationsPivot = DB::table ( 'CppQualification' )->where ( 'id_cpp', $this->getIdCpp () )->get ();
		
		// Creo un array
		$temp = array ();
		$i = 0;
		
		// Ciclo sulle istanze di Qualifications e recupero il codice e la descrizione inserendoli in un array da passare al controller
		foreach ( $QualificationsPivot as $Qualification ) {
			$practictioner_qual = DB::table ( 'QualificationCode' )->where ( 'Code', $Qualification->Code )->first ();
			
			$temp [$i ++] = array (
					"Code" => $practictioner_qual->Code,
					"Descrption" => $practictioner_qual->Display 
			);
		}
		
		return $temp;
	}
	
	public function getFHIRQualifications()
	{
	    $practictioner_qual = CppQualification::where('id_cpp', $this->id_cpp)->get();
	    return $practictioner_qual;
	}
	
	public function getComune() {
		return $this->cpp_localita_iscrizione;
	}
	public function getIdUtente() {
		return $this->id_utente;
	}

/**
 * END FHIR
 */
}
