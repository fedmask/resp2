<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 23 Dec 2017 16:46:47 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class LoincValori
 * 
 * @property int $id_esclab
 * @property string $id_codice
 * @property string $valore_normale
 * 
 * @property \App\Models\TblLoinc $tbl_loinc
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
		return $this->belongsTo(\App\Models\Loinc::class, 'id_codice');
	}
}
