<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 25 Dec 2017 12:47:05 +0000.
 */
namespace App\Models\Vaccine;

use App\Models\Patient\Pazienti;
use App\Models\CareProviders\CareProvider;
use App\Models\CodificheFHIR\ImmunizationVaccineCode;
use App\Models\CodificheFHIR\ImmunizationRoute;
use App\Models\FHIR\ImmunizationProvider;
use Reliese\Database\Eloquent\Model as Eloquent;
use App\Traits\Encryptable;

/**
 * Class Vaccinazione
 *
 * @property int $id_vaccinazione
 * @property int $id_paziente
 * @property int $id_cpp
 * @property string $vaccineCode
 * @property int $vaccinazione_confidenzialita
 * @property \Carbon\Carbon $vaccinazione_data
 * @property string $vaccinazione_aggiornamento
 * @property string $vaccinazione_stato
 * @property bool $vaccinazione_notGiven
 * @property int $vaccinazione_quantity
 * @property string $vaccinazione_route
 * @property string $vaccinazione_note
 * @property string $vaccinazione_explanation
 *
 * @property \App\Models\TblCareProvider $tbl_care_provider
 * @property \App\Models\TblLivelliConfidenzialitum $tbl_livelli_confidenzialitum
 * @property \App\Models\TblPazienti $tbl_pazienti
 * @property \App\Models\ImmunizationVaccineCode $immunization_vaccine_code
 * @property \App\Models\ImmunizationStatus $immunization_status
 * @property \App\Models\ImmunizationRoute $immunization_route
 * @property \Illuminate\Database\Eloquent\Collection $tbl_vaccinazioni_reactions
 * @property \Illuminate\Database\Eloquent\Collection $tbl_vaccinis
 *
 * @package App\Models
 */
class Vaccinazione extends Eloquent {
	
	use Encryptable;
	protected $table = 'tbl_vaccinazione';
	protected $primaryKey = 'id_vaccinazione';
	public $timestamps = false;
	protected $casts = [ 
			'id_vaccinazione' => 'int',
			'id_paziente' => 'int',
			'vaccinazione_confidenzialita' => 'int',
			'vaccinazione_notGiven' => 'bool',
			'vaccinazione_primarySource' => 'bool',
			'vaccinazione_quantity' => 'int' 
	];
	protected $dates = [ 
			'vaccinazione_data' 
	];
	protected $fillable = [ 
			'id_vaccinazione',
			'id_paziente',
			'vaccineCode',
			'vaccinazione_confidenzialita',
			'vaccinazione_data',
			'vaccinazione_aggiornamento',
			'vaccinazione_stato',
			'vaccinazione_notGiven',
			'vaccinazione_quantity',
			'vaccinazione_route',
			'vaccinazione_note',
			'vaccinazione_primarySource' 
	];
	protected $encryptable = [ 
			'vaccinazione_note',
			'vaccinazione_explanation' 
	
	];
	public function tbl_care_provider() {
		return $this->belongsTo ( \App\Models\TblCareProvider::class, 'id_cpp' );
	}
	public function tbl_livelli_confidenzialitum() {
		return $this->belongsTo ( \App\Models\TblLivelliConfidenzialitum::class, 'vaccinazione_confidenzialita', 'id_livello_confidenzialita' );
	}
	public function tbl_pazienti() {
		return $this->belongsTo ( \App\Models\TblPazienti::class, 'id_paziente' );
	}
	public function immunization_vaccine_code() {
		return $this->belongsTo ( \App\Models\ImmunizationVaccineCode::class, 'vaccineCode' );
	}
	public function immunization_status() {
		return $this->belongsTo ( \App\Models\ImmunizationStatus::class, 'vaccinazione_stato' );
	}
	public function immunization_route() {
		return $this->belongsTo ( \App\Models\ImmunizationRoute::class, 'vaccinazione_route' );
	}
	public function tbl_vaccinazioni_reactions() {
		return $this->hasMany ( \App\Models\TblVaccinazioniReaction::class, 'id_vaccinazione' );
	}
	public function tbl_vaccinis() {
		return $this->hasMany ( \App\Models\TblVaccini::class, 'id_vaccinazione' );
	}
	public function getId() {
		return $this->id_vaccinazione;
	}
	public function getProviders() {
		$providers = ImmunizationProvider::where ( 'id_vaccinazione', $this->getId () )->get ();
		return $providers;
	}
	public function getCppRole() {
		$role = ImmunizationProvider::where ( 'id_cpp', $this->getIdCpp () )->first ();
		return $role->role;
	}
	public function getVaccineCode() {
		return $this->vaccineCode;
	}
	public function getVaccineCodeDisplay() {
		$code = ImmunizationVaccineCode::where ( 'Code', $this->getVaccineCode () )->first ();
		return $code->Text;
	}
	public function getData() {
		$data = date_format ( $this->vaccinazione_data, "Y-m-d" );
		return $data;
	}
	public function getStato() {
		return $this->vaccinazione_stato;
	}
	public function getIdPaziente() {
		return $this->id_paziente;
	}
	public function getPaziente() {
		$paz = Pazienti::where ( 'id_paziente', $this->getIdPaziente () )->first ();
		return $paz->getFullName ();
	}
	public function getRoute() {
		return $this->vaccinazione_route;
	}
	public function getRouteDisplay() {
		$display = ImmunizationRoute::where ( 'Code', $this->getRoute () )->first ();
		return $display->Text;
	}
	public function getQuantity() {
		return $this->vaccinazione_quantity;
	}
	public function getNote() {
		return $this->vaccinazione_note;
	}
	public function getNotGiven() {
		$ret = "false";
		if ($this->vaccinazione_notGiven) {
			$ret = "true";
		}
		return $ret;
	}
	public function getPrimarySource() {
		$ret = "false";
		if ($this->vaccinazione_primarySource) {
			$ret = "true";
		}
		return $ret;
	}
	public function getConfidenzialita() {
		return $this->vaccinazione_confidenzialita;
	}
}
