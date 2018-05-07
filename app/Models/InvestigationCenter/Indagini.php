<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 25 Dec 2017 12:47:05 +0000.
 */

namespace App\Models\InvestigationCenter;

use Reliese\Database\Eloquent\Model as Eloquent;
use DateTime;
/**
 * Class Indagini
 * 
 * @property int $id_indagine
 * @property int $id_centro_indagine
 * @property int $id_diagnosi
 * @property int $id_paziente
 * @property \Carbon\Carbon $indagine_data
 * @property \Carbon\Carbon $indagine_aggiornamento
 * @property string $indagine_stato
 * @property string $indagine_tipologia
 * @property string $indagine_motivo
 * @property string $indagine_referto
 * @property string $indagine_allegato
 * @property int $id_cpp
 * @property \App\Models\TblAuditlogLog $tbl_auditlog_log
 * @property \App\Models\CentriIndagini $tbl_centri_indagini
 * @property \App\Models\Diagnosi $tbl_diagnosi
 * @property \App\Models\Icd9EsamiStrumentiCodici $tbl_icd9_esami_strumenti_codici
 * @property \App\Models\Loinc $tbl_loinc
 * @property \App\Models\Pazienti $tbl_pazienti
 *
 * @package App\Models
 */
class Indagini extends Eloquent
{
	protected $table = 'tbl_indagini';
	protected $primaryKey = 'id_indagine';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id_indagine' => 'int',
		'id_centro_indagine' => 'int',
		'id_diagnosi' => 'int',
		'id_paziente' => 'int',
	    'id_cpp' => 'int',
	];

	protected $dates = [
		'indagine_data',
		'indagine_aggiornamento'
	];

	protected $fillable = [
		'id_centro_indagine',
		'id_diagnosi',
		'id_paziente',
	    'id_cpp',
	    'careprovider',
		'indagine_data',
		'indagine_aggiornamento',
		'indagine_stato',
		'indagine_tipologia',
		'indagine_motivo',
		'indagine_referto',
		'indagine_allegato'
	];




	public function tbl_centri_indagini()
	{
		return $this->belongsTo(\App\Models\InvestigationCenter\CentriIndagini::class, 'id_centro_indagine');
	}

	public function tbl_diagnosi()
	{
		return $this->belongsTo(\App\Models\Diagnosis\Diagnosi::class, 'id_diagnosi');
	}

	public function tbl_pazienti()
	{
		return $this->belongsTo(\App\Models\Patient\Pazienti::class, 'id_paziente');
	}
	
	public function tbl_care_provider()
	{
	    return $this->belongsTo(App\Models\CareProviders\CareProvider::class, 'id_cpp');
	}
	
}
