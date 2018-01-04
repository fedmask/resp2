<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 25 Dec 2017 12:47:05 +0000.
 */

namespace App\Models\Log;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class AuditlogLog
 * 
 * @property int $id_audit
 * @property string $audit_nome
 * @property string $audit_ip
 * @property int $id_visitato
 * @property int $id_visitante
 * @property \Carbon\Carbon $audit_data
 * 
 * @property \App\Models\Utenti $tbl_utenti
 * @property \Illuminate\Database\Eloquent\Collection $tbl_effetti_collateralis
 * @property \Illuminate\Database\Eloquent\Collection $tbl_files
 * @property \Illuminate\Database\Eloquent\Collection $tbl_indaginis
 * @property \Illuminate\Database\Eloquent\Collection $tbl_operazioni_logs
 * @property \Illuminate\Database\Eloquent\Collection $tbl_parametri_vitalis
 *
 * @package App\Models
 */
class AuditlogLog extends Eloquent
{
	protected $table = 'tbl_auditlog_log';
	protected $primaryKey = 'id_audit';
	public $timestamps = false;

	protected $casts = [
		'id_visitato' => 'int',
		'id_visitante' => 'int'
	];

	protected $dates = [
		//'audit_data'
	]; 

	protected $fillable = [
		'audit_nome',
		'audit_ip',
		'id_visitato',
		'id_visitante',
		'audit_data'
	];

	public function tbl_utenti()
	{
		return $this->belongsTo(\App\Models\CurrentUser\User::class, 'id_visitato');
	}

	public function tbl_effetti_collateralis()
	{
		return $this->hasMany(\App\Models\EffettiCollaterali::class, 'id_audit_log');
	}

	public function tbl_files()
	{
		return $this->hasMany(\App\Models\File::class, 'id_audit_log');
	}

	public function tbl_indaginis()
	{
		return $this->hasMany(\App\Models\Indagini::class, 'id_audit_log');
	}

	public function tbl_operazioni_logs()
	{
		return $this->hasMany(\App\Models\OperazioniLog::class, 'id_audit_log');
	}

	public function tbl_parametri_vitalis()
	{
		return $this->hasMany(\App\Models\ParametriVitali::class, 'id_audit_log');
	}
}
