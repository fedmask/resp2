<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FamilyCondiction extends Model {
	protected $table = 'tbl_FamilyCondiction';
	protected $primaryKey = 'id_Condition';
	public $timestamps = false;
	protected $casts = [ 
			'id_Condition' => 'int',
			'Codice_ICD9' => 'String',
			'outCome' => 'String',
			'id_parente' => 'int',
			'onSetAge' => 'boolean',
			'onSetAgeRange_low' => 'int',
			'onSetAgeRange_hight' => 'int',
			'onSetAgeValue' => 'int', 
			'Note'=>'string'
	];
	protected $fillable = [ 
			'Codice_ICD9',
			'outCome',
			'id_parente',
			'onSetAge',
			'onSetAgeRange_low',
			'onSetAgeRange_hight',
			'onSetAgeValue',
			'Note' 
	
	];
	public function getID() {
		return $this->id;
	}
	public function getICD9() {
		return $this->Codice_ICD9;
	}
	public function getoutCome() {
		return $this->outCome;
	}
	public function getIDParente() {
		return $this->id_parente;
	}
	public function getOSAge() {
		return $this->onSetAge;
	}
	public function getAgeRangeLow() {
		return $this->onSetAgeRange_low;
	}
	public function getAgeRangeHight() {
		return $this->onSetAgeRange_hight;
	}
	public function getAgeValue() {
		return $this->onSetAgeValue;
	}
	public function getNote() {
		return $this->Note;
	}
	public function setNote($N) {
		return $this->Note = $N;
	}
	public function setID($id) {
		$this->id = $id;
	}
	public function setICD9($icd9) {
		$this->Codice_ICD9 = $icd9;
	}
	public function setoutCome($out) {
		$this->outCome = $out;
	}
	public function setIDParente($id) {
		$this->id_parente = $id;
	}
	public function setOSAge($age) {
		$this->onSetAge = $age;
	}
	public function setAgeRangeLow($rl) {
		$this->onSetAgeRange_low = $rl;
	}
	public function setAgeRangeHight($rh) {
		$this->onSetAgeRange_hight = $rh;
	}
	public function setAgeValue($value) {
		$this->onSetAgeValue = $value;
	}
	
	
	public function Parente() {
		return $this->belongsTo ( \App\Models\History\Parente::class, 'id_parente' );
	}
	public function ICD9() {
		return $this->belongsTo ( \App\Models\History\ICD9_ICPT::class, 'Codice_ICD9' );
	}
	
	// Da utilizzare con cautela
	public function ICD9_Desc() {
		return $this->ICD9 ()->first->getDescizione_ICD9 ();
	}
}
