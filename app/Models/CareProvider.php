<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 23 Dec 2017 16:46:47 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class CareProvider
 * 
 * @property int $id_cpp
 * @property int $id_cpp_tipologia
 * @property int $id_utente
 * @property string $cpp_nome
 * @property string $cpp_cognome
 * @property \Carbon\Carbon $cpp_nascita_data
 * @property string $cpp_codfiscale
 * @property string $cpp_sesso
 * @property string $cpp_n_iscrizione
 * @property string $cpp_localita_iscrizione
 * 
 * @property \App\Models\TblUtenti $tbl_utenti
 * @property \App\Models\TblCppTipologie $tbl_cpp_tipologie
 * @property \Illuminate\Database\Eloquent\Collection $tbl_cpp_diagnosis
 * @property \Illuminate\Database\Eloquent\Collection $tbl_cpp_pazientes
 * @property \Illuminate\Database\Eloquent\Collection $tbl_pazienti_visites
 * @property \Illuminate\Database\Eloquent\Collection $tbl_vaccinaziones
 *
 * @package App\Models
 */
class CareProvider extends Eloquent
{
	protected $table = 'tbl_care_provider';
	protected $primaryKey = 'id_cpp';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id_cpp' => 'int',
		'id_cpp_tipologia' => 'int',
		'id_utente' => 'int'
	];

	protected $dates = [
		'cpp_nascita_data'
	];

	protected $fillable = [
		'id_cpp_tipologia',
		'id_utente',
		'cpp_nome',
		'cpp_cognome',
		'cpp_nascita_data',
		'cpp_codfiscale',
		'cpp_sesso',
		'cpp_n_iscrizione',
		'cpp_localita_iscrizione'
	];

	public function tbl_utenti()
	{
		return $this->belongsTo(\App\Models\Utenti::class, 'id_utente');
	}

	public function tbl_cpp_tipologie()
	{
		return $this->belongsTo(\App\Models\CppTipologie::class, 'id_cpp_tipologia');
	}

	public function tbl_cpp_diagnosis()
	{
		return $this->hasMany(\App\Models\CppDiagnosi::class, 'id_cpp');
	}

	public function tbl_cpp_pazientes()
	{
		return $this->hasMany(\App\Models\CppPaziente::class, 'id_cpp');
	}

	public function tbl_pazienti_visites()
	{
		return $this->hasMany(\App\Models\PazientiVisite::class, 'id_cpp');
	}

	public function tbl_vaccinaziones()
	{
		return $this->hasMany(\App\Models\Vaccinazione::class, 'id_cpp');
	}
}
