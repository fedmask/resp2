<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;


//Questa classe è il modello della tabella Tbl_ICD9_IntrventiChirurgici_ProcTerapeutiche
class ICD9_ICPT extends Eloquent
{
	
	protected $table = 'Tbl_ICD9_IntrventiChirurgici_ProcTerapeutiche';
	protected $primaryKey = 'Codice_ICD9';
	public $incrementing = false;
	public $timestamps = false;
	
	
	//$casts permette di convertire gli attributi di un db in tipo di dato comune
	protected $casts = [
			'Codice_ICD9' => 'String',
			'IDPT_Organo' => 'String',
			'IDPT_Sede_TipoIntervento' => 'String',
			'Descizione_ICD9' => 'String',
			
	];
	
	
	
	
	protected $fillable = [
			'IDPT_Organo',
			'IDPT_Sede_TipoIntervento',
			'Descizione_ICD9'
	];
	
	
	/* Metodi per risorse Fhir */
	//@todo da verificare se esistono i metodi get nei rispettivi modelli delle entità considerate, implementa!!
	public function getID(){
		return $this->Codice_ICD9;
	}
	
	public function getIDPT_Organo(){
		return $this->IDPT_Organo()->first()->getID(); 
	}
	
	public function getIDPT_Sede_TipoIntervento(){
		return $this->IDPT_STI()->first()-getID(); 
	}
	
	public function getDescizione_ICD9(){
		return $this->Descizione_ICD9; 
	}
	
	
	/***
	 * Those are sets method
	 */
	
	public function setID($ID){
		$this->id_IDPT_Organo= $ID;
	}
	public function setIDPT_Organo($desc){
		$this->descrizione_sede = $desc;
	}
	
	public function setIDPT_Sede_TipoIntervento($desc){
		$this->descrizione_TipoIntervento = $desc;
	}
	
	
	public function setDescizione_ICD9($desc){
		$this->descrizione_TipoIntervento = $desc;
	}
	
	
	
	
	// @TODO Continuare con la scrittura del metodo
	public function IDPT_Organo()
	{
		
		return $this->belongsTo(\App\Models\IDPTOrgani::class, 'id_IDPT_Organo');
	}
	
	public function IDPT_STI()
	{
		
		return $this->belongsTo(\App\Models\IDPTSede_TipoIntervento::class, 'id_IDPT_Sede_TipoIntervento');
	}
	
	
}
