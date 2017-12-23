<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 23 Dec 2017 16:46:47 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Icd9EsamiStrumentiCodici
 * 
 * @property string $esame_codice
 * @property string $esame_descrizione
 * 
 * @property \Illuminate\Database\Eloquent\Collection $tbl_indaginis
 *
 * @package App\Models
 */
class Icd9EsamiStrumentiCodici extends Eloquent
{
	protected $table = 'tbl_icd9_esami_strumenti_codici';
	protected $primaryKey = 'esame_codice';
	public $incrementing = false;
	public $timestamps = false;

	protected $fillable = [
		'esame_descrizione'
	];

	public function tbl_indaginis()
	{
		return $this->hasMany(\App\Models\TblIndagini::class, 'indagine_codice_icd');
	}
}
