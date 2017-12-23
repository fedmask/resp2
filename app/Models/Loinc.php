<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 23 Dec 2017 16:46:47 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Loinc
 * 
 * @property string $codice_loinc
 * @property string $loinc_classe
 * @property string $loinc_componente
 * @property string $loinc_proprieta
 * @property string $loinc_temporizzazione
 * @property string $loinc_sistema
 * @property string $loinc_scala
 * @property string $loinc_metodo
 * 
 * @property \Illuminate\Database\Eloquent\Collection $tbl_indaginis
 * @property \App\Models\TblLoincRisposte $tbl_loinc_risposte
 * @property \Illuminate\Database\Eloquent\Collection $tbl_loinc_valoris
 *
 * @package App\Models
 */
class Loinc extends Eloquent
{
	protected $table = 'tbl_loinc';
	protected $primaryKey = 'codice_loinc';
	public $incrementing = false;
	public $timestamps = false;

	protected $fillable = [
		'loinc_classe',
		'loinc_componente',
		'loinc_proprieta',
		'loinc_temporizzazione',
		'loinc_sistema',
		'loinc_scala',
		'loinc_metodo'
	];

	public function tbl_indaginis()
	{
		return $this->hasMany(\App\Models\TblIndagini::class, 'indagine_codice_loinc');
	}

	public function tbl_loinc_risposte()
	{
		return $this->hasOne(\App\Models\TblLoincRisposte::class, 'codice_risposta');
	}

	public function tbl_loinc_valoris()
	{
		return $this->hasMany(\App\Models\TblLoincValori::class, 'id_codice');
	}
}
