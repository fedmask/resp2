<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VaccinazioniReaction extends Model {
	//
	protected $table = 'tbl_vaccinazioni_reaction';
	protected $primaryKey = 'id_vacc_reaction';
	public $incrementing = true;
	public $timestamps = false;
	protected $casts = [ 
			'id_vacc_reaction' => 'int',
			'id_centro' => 'int',
			'id_vaccinazione' => 'int' 
	];
	protected $dates = [ 
			'date' 
	];
	protected $fillable = [ 
			'reported' 
	];
	public function getID() {
		return $this->id_vacc_reaction;
	}
	public function getIDCentro() {
		return $this->id_centro;
	}
	public function getDate() {
		return $this->date;
	}
	public function getReported() {
		return $this->reported;
	}
	public function getIDVaccinazione() {
		return $this->id_vaccinazione;
	}
	public function setIDCentro($ID) {
		$this->id_centro = $ID;
	}
	public function setDate($Date) {
		$this->date = $Date;
	}
	public function setReport($Report) {
		$this->reported = $Report;
	}
	public function setIDVaccinazione($ID) {
		$this->id_vaccinazione = $ID;
	}
	public function tbl_CentroIndagini() {
		return $this->belongsTo ( \App\Models\CareProviders\CentriIndagini::class, 'id_centro' );
	}
	public function tbl_Vaccinazione() {
		return $this->belongsTo ( \App\Models\Vaccine\Vaccinazione::class, 'id_vaccinazione' );
	}
}
