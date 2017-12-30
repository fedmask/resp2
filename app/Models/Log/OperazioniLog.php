<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 25 Dec 2017 12:47:05 +0000.
 */

namespace App\Models\Log;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class OperazioniLog
 * 
 * @property int $id_operazione
 * @property int $id_audit_log
 * @property string $operazione_codice
 * @property \Carbon\Carbon $operazione_orario
 * 
 * @property \App\Models\TblAuditlogLog $tbl_auditlog_log
 * @property \App\Models\CodiciOperazioni $tbl_codici_operazioni
 *
 * @package App\Models
 */
class OperazioniLog extends Eloquent
{
	protected $table = 'tbl_operazioni_log';
	protected $primaryKey = 'id_operazione';
	public $timestamps = false;

	protected $casts = [
		'id_audit_log' => 'int'
	];

	protected $dates = [
		'operazione_orario'
	];

	protected $fillable = [
		'id_audit_log',
		'operazione_codice',
		'operazione_orario'
	];

	public function tbl_auditlog_log()
	{
		return $this->belongsTo(\App\Models\Log\AuditlogLog::class, 'id_audit_log');
	}

	public function tbl_codici_operazioni()
	{
		return $this->belongsTo(\App\Models\Log\CodiciOperazioni::class, 'operazione_codice');
	}
}
