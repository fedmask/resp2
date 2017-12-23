<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 23 Dec 2017 16:46:47 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

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
 * @property \App\Models\TblLoincRisposte $tbl_loinc_risposte
 * @property \App\Models\TblPazienti $tbl_pazienti
 *
 * @package App\Models
 */
class EsamiObiettivi extends Eloquent
{
	protected $table = 'tbl_esami_obiettivi';
	protected $primaryKey = 'id_esame_obiettivo';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id_esame_obiettivo' => 'int',
		'id_paziente' => 'int',
		'id_diagnosi' => 'int'
	];

	protected $dates = [
		'esame_data',
		'esame_aggiornamento'
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

	public function tbl_loinc_risposte()
	{
		return $this->belongsTo(\App\Models\LoincRisposte::class, 'codice_risposta_loinc');
	}

	public function tbl_pazienti()
	{
		return $this->belongsTo(\App\Models\Pazienti::class, 'id_paziente');
	}
}
