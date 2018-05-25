<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class IDPTOrgani extends Eloquent
{
	//
	
	protected $table = 'tbl_ICD9_IDPT_Organi';
	protected $primaryKey = 'id_IDPT_Organo';
	public $incrementing = false;
	public $timestamps = false;
	
	
	//$casts permette di convertire gli attributi di un db in tipo di dato comune
	protected $casts = [
			'id_IDPT_Organo' => 'String',
			'descrizione' => 'String',
			
	];
	
	
	
	
	protected $fillable = [
			'descrizione'
	];
	
	
	public function getID(){
		return $this->id_IDPT_Organo;
	}
	
	public function getDesc(){
		return $this->descrizione;
	}
	
	public function setID($ID){
		$this->id_IDPT_Organo= $ID;
	}
	public function setDesc($desc){
		$this->descrizione = $desc;
	}
	
	
	
	public function tbl_ICD9_ICPT()
	{
		return $this->hasMany(\App\Models\ICD9_ICPT::class, 'id_IDPT_Organo');
	}
	
}
