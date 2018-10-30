<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Encryptable;

class AdminActivity extends Model {
	
	use Encryptable;
	//
	protected $table = 'Attivita_Amministrative';
	protected $primaryKey = 'id_attivita';
	public $timestamps = false;
	protected $casts = [ 
			'id_attivita' => 'int',
			'id_amministratore' => 'int' ,
	
	];
	
	protected $encryptable = [
			'Tipologia_attivita',
			'Descrizione',
			'Anomalie_riscontrate',
			
	];
	protected $dates = [ 
			'Start_Period',
			'End_Period' ,
	];
	protected $fillable = [ 
			'Start_Period',
			'End_Period' ,
			'id_attivita',
			'id_utente',
			'Tipologia_attivita',
			'Descrizione',
			'Anomalie_riscontrate',
	];
	
	
	public function getIDAttivita() {
		return $this->id_attivita;
	}
	
	
	public function admin() {
		return $this->belongsTo ( \App\Amministration::class, 'id_utente' );
	}
	
	
	
}
