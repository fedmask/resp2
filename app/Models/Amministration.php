<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Amministration extends Model


{
	protected $table = 'Utenti_Amministrativi';
	protected $primaryKey = 'id_utente';
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
			'Nome',
			'Cognome',
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
	public function getDataN() {
		return $this->Data_nascita;
	}
	
	public function getRecapito() {
		return $this->Recapito_Telefonico;
	}
	public function getIndirizzo() {
		return $this->Indirizzo;
	}
	
	public function getName() {
		return $this->Nome;
	}
	
	public function getSurname() {
		return $this->Cognome;
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
		return $this->belongsTo ( \App\AmministrationRoule::class, 'Ruolo' );
	}
	
}
