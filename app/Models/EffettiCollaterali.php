<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 23 Dec 2017 16:46:47 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class EffettiCollaterali
 * 
 * @property int $id_effetto_collaterale
 * @property int $id_paziente
 * @property int $id_audit_log
 * @property string $effetto_collaterale_descrizione
 * 
 * @property \App\Models\TblAuditlogLog $tbl_auditlog_log
 * @property \App\Models\TblPazienti $tbl_pazienti
 *
 * @package App\Models
 */
class EffettiCollaterali extends Eloquent
{
	protected $table = 'tbl_effetti_collaterali';
	protected $primaryKey = 'id_effetto_collaterale';
	public $timestamps = false;

	protected $casts = [
		'id_paziente' => 'int',
		'id_audit_log' => 'int'
	];

	protected $fillable = [
		'id_paziente',
		'id_audit_log',
		'effetto_collaterale_descrizione'
	];

	public function tbl_auditlog_log()
	{
		return $this->belongsTo(\App\Models\TblAuditlogLog::class, 'id_audit_log');
	}

	public function tbl_pazienti()
	{
		return $this->belongsTo(\App\Models\TblPazienti::class, 'id_paziente');
	}
}
