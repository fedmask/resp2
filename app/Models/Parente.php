<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Parente extends Model {
	//
	protected $table = 'tbl_Parente';
	protected $primaryKey = 'id_parente';
	public $incrementing = true;
	public $timestamps = false;
	protected $casts = [ 
			'id_parente' => 'int',
			'età' => 'int',
			'età_decesso' => 'int' 
	
	];
	protected $dates = [ 
			'data_nascita',
			'data_decesso' 
	
	];
	protected $fillable = [ 
			'descrizione',
			'nome',
			'cognome',
			'sesso' 
	
	];
	
	// Get methods for Controllers
	public function getID() {
		return $this->id_Parente;
	}
	public function getCF() {
		return $this->codice_fiscale;
	}
	public function getNome() {
		return $this->nome;
	}
	public function getCognome() {
		return $this->cognome;
	}
	public function getSesso() {
		return $this->sesso;
	}
	public function getDataN() {
		return $this->data_nascita;
	}
	public function getEta() {
		return $this->età;
	}
	public function getDecesso() {
		return $this->decesso;
	}
	public function getEDecesso() {
		return $this->età_decesso;
	}
	public function getDataDecesso() {
		return $this->data_decesso;
	}
	
	// Set Methods
	
	public function setCF($CF) {
		$this->codice_fiscale = $CF;
	}
	public function setNome($Nome) {
		$this->nome = $Nome;
	}
	public function setCognome($Cognome) {
		$this->cognome = $Cognome;
	}
	public function setSesso($Sesso) {
		$this->sesso = $Sesso;
	}
	public function setDataN($DataN) {
		$this->data_nascita = $DataN;
	}
	public function setEta($Eta) {
		$this->età = $Eta;
	}
	public function setDecesso($Decesso) {
		$this->decesso = $Decesso;
	}
	public function setEDecesso($ED) {
		$this->età_decesso = $ED;
	}
	public function setDataDecesso($DD) {
		$this->data_decesso = $DD;
	}
	
	public function tbl_Parente()
	{
		return $this->hasMany(\App\Models\AnamnesiF::class, 'id_parente');
	}
	
	public function	FamilyCondition()
	{
		return $this->hasOne(\App\Models\History\FamilyCondiction::class, 'id_parente');
	}
}
