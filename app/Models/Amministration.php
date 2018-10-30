<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Traits\Encryptable;

class Amministration extends Model 
{
	
	use Encryptable;
	protected $table = 'Utenti_Amministrativi';
	protected $primaryKey = 'id_utente';
	public $timestamps = false;
	protected $casts = [ 
			'id_utente' => 'int',
			'Comune_Nascita' => 'int',
			'Comune_Residenza' => 'int' 
	
	];
	protected $encryptable = [ 
			'Nome',
			'Cognome',
			'Tipi_Dati_Trattati',
			'Indirizzo' 
	];
	protected $dates = [ 
			'Data_Nascita' 
	];
	protected $fillable = [ 
			'id_utente',
			'Nome',
			'Cognome',
			'Tipi_Dati_Trattati',
			'Comune_Nascita',
			'Comune_Residenza',
			'Sesso',
			'Data_Nascita',
			'Indirizzo',
			'Recapito_Telefonico',
			'Ruolo' 
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
	public function getComuneN() {
		return DB::table ( 'tbl_comuni' )->where ( 'id_comune', $this->Comune_Nascita )->value ( 'comune_nominativo' );
	}
	public function getComuneR() {
		return DB::table ( 'tbl_comuni' )->where ( 'id_comune', $this->Comune_Residenza )->value ( 'comune_nominativo' );
	}
	public function getRecapitoTel() {
		return $this->Recapito_Telefonico;
	}
	public function user() {
		return $this->belongsTo ( \App\Models\CurrentUser\User::class, 'id_utente' );
	}
	public function ruolo() {
		return $this->belongsTo ( \App\AmministrationRoule::class, 'Ruolo' );
	}
	public function activity() {
		return $this->belongsTo ( \App\AdminActivity::class, 'id_utente' );
	}
}
