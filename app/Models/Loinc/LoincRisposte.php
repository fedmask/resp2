<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 25 Dec 2017 12:47:05 +0000.
 */

namespace App\Models\Loinc;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class LoincRisposte
 * 
 * @property string $codice_risposta
 * @property string $codice_loinc
 * 
 * @property \App\Models\Loinc $tbl_loinc
 * @property \Illuminate\Database\Eloquent\Collection $tbl_esami_obiettivis
 *
 * @package App\Models
 */
class LoincRisposte extends Eloquent
{
	protected $table = 'tbl_loinc_risposte';
	protected $primaryKey = 'codice_risposta';
	public $incrementing = false;
	public $timestamps = false;

	protected $fillable = [
		'codice_loinc'
	];

	public function tbl_loinc()
	{
		return $this->belongsTo(\App\Models\Loinc\Loinc::class, 'codice_risposta');
	}

	public function tbl_esami_obiettivis()
	{
		return $this->hasMany(\App\Models\EsamiObiettivi::class, 'codice_risposta_loinc');
	}
}
