<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Amministration extends Model


{
	protected $table = 'Consenso_Paziente';
	protected $primaryKey = 'Id_Consenso_P';
	public $timestamps = false;
	protected $casts = [ 
			'id_utente' => 'int',
			'Comune_Nascita' => 'int',
			'Comune_Residenza' => 'int' 
	
	];
	protected $dates = [ 
			'Data_Nascita' 
	];
	protected $fillable = [ 
			'id_utente',
			'Tipi_Dati_Trattati',
			'Sesso',
			'Data_Nascita',
			'Indirizzo',
			'Recapito_Telefonico' 
	];
	public function getUtente() {
		return $this->id_utente;
	}
	public function getTipoDati() {
		return $this->Tipo_Dati;
	}
	public function getSesso() {
		return $this->Sesso;
	}
	public function getDataConsenso() {
		return date ( 'd/m/y H:m', strtotime ( $this->Data_Nascita ) );
	}
	public function getIndirizzo() {
		return $this->Indirizzo;
	}
		
	
	
	
	public function getComuneN(){
		
		return DB::table('tbl_comuni')->where('id_comune', $this->Comune_Nascita)->value('comune_nominativo');
	}
	
	public function getComuneR(){
		
		return DB::table('tbl_comuni')->where('id_comune', $this->Comune_Residenza)->value('comune_nominativo');
	}
	
	public function getRecapitoTel(){
		
		return $this->Recapito_Telefonico;
		
	}

	
	public function user() {
		return $this->belongsTo ( \App\Models\CurrentUser\User::class, 'id_utente' );
	}
	
	public function ruolo() {
		return $this->belongsTo ( \App\Models\CurrentUser\User::class, 'id_utente' );
	}
	
}
