<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 25 Dec 2017 12:47:05 +0000.
 */

namespace App\Models\Diagnosis;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Diagnosi
 * 
 * @property int $id_diagnosi
 * @property int $id_paziente
 * @property int $diagnosi_confidenzialita
 * @property \Carbon\Carbon $diagnosi_inserimento_data
 * @property \Carbon\Carbon $diagnosi_aggiornamento_data
 * @property string $diagnosi_patologia
 * @property bool $diagnosi_stato
 * @property \Carbon\Carbon $diagnosi_guarigione_data
 * 
 * @property \App\Models\LivelliConfidenzialita $tbl_livelli_confidenzialitum
 * @property \App\Models\Pazienti $tbl_pazienti
 * @property \App\Models\CppDiagnosi $tbl_cpp_diagnosi
 * @property \Illuminate\Database\Eloquent\Collection $tbl_diagnosi_eliminates
 * @property \Illuminate\Database\Eloquent\Collection $tbl_indaginis
 *
 * @package App\Models
 */
class Diagnosi extends Eloquent
{
	protected $table = 'tbl_diagnosi';
	protected $primaryKey = 'id_diagnosi';
	public $timestamps = false;

	protected $casts = [
		'id_paziente' => 'int',
		'diagnosi_confidenzialita' => 'int',
		'diagnosi_stato' => 'bool'
	];

	protected $dates = [
		'diagnosi_inserimento_data',
		'diagnosi_aggiornamento_data',
		'diagnosi_guarigione_data'
	];

	protected $fillable = [
		'id_paziente',
		'diagnosi_confidenzialita',
		'diagnosi_inserimento_data',
		'diagnosi_aggiornamento_data',
		'diagnosi_patologia',
		'diagnosi_stato',
		'diagnosi_guarigione_data'
	];

	public function tbl_livelli_confidenzialitum()
	{
		return $this->belongsTo(\App\Models\LivelliConfidenzialita::class, 'diagnosi_confidenzialita');
	}

	public function tbl_pazienti()
	{
		return $this->belongsTo(\App\Models\Patient\Pazienti::class, 'id_paziente');
	}

	public function tbl_cpp_diagnosi()
	{
		return $this->hasOne(\App\Models\CareProvider\CppDiagnosi::class, 'id_diagnosi');
	}

	public function tbl_diagnosi_eliminates()
	{
		return $this->hasMany(\App\Models\Diagnosis\DiagnosiEliminate::class, 'id_diagnosi');
	}

	public function tbl_indaginis()
	{
		return $this->hasMany(\App\Models\InvestigationCenter\Indagini::class, 'id_diagnosi');
	}
}
