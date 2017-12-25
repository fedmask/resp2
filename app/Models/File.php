<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 25 Dec 2017 12:47:05 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class File
 * 
 * @property int $id_file
 * @property int $id_paziente
 * @property int $id_audit_log
 * @property int $id_file_confidenzialita
 * @property string $file_nome
 * @property string $file_commento
 * 
 * @property \App\Models\TblAuditlogLog $tbl_auditlog_log
 * @property \App\Models\LivelliConfidenzialita $tbl_livelli_confidenzialitum
 * @property \App\Models\Pazienti $tbl_pazienti
 *
 * @package App\Models
 */
class File extends Eloquent
{
	protected $primaryKey = 'id_file';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id_file' => 'int',
		'id_paziente' => 'int',
		'id_audit_log' => 'int',
		'id_file_confidenzialita' => 'int'
	];

	protected $fillable = [
		'id_paziente',
		'id_audit_log',
		'id_file_confidenzialita',
		'file_nome',
		'file_commento'
	];

	public function tbl_auditlog_log()
	{
		return $this->belongsTo(\App\Models\TblAuditlogLog::class, 'id_audit_log');
	}

	public function tbl_livelli_confidenzialitum()
	{
		return $this->belongsTo(\App\Models\LivelliConfidenzialita::class, 'id_file_confidenzialita');
	}

	public function tbl_pazienti()
	{
		return $this->belongsTo(\App\Models\Pazienti::class, 'id_paziente');
	}
}
