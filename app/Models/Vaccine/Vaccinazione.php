<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 25 Dec 2017 12:47:05 +0000.
 */

namespace App\Models\Vaccine;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Vaccinazione
 * 
 * @property int $id_vaccinazione
 * @property int $id_vaccino
 * @property int $id_paziente
 * @property int $id_cpp
 * @property int $vaccinazione_confidenzialita
 * @property \Carbon\Carbon $vaccinazione_data
 * @property string $vaccinazione_aggiornamento
 * @property string $vaccinazione_reazioni
 * 
 * @property \App\Models\TblCareProvider $tbl_care_provider
 * @property \App\Models\LivelliConfidenzialita $tbl_livelli_confidenzialitum
 * @property \App\Models\Pazienti $tbl_pazienti
 * @property \App\Models\TblVaccini $tbl_vaccini
 *
 * @package App\Models
 */
class Vaccinazione extends Eloquent
{
	protected $table = 'tbl_vaccinazione';
	protected $primaryKey = 'id_vaccinazione';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id_vaccinazione' => 'int',
		'id_vaccino' => 'int',
		'id_paziente' => 'int',
		'id_cpp' => 'int',
		'vaccinazione_confidenzialita' => 'int'
	];

	protected $dates = [
		'vaccinazione_data'
	];

	protected $fillable = [
		'id_vaccino',
		'id_paziente',
		'id_cpp',
		'vaccinazione_confidenzialita',
		'vaccinazione_data',
		'vaccinazione_aggiornamento',
		'vaccinazione_reazioni'
	];

	public function tbl_care_provider()
	{
		return $this->belongsTo(\App\Models\CareProvider\CareProvider::class, 'id_cpp');
	}

	public function tbl_livelli_confidenzialitum()
	{
		return $this->belongsTo(\App\Models\LivelliConfidenzialita::class, 'vaccinazione_confidenzialita');
	}

	public function tbl_pazienti()
	{
		return $this->belongsTo(\App\Models\Patient\Pazienti::class, 'id_paziente');
	}

	public function tbl_vaccini()
	{
		return $this->belongsTo(\App\Models\Vaccine\Vaccini::class, 'id_vaccino');
	}
}
