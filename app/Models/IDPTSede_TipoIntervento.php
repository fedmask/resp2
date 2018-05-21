<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class IDPTSede_TipoIntervento extends Eloquent
{
    //
    
	protected $table = 'tbl_ICD9_IDPT_Sede_Tipo_Intervento';
	protected $primaryKey = 'id_IDPT_Sede_TipoIntervento';
	public $incrementing = false;
	public $timestamps = false;
	
	
	//$casts permette di convertire gli attributi di un db in tipo di dato comune
	protected $casts = [
			'id_IDPT_Sede_TipoIntervento' => 'String',
			'descrizione_sede' => 'String',
			'descrizione_tipo_intervento' => 'String',
	];
	
	
	
	
	protected $fillable = [
			'descrizione_sede',
			'descrizione_tipo_intervento'
	];
	
	
	/* Metodi per risorse Fhir */
	//@todo da verificare se esistono i metodi get nei rispettivi modelli delle entità considerate, implementa!!
	public function getID(){
		return $this->IDPT_Sede_TipoIntervento;
	}
	
	public function getDescSede(){
		return $this->descrizione_sede;
	}
	
	public function getDescTipoIntervento(){
		return $this->descrizione_tipo_intervento;
	}
	
	public function setID($ID){
		$this->id_IDPT_Organo= $ID;
	}
	public function setDescSede($desc){
		$this->descrizione_sede = $desc;
	}
	
	public function setDescTipoIntervento($desc){
		$this->descrizione_TipoIntervento = $desc;
	}
	
	
	// @TODO Continuare con la scrittura del metodo
	public function ICD9_ICPT()
	{
		return $this->hasMany(\App\Models\ICD9_ICPT::class, 'id_IDPT_Sede_TipoIntervento');
	}
	
	
	
}
