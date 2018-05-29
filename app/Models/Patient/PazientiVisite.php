<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 25 Dec 2017 12:47:05 +0000.
 */
namespace App\Models\Patient;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class PazientiVisite
 *
 * @property string $id_visita
 * @property int $id_cpp
 * @property int $id_paziente
 * @property \Carbon\Carbon $visita_data
 * @property string $visita_motivazione
 * @property string $visita_osservazioni
 * @property string $visita_conclusioni
 *
 * @property \App\Models\TblCareProvider $tbl_care_provider
 * @property \App\Models\Pazienti $tbl_pazienti
 *
 * @package App\Models
 */
class PazientiVisite extends Eloquent {
	protected $table = 'tbl_pazienti_visite';
	protected $primaryKey = 'id_visita';
	public $incrementing = false;
	public $timestamps = false;
	protected $casts = [ 
			'id_cpp' => 'int',
			'id_paziente' => 'int' 
	];
	protected $dates = [ 
			'visita_data' 
	];
	protected $fillable = [ 
			'id_cpp',
			'id_paziente',
			'visita_data',
			'visita_motivazione',
			'visita_osservazioni',
			'visita_conclusioni',
			'stato_visita',
			'codice_priorità',
			'tipo_richiesta',
			'status',
			'richiesta_visita_inizio',
			'richiesta_visita_fine' 
	
	];
	public function getID() {
		return $this->id_visita;
	}
	public function getData() {
		return $this->visita_data;
	}
	public function getMotivazione() {
		return $this->visita_motivazione;
	}
	public function getOsservazioni() {
		return $this->visita_osservazioni;
	}
	public function getConclusioni() {
		return $this->visita_data;
	}
	public function getStato() {
		return $this->stato_visita;
	}
	public function getCodiceP() {
		return $this->codice_priorità;
	}
	public function getStatus() {
		return $this->status;
	}
	public function getTRichiesta() {
		return $this->richiesta;
	}
	public function getRichiestaVI() {
		return $this->richiesta_visita_inizio;
	}
	public function getRichiestaVF() {
		return $this->richiesta_visita_fine;
	}
	public function setRichiestaVI($data) {
		$this->richiesta_visita_inizio = $data;
	}
	
	public function setRichiestaVF($data) {
		$this->richiesta_visita_fine = $data;
	}
	public function setStato($stato_visita) {
		$possibleStato = array (
				'booked',
				'arrived',
				'proposed',
				'pending',
				'cancelled',
				'noshow',
				'entered-in-error' 
		);
		
		foreach ( $possibleStato as $status ) {
			if (strtolower ( $stato_visita ) == $status) {
				$this->stato_visita = $status;
				break;
			}
		}
	}
	public function setTRichiesta($request) {
		$possibleRequest = array (
				'required',
				'optional',
				'information-only' 
		
		);
		
		foreach ( $possibleRequest as $req ) {
			if (strtolower ( $request ) == $req) {
				$this->tipo_richiesta = $req;
				break;
			}
		}
	}
	public function setStatus($status) {
		$possibleStatus = array (
				'accepted',
				'declined',
				'tentative',
				'needs-action' 
		);
		
		foreach ( $possibleStatus as $st ) {
			if (strtolower ( $status ) == $st) {
				$this->status = $st;
				break;
			}
		}
	}
	public function tbl_care_provider() {
		return $this->belongsTo ( \App\Models\CareProviders\CareProvider::class, 'id_cpp' );
	}
	public function tbl_pazienti() {
		return $this->belongsTo ( \App\Models\Patient\Pazienti::class, 'id_paziente' );
	}
	public function getID_CareProvider() {
		return $this->tbl_care_provider ()->first ()->getID ();
	}
	public function getID_Paziente() {
		return $this->tbl_pazienti ()->first ()->getID_Paziente ();
	}
}
