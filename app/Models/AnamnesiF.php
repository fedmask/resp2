<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Encryptable;

class AnamnesiF extends Model {
	//
	
	use Encryptable;
	protected $table = 'tbl_AnamnesiF';
	protected $primaryKey = 'id_anamnesiF';
	public $incrementing = true;
	public $timestamps = false;
	protected $casts = [ 
			'id_paziente' => 'int',
			'id_parente' => 'int',
			'descrizione' => 'string',
			'note' => 'string' 
	];
	protected $dates = [ 
			'data' 
	
	];
	protected $encryptable = [ 
			'descrizione',
			
	];
	
	protected $fillable = [ 
			'codice',
			'codice_descrizione',
			'descrizione',
			'status',
			'notDoneReason',
			'id_parentela' 
	
	];
	
	// Get Methods
	public function getID() {
		return $this->id_anamnesiF;
	}
	public function getCodice() {
		return $this->codice;
	}
	public function getCDescrizione() {
		return $this->codice_descrizione;
	}
	public function getDesc() {
		return $this->descrizione;
	}
	public function getIDPaziente() {
		return $this->id_paziente;
	}
	public function getIDParente() {
		return $this->id_parente;
	}
	public function getStatus() {
		return $this->status;
	}
	public function getNDR() {
		return $this->notDoneReason;
	}
	public function getNote() {
		return $this->note;
	}
	public function getData() {
		return $this->data;
	}
	public function getIDParentela() {
		return $this->id_parentela;
	}
	
	// Set Methods
	public function setCodice($IDP) {
		$this->id_parentela = $IDP;
	}
	public function setCodice_($Codice) {
		$this->codice = $Codice;
	}
	public function setCDescrizione($CD) {
		$this->codice_descrizione = $CD;
	}
	public function setDesc($Descrizione) {
		$this->descrizione = $Descrizione;
	}
	public function setIDPaziente($IDPaz) {
		$this->id_paziente = $IDPaz;
	}
	public function setIDParente($IDPar) {
		$this->id_parente = $IDPar;
	}
	public function setStatus($Status) {
		$this->status = $Status;
	}
	public function setNDR($NDR) {
		$this->notDoneReason = $NDR;
	}
	public function setNote($Note) {
		$this->note = $Note;
	}
	public function setData($Data) {
		$this->data = $Data;
	}
	public function tbl_Parente() {
		return $this->belongTo ( \App\Models\Parente::class, 'id_parente' );
	}
	public function tbl_AnamnesiF() {
		return $this->belongTo ( \App\Models\AnamnesiFamiliare::class, 'id_paziente' );
	}
}
