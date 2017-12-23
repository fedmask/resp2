<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 23 Dec 2017 16:46:47 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Utenti
 * 
 * @property int $id_utente
 * @property int $utente_tipologia
 * @property string $utente_nome
 * @property string $utente_password
 * @property int $utente_stato
 * @property \Carbon\Carbon $utente_scadenza
 * @property string $utente_email
 * 
 * @property \App\Models\TblUtentiTipologie $tbl_utenti_tipologie
 * @property \Illuminate\Database\Eloquent\Collection $tbl_auditlog_logs
 * @property \Illuminate\Database\Eloquent\Collection $tbl_care_providers
 * @property \Illuminate\Database\Eloquent\Collection $tbl_cpp_personas
 * @property \Illuminate\Database\Eloquent\Collection $tbl_pazientis
 * @property \Illuminate\Database\Eloquent\Collection $tbl_pazienti_familiarita
 * @property \Illuminate\Database\Eloquent\Collection $tbl_recapitis
 *
 * @package App\Models
 */
class Utenti extends Eloquent
{
	protected $table = 'tbl_utenti';
	protected $primaryKey = 'id_utente';
	public $timestamps = false;

	protected $casts = [
		'utente_tipologia' => 'int',
		'utente_stato' => 'int'
	];

	protected $dates = [
		'utente_scadenza'
	];

	protected $hidden = [
		'utente_password'
	];

	protected $fillable = [
		'utente_tipologia',
		'utente_nome',
		'utente_password',
		'utente_stato',
		'utente_scadenza',
		'utente_email'
	];

	public function tbl_utenti_tipologie()
	{
		return $this->belongsTo(\App\Models\UtentiTipologie::class, 'utente_tipologia');
	}

	public function tbl_auditlog_logs()
	{
		return $this->hasMany(\App\Models\AuditlogLog::class, 'id_visitato');
	}

	public function tbl_care_providers()
	{
		return $this->hasMany(\App\Models\CareProvider::class, 'id_utente');
	}

	public function tbl_cpp_personas()
	{
		return $this->hasMany(\App\Models\CppPersona::class, 'id_utente');
	}

	public function tbl_pazientis()
	{
		return $this->hasMany(\App\Models\Pazienti::class, 'id_utente');
	}

	public function tbl_pazienti_familiarita()
	{
		return $this->hasMany(\App\Models\PazientiFamiliaritum::class, 'id_parente');
	}

	public function tbl_recapitis()
	{
		return $this->hasMany(\App\Models\Recapiti::class, 'id_utente');
	}
}
