<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 23 Dec 2017 16:46:47 +0000.
 */

namespace App\Models;

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
 * @property \App\Models\TblCodiciOperazioni $tbl_codici_operazioni
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
		return $this->belongsTo(\App\Models\TblAuditlogLog::class, 'id_audit_log');
	}

	public function tbl_codici_operazioni()
	{
		return $this->belongsTo(\App\Models\TblCodiciOperazioni::class, 'operazione_codice');
	}
}
