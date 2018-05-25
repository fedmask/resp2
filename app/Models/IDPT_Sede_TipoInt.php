<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class IDPTSede_TipoInt extends Eloquent
{
	//
	
	protected $table = 'tbl_ICD9_IDPT_ST';
	protected $primaryKey = 'id_IDPT_ST';
	public $incrementing = false;
	public $timestamps = false;
	
	
	//$casts permette di convertire gli attributi di un db in tipo di dato comune
	protected $casts = [
			'id_IDPT_ST' => 'String',
			'descrizione_sede' => 'String',
			'descrizione_tipo_intervento' => 'String',
	];
	
	
	
	
	protected $fillable = [
			'descrizione_sede',
			'descrizione_tipo_intervento'
	];
	
	
	public function getID(){
		return $this->id_IDPT_ST;
	}
	
	public function getDescSede(){
		return $this->descrizione_sede;
	}
	
	public function getDescTipoIntervento(){
		return $this->descrizione_tipo_intervento;
	}
	
	public function setID($ID){
		$this->id_IDPT_ST= $ID;
	}
	public function setDescSede($desc){
		$this->descrizione_sede = $desc;
	}
	
	public function setDescTipoIntervento($desc){
		$this->descrizione_TipoIntervento = $desc;
	}
	
	
	
	public function tbl_ICD9_ICPT()
	{
		return $this->hasMany(\App\Models\ICD9_ICPT::class, 'id_IDPT_ST');
	}
	
}
