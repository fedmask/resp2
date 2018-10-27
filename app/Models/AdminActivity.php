<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminActivity extends Model {
	//
	protected $table = 'Attivita_Amministrative';
	protected $primaryKey = 'id_attivita';
	public $timestamps = false;
	protected $casts = [ 
			'id_attivita' => 'int',
			'id_amministratore' => 'int' 
	
	];
	protected $dates = [ 
			'Start_Period',
			'End_Period' 
	];
	protected $fillable = [ 
			'id_attivita',
			'id_utente',
			'Start_Period',
			'End_Period',
			'Tipologia_attivita',
			'Descrizione',
			'Anomalie_riscontrate' 
	];
	
	
	public function getIDAttivita() {
		return $this->id_attivita;
	}
	
	
	public function admin() {
		return $this->belongsTo ( \App\Amministration::class, 'id_utente' );
	}
	
	
}
