<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 23 Dec 2017 16:46:47 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Indagini
 * 
 * @property int $id_indagine
 * @property int $id_centro_indagine
 * @property int $id_diagnosi
 * @property int $id_paziente
 * @property int $id_audit_log
 * @property string $indagine_codice_icd
 * @property string $indagine_codice_loinc
 * @property \Carbon\Carbon $indagine_data
 * @property \Carbon\Carbon $indagine_aggiornamento
 * @property string $indagine_stato
 * @property string $indagine_tipologia
 * @property string $indagine_motivo
 * @property string $indagine_referto
 * @property string $indagine_allegato
 * 
 * @property \App\Models\TblAuditlogLog $tbl_auditlog_log
 * @property \App\Models\TblCentriIndagini $tbl_centri_indagini
 * @property \App\Models\TblDiagnosi $tbl_diagnosi
 * @property \App\Models\TblIcd9EsamiStrumentiCodici $tbl_icd9_esami_strumenti_codici
 * @property \App\Models\TblLoinc $tbl_loinc
 * @property \App\Models\TblPazienti $tbl_pazienti
 *
 * @package App\Models
 */
class Indagini extends Eloquent
{
	protected $table = 'tbl_indagini';
	protected $primaryKey = 'id_indagine';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id_indagine' => 'int',
		'id_centro_indagine' => 'int',
		'id_diagnosi' => 'int',
		'id_paziente' => 'int',
		'id_audit_log' => 'int'
	];

	protected $dates = [
		'indagine_data',
		'indagine_aggiornamento'
	];

	protected $fillable = [
		'id_centro_indagine',
		'id_diagnosi',
		'id_paziente',
		'id_audit_log',
		'indagine_codice_icd',
		'indagine_codice_loinc',
		'indagine_data',
		'indagine_aggiornamento',
		'indagine_stato',
		'indagine_tipologia',
		'indagine_motivo',
		'indagine_referto',
		'indagine_allegato'
	];

	public function tbl_auditlog_log()
	{
		return $this->belongsTo(\App\Models\TblAuditlogLog::class, 'id_audit_log');
	}

	public function tbl_centri_indagini()
	{
		return $this->belongsTo(\App\Models\TblCentriIndagini::class, 'id_centro_indagine');
	}

	public function tbl_diagnosi()
	{
		return $this->belongsTo(\App\Models\TblDiagnosi::class, 'id_diagnosi');
	}

	public function tbl_icd9_esami_strumenti_codici()
	{
		return $this->belongsTo(\App\Models\TblIcd9EsamiStrumentiCodici::class, 'indagine_codice_icd');
	}

	public function tbl_loinc()
	{
		return $this->belongsTo(\App\Models\TblLoinc::class, 'indagine_codice_loinc');
	}

	public function tbl_pazienti()
	{
		return $this->belongsTo(\App\Models\TblPazienti::class, 'id_paziente');
	}
}
