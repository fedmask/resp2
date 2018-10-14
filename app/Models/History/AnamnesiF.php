<?php

namespace App\Models\History;

use Illuminate\Database\Eloquent\Model;
use App\Models\Parente;
use App\Models\Patient\PazientiFamiliarita;
use App\Models\Patient\Pazienti;
use App\Models\CodificheFHIR\FamilyMemberHistoryStatus;

class AnamnesiF extends Model {
	//
	protected $table = 'tbl_AnamnesiF';
	protected $primaryKey = 'id_anamnesiF';
	public $incrementing = true;
	public $timestamps = false;
	protected $casts = [ 
			'id_paziente' => 'int',
			'id_parente' => 'int',
			'id_anamnesiF' => 'int'
	];
	protected $dates = [ 
			'data' 
	
	];
	protected $fillable = [ 
		'id_anamnesiF',
		'descrizione',
		'id_paziente',
		'id_parente',
		'status',
		'notDoneReason',
		'note',
		'data'

	];

	public function getId(){
	    return $this->id_anamnesiF;
	}
	
	public function getParente(){
	    $parente = Parente::where('id_parente', $this->id_parente)->first();
	    return $parente->getFullName1();
	}
	
	public function getRelationship(){
	    $rel = PazientiFamiliarita::where([
	        ['id_paziente', "=", $this->id_paziente],
	        ['id_parente', "=", $this->id_parente]
	    ])->first();
	    
	    return $rel->getRelazione();
	}
	
	public function getRelationshipCode(){
	    $rel = PazientiFamiliarita::where([
	        ['id_paziente', "=", $this->id_paziente],
	        ['id_parente', "=", $this->id_parente]
	    ])->first();
	    
	    return $rel->relazione;
	}
	
	public function getStatus(){
	    return $this->status;
	}
	
	public function getStatusDisplay(){
	    $dis = FamilyMemberHistoryStatus::where('Code', $this->getStatus())->first();
	    return $dis->Display;
	}
	
	public function getPazienteId(){
	    return $this->id_paziente;
	}
	
	public function getPaziente(){
	    $paz = Pazienti::where('id_paziente', $this->getPazienteId())->first();
	    return $paz->getFullName();
	}
	
	public function getGender(){
	    $parente = Parente::where('id_parente', $this->id_parente)->first();
	    return $parente->getSesso();
	}
	
	public function getBorn(){
	    $parente = Parente::where('id_parente', $this->id_parente)->first();
	    return $parente->getDataNascita();
	}
	
	public function isDeceased(){
	    $parente = Parente::where('id_parente', $this->id_parente)->first();
	    return $parente->isDecesso();
	}
}
