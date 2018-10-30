<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 25 Dec 2017 12:47:05 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;
use App\Traits\Encryptable;
/**
 * Class EffettiCollaterali
 * 
 * @property int $id_effetto_collaterale
 * @property int $id_paziente
 * @property int $id_audit_log
 * @property string $effetto_collaterale_descrizione
 * 
 * @property \App\Models\TblAuditlogLog $tbl_auditlog_log
 * @property \App\Models\Pazienti $tbl_pazienti
 *
 * @package App\Models
 */
class EffettiCollaterali extends Eloquent
{
	
	
	use Encryptable;
	
	protected $table = 'tbl_effetti_collaterali';
	protected $primaryKey = 'id_effetto_collaterale';
	public $timestamps = false;

	protected $casts = [
		'id_paziente' => 'int',
		'id_audit_log' => 'int'
	];
	
	
	protected $encryptable = ['effetto_collaterale_descrizione'];

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
		return $this->belongsTo(\App\Models\Pazienti::class, 'id_paziente');
	}
}
