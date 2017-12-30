<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 25 Dec 2017 12:47:05 +0000.
 */

namespace App\Models\Loinc;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class LoincValori
 * 
 * @property int $id_esclab
 * @property string $id_codice
 * @property string $valore_normale
 * 
 * @property \App\Models\Loinc $tbl_loinc
 *
 * @package App\Models
 */
class LoincValori extends Eloquent
{
	protected $table = 'tbl_loinc_valori';
	protected $primaryKey = 'id_esclab';
	public $timestamps = false;

	protected $fillable = [
		'id_codice',
		'valore_normale'
	];

	public function tbl_loinc()
	{
		return $this->belongsTo(\App\Models\Loinc\Loinc::class, 'id_codice');
	}
}
