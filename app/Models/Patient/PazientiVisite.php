<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 25 Dec 2017 12:47:05 +0000.
 */
namespace App\Models\Patient;

use Reliese\Database\Eloquent\Model as Eloquent;
use App\Models\CodificheFHIR\EncounterStatus;
use App\Models\CodificheFHIR\EncounterClass;
use App\Models\CodificheFHIR\EncounterReason;
use App\Models\Patient\Pazienti;
use App\Traits\Encryptable;

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
	
	use Encryptable;
	protected $table = 'tbl_pazienti_visite';
	protected $primaryKey = 'id_visita';
	public $incrementing = false;
	public $timestamps = false;
	protected $casts = [ 
			'id_visita' => 'int',
			'id_cpp' => 'int',
			'id_paziente' => 'int' 
	];
	protected $dates = [ 
			'visita_data',
			'start_period',
			'end_period' 
	];
	protected $fillable = [ 
			'id_visita',
			'id_cpp',
			'id_paziente',
			'status',
			'class',
			'start_period',
			'end_period',
			'reason',
			'visita_data',
			'visita_motivazione',
			'visita_osservazioni',
			'visita_conclusioni',
			'stato_visita',
			'codice_priorita',
			'tipo_richiesta',
			'richiesta_visita_inizio',
			'richiesta_visita_fine' 
	];
	protected $encryptable = [ 
			'visita_motivazione',
			'visita_osservazioni',
			'visita_conclusioni' 
	
	];

	
	public function tbl_care_provider() {
		return $this->belongsTo ( \App\Models\CareProviders\CareProvider::class, 'id_cpp' );
	}
	public function tbl_pazienti() {
		return $this->belongsTo ( \App\Models\Patient\Pazienti::class, 'id_paziente' );
	}
	public function getId() {
		return $this->id_visita;
	}
	public function getStatus() {
		return $this->status;
	}
	public function getStatusDisplay() {
		$dis = EncounterStatus::where ( 'Code', $this->status )->first ();
		return $dis->Display;
	}
	public function getClass() {
		return $this->class;
	}
	public function getClassDisplay() {
		$dis = EncounterClass::where ( 'Code', $this->class )->first ();
		return $dis->Display;
	}
	public function getVisitaData() {
		$data = date_format ( $this->visita_data, "Y-m-d" );
		return $data;
	}
	public function getStartPeriod() {
		$t = $this->start_period;
		date_default_timezone_set ( "Europe/Rome" );
		
		$date = date ( DATE_ATOM, mktime ( date ( "H", strtotime ( $t ) ), date ( "m", strtotime ( $t ) ), date ( "s", strtotime ( $t ) ), date ( "m", strtotime ( $t ) ), date ( "d", strtotime ( $t ) ), date ( "Y", strtotime ( $t ) ) ) );
		return $date;
	}
	public function getEndPeriod() {
		$t = $this->end_period;
		date_default_timezone_set ( "Europe/Rome" );
		
		$date = date ( DATE_ATOM, mktime ( date ( "H", strtotime ( $t ) ), date ( "m", strtotime ( $t ) ), date ( "s", strtotime ( $t ) ), date ( "m", strtotime ( $t ) ), date ( "d", strtotime ( $t ) ), date ( "Y", strtotime ( $t ) ) ) );
		return $date;
	}
	public function getIdPaziente() {
		return $this->id_paziente;
	}
	public function getPaziente() {
		$paz = Pazienti::where ( 'id_paziente', $this->id_paziente )->first ();
		return $paz->getFullName ();
	}
	public function getReason() {
		return $this->reason;
	}
	public function getReasonDisplay() {
		$dis = EncounterReason::where ( 'Code', $this->getReason () )->first ();
		return $dis->Text;
	}
	public function getAltraMotivazione() {
		return $this->visita_motivazione;
	}
	public function getOsservazioni() {
		return $this->visita_osservazioni;
	}
	public function getConclusioni() {
		return $this->visita_conclusioni;
	}
}
