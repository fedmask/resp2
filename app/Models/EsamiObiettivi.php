<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 25 Dec 2017 12:47:05 +0000.
 */
namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;
use App\Traits\Encryptable;

/**
 * Class EsamiObiettivi
 *
 * @property int $id_esame_obiettivo
 * @property int $id_paziente
 * @property string $codice_risposta_loinc
 * @property int $id_diagnosi
 * @property \Carbon\Carbon $esame_data
 * @property \Carbon\Carbon $esame_aggiornamento
 * @property string $esame_stato
 * @property string $esame_risultato
 *
 * @property \App\Models\LoincRisposte $tbl_loinc_risposte
 * @property \App\Models\Pazienti $tbl_pazienti
 *
 * @package App\Models
 */
class EsamiObiettivi extends Eloquent {
	
	use Encryptable;
	protected $table = 'tbl_esami_obiettivi';
	protected $primaryKey = 'id_esame_obiettivo';
	public $incrementing = false;
	public $timestamps = false;
	protected $encryptable = [ 
			'esame_aggiornamento',
			'esame_stato',
			'esame_risultato' 
	];
	protected $casts = [ 
			'id_esame_obiettivo' => 'int',
			'id_paziente' => 'int',
			'id_diagnosi' => 'int' 
	];
	protected $dates = [ 
			'esame_aggiornamento'.
			'esame_risultato' 
	];
	protected $fillable = [ 
			'id_paziente',
			'codice_risposta_loinc',
			'id_diagnosi',
			'esame_data',
			'esame_aggiornamento',
			'esame_stato',
			'esame_risultato' 
	];
	public function tbl_loinc_risposte() {
		return $this->belongsTo ( \App\Models\LoincRisposte::class, 'codice_risposta_loinc' );
	}
	public function tbl_pazienti() {
		return $this->belongsTo ( \App\Models\Pazienti::class, 'id_paziente' );
	}
}
