<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VisitaSpecialization extends Model {
	protected $table = 'tbl_visita_specialization';
	protected $primaryKey = 'id_vs';
	public $incrementing = false;
	public $timestamps = false;
	protected $casts = [ 
			'id_visita' => 'int',
			'id_specialization' => 'int' 
	];
	protected $fillable = [ 
			'id_visita',
			'id_specialization' 
	];
	public function getId() {
		return $this->id_vs;
	}
	public function getIdVisita() {
		return $this->id_visita;
	}
	public function getIdSpec() {
		return $this->id_specialization;
	}
	public function getSpecializzation() {
		return $this->Specialization ()->first ()->getDesc ();
	}
	public function getVisita() {
		return $this->Visita ()->first ()->getID ();
	}
	public function setId($id) {
		$this->id_vs = $id;
	}
	public function setIdVisita($visita) {
		$this->id_visita = $visita;
	}
	public function setIdSpec($spec) {
		$this->id_specialization = $spec;
	}
	public function Specialization() {
		return $this->belongsTo ( \App\Models\CppSpecialization::class, 'id_spec' );
	}
	public function Visita() {
		return $this->belongsTo ( \App\Models\Patient\PazientiVisite::class, 'id_visita' );
	}
}
