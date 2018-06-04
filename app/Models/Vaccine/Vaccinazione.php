<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 25 Dec 2017 12:47:05 +0000.
 */
namespace App\Models\Vaccine;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Vaccinazione
 *
 * @property int $id_vaccinazione
 * @property int $id_vaccino
 * @property int $id_paziente
 * @property int $id_cpp
 * @property int $vaccinazione_confidenzialita
 * @property \Carbon\Carbon $vaccinazione_data
 * @property string $vaccinazione_aggiornamento
 * @property string $vaccinazione_reazioni
 *
 * @property \App\Models\TblCareProvider $tbl_care_provider
 * @property \App\Models\LivelliConfidenzialita $tbl_livelli_confidenzialitum
 * @property \App\Models\Pazienti $tbl_pazienti
 * @property \App\Models\TblVaccini $tbl_vaccini
 *
 * @package App\Models
 */
class Vaccinazione extends Eloquent {
	protected $table = 'tbl_vaccinazione';
	protected $primaryKey = 'id_vaccinazione';
	public $incrementing = true;
	public $timestamps = false;
	protected $casts = [ 
			'id_vaccinazione' => 'int',
			'id_paziente' => 'int',
			'id_cpp' => 'int',
			'vaccinazione_confidenzialita' => 'int' 
	];
	protected $dates = [ 
			'vaccinazione_data' 
	];
	protected $fillable = [ 
			'vaccinazione_confidenzialita',
			'vaccinazione_aggiornamento',
			'vaccinazione_stato',
			'vaccinazione_quantity',
			'vaccinazione_note',
			'vaccinazione_explanation' 
	];
	public function getID() {
		return $this->id_vaccinazione;
	}
	public function getIDPaz() {
		return $this->id_paziente;
	}
	public function getIDCpp() {
		return $this->id_cpp;
	}
	public function getVaccConf() {
		return $this->vaccinazione_confidenzialita;
	}
	public function getData() {
		return $this->vaccinazione_data;
	}
	public function getAggiornamento() {
		return $this->vaccinazione_aggiornamento;
	}
	public function getReazioni() {
		return $this->vaccinazione_reazioni;
	}
	public function getStatus() {
		if ($this->vaccinazione_stato) {
			return 'Completed';
		}
		return 'entred_in_error';
	}
	public function getNotGiven() {
		return $this->notGiven;
	}
	public function getQuantity() {
		return $this->vaccinazione_quantity;
	}
	public function getNote() {
		return $this->vaccinazione_note;
	}
	public function getExplanation() {
		return $this->vaccinazione_explanation;
	}
	
	// ///
	public function setID($ID) {
		$this->id_vaccinazione = $ID;
	}
	public function setIDPaz($ID) {
		$this->id_paziente = $ID;
	}
	public function setIDCpp($ID) {
		$this->id_cpp = $ID;
	}
	public function setVaccConf($conf) {
		$this->vaccinazione_confidenzialita = $conf;
	}
	public function setData($Data) {
		$this->vaccinazione_data = $Data;
	}
	public function setAggiornamento($Aggiornamento) {
		$this->vaccinazione_aggiornamento = $Aggiornamento;
	}
	public function setReazioni($Reazioni) {
		$this->vaccinazione_reazioni = $Reazioni;
	}
	public function setStatus($Status) {
		$this->vaccinazione_stato = $Status;
	}
	public function setNotGiven($NG) {
		$this->notGiven = $NG;
	}
	public function setQuantity($Quantity) {
		$this->vaccinazione_quantity = $Quantity;
	}
	public function setNote($Note) {
		$this->vaccinazione_note = $Note;
	}
	public function setExplanation($Explanation) {
		$this->vaccinazione_explanation = $Explanation;
	}
	public function tbl_care_provider() {
		return $this->belongsTo ( \App\Models\CareProviders\CareProvider::class, 'id_cpp' );
	}
	public function tbl_livelli_confidenzialitum() {
		return $this->belongsTo ( \App\Models\LivelliConfidenzialita::class, 'vaccinazione_confidenzialita' );
	}
	public function tbl_pazienti() {
		return $this->belongsTo ( \App\Models\Patient\Pazienti::class, 'id_paziente' );
	}
	public function tbl_vaccini() {
		return $this->hasMany ( \App\Models\Vaccine\Vaccini::class, 'id_vaccinazione' );
	}
	public function tbl_vaccinazioneReaction() {
		return $this->hasMany ( \App\Models\VaccinazioniReaction::class, 'id_vaccinazione' );
	}
}
