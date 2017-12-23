<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 23 Dec 2017 16:46:47 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Pazienti
 * 
 * @property int $id_paziente
 * @property int $id_utente
 * @property int $id_paziente_contatti
 * @property string $paziente_nome
 * @property string $paziente_cognome
 * @property \Carbon\Carbon $paziente_nascita
 * @property string $paziente_codfiscale
 * @property string $paziente_sesso
 * @property string $paziente_gruppo
 * @property string $paziente_rh
 * @property int $paziente_donatore_organi
 * @property string $paziente_stato_matrimoniale
 * 
 * @property \App\Models\TblUtenti $tbl_utenti
 * @property \App\Models\TblPazientiContatti $tbl_pazienti_contatti
 * @property \Illuminate\Database\Eloquent\Collection $tbl_contatti_pazientis
 * @property \Illuminate\Database\Eloquent\Collection $tbl_cpp_pazientes
 * @property \Illuminate\Database\Eloquent\Collection $tbl_diagnosis
 * @property \Illuminate\Database\Eloquent\Collection $tbl_diagnosi_eliminates
 * @property \Illuminate\Database\Eloquent\Collection $tbl_effetti_collateralis
 * @property \Illuminate\Database\Eloquent\Collection $tbl_esami_obiettivis
 * @property \Illuminate\Database\Eloquent\Collection $tbl_farmaci_vietatis
 * @property \Illuminate\Database\Eloquent\Collection $tbl_files
 * @property \Illuminate\Database\Eloquent\Collection $tbl_indaginis
 * @property \Illuminate\Database\Eloquent\Collection $tbl_parametri_vitalis
 * @property \App\Models\TblPazientiDecessi $tbl_pazienti_decessi
 * @property \Illuminate\Database\Eloquent\Collection $tbl_pazienti_familiarita
 * @property \Illuminate\Database\Eloquent\Collection $tbl_pazienti_visites
 * @property \Illuminate\Database\Eloquent\Collection $tbl_taccuinos
 * @property \Illuminate\Database\Eloquent\Collection $tbl_vaccinaziones
 *
 * @package App\Models
 */
class Pazienti extends Eloquent
{
	protected $table = 'tbl_pazienti';
	protected $primaryKey = 'id_paziente';
	public $timestamps = false;

	protected $casts = [
		'id_utente' => 'int',
		'id_paziente_contatti' => 'int',
		'paziente_donatore_organi' => 'int'
	];

	protected $dates = [
		'paziente_nascita'
	];

	protected $fillable = [
		'id_utente',
		'id_paziente_contatti',
		'paziente_nome',
		'paziente_cognome',
		'paziente_nascita',
		'paziente_codfiscale',
		'paziente_sesso',
		'paziente_gruppo',
		'paziente_rh',
		'paziente_donatore_organi',
		'paziente_stato_matrimoniale'
	];

	public function tbl_utenti()
	{
		return $this->belongsTo(\App\Models\Utenti::class, 'id_utente');
	}

	public function tbl_pazienti_contatti()
	{
		return $this->belongsTo(\App\Models\PazientiContatti::class, 'id_paziente_contatti');
	}

	public function tbl_contatti_pazientis()
	{
		return $this->hasMany(\App\Models\ContattiPazienti::class, 'id_paziente');
	}

	public function tbl_cpp_pazientes()
	{
		return $this->hasMany(\App\Models\CppPaziente::class, 'id_paziente');
	}

	public function tbl_diagnosis()
	{
		return $this->hasMany(\App\Models\Diagnosi::class, 'id_paziente');
	}

	public function tbl_diagnosi_eliminates()
	{
		return $this->hasMany(\App\Models\DiagnosiEliminate::class, 'id_utente');
	}

	public function tbl_effetti_collateralis()
	{
		return $this->hasMany(\App\Models\EffettiCollaterali::class, 'id_paziente');
	}

	public function tbl_esami_obiettivis()
	{
		return $this->hasMany(\App\Models\EsamiObiettivi::class, 'id_paziente');
	}

	public function tbl_farmaci_vietatis()
	{
		return $this->hasMany(\App\Models\FarmaciVietati::class, 'id_paziente');
	}

	public function tbl_files()
	{
		return $this->hasMany(\App\Models\File::class, 'id_paziente');
	}

	public function tbl_indaginis()
	{
		return $this->hasMany(\App\Models\Indagini::class, 'id_paziente');
	}

	public function tbl_parametri_vitalis()
	{
		return $this->hasMany(\App\Models\ParametriVitali::class, 'id_paziente');
	}

	public function tbl_pazienti_decessi()
	{
		return $this->hasOne(\App\Models\PazientiDecessi::class, 'id_paziente');
	}

	public function tbl_pazienti_familiarita()
	{
		return $this->hasMany(\App\Models\PazientiFamiliaritum::class, 'id_paziente');
	}

	public function tbl_pazienti_visites()
	{
		return $this->hasMany(\App\Models\PazientiVisite::class, 'id_paziente');
	}

	public function tbl_taccuinos()
	{
		return $this->hasMany(\App\Models\Taccuino::class, 'id_paziente');
	}

	public function tbl_vaccinaziones()
	{
		return $this->hasMany(\App\Models\Vaccinazione::class, 'id_paziente');
	}
}
