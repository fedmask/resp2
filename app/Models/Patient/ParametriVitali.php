<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 25 Dec 2017 12:47:05 +0000.
 */

namespace App\Models\Patient;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class ParametriVitali
 * 
 * @property int $id_parametro_vitale
 * @property int $id_paziente
 * @property int $id_audit_log
 * @property int $parametro_altezza
 * @property int $parametro_peso
 * @property int $parametro_pressione_minima
 * @property int $parametro_pressione_massima
 * @property int $parametro_frequenza_cardiaca
 * @property bool $parametro_dolore
 * 
 * @property \App\Models\TblAuditlogLog $tbl_auditlog_log
 * @property \App\Models\Pazienti $tbl_pazienti
 *
 * @package App\Models
 */
class ParametriVitali extends Eloquent
{
	protected $table = 'tbl_parametri_vitali';
	protected $primaryKey = 'id_parametro_vitale';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id_parametro_vitale' => 'int',
		'id_paziente' => 'int',
		'id_audit_log' => 'int',
		'parametro_altezza' => 'int',
		'parametro_peso' => 'int',
		'parametro_pressione_minima' => 'int',
		'parametro_pressione_massima' => 'int',
		'parametro_frequenza_cardiaca' => 'int',
		'parametro_dolore' => 'bool'
	];

	protected $fillable = [
		'id_paziente',
		'id_audit_log',
		'parametro_altezza',
		'parametro_peso',
		'parametro_pressione_minima',
		'parametro_pressione_massima',
		'parametro_frequenza_cardiaca',
		'parametro_dolore'
	];

	public function tbl_auditlog_log()
	{
		return $this->belongsTo(\App\Models\Log\AuditlogLog::class, 'id_audit_log');
	}

	public function tbl_pazienti()
	{
		return $this->belongsTo(\App\Models\Patient\Pazienti::class, 'id_paziente');
	}
}
