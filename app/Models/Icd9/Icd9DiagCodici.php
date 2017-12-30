<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 25 Dec 2017 12:47:05 +0000.
 */

namespace App\Models\Icd9;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Icd9DiagCodici
 * 
 * @property string $codice_diag
 * @property string $codice_categoria
 * @property string $codice_descrizione
 * 
 * @property \App\Models\Icd9CatDiagCodici $tbl_icd9_cat_diag_codici
 *
 * @package App\Models
 */
class Icd9DiagCodici extends Eloquent
{
	protected $table = 'tbl_icd9_diag_codici';
	protected $primaryKey = 'codice_diag';
	public $incrementing = false;
	public $timestamps = false;

	protected $fillable = [
		'codice_categoria',
		'codice_descrizione'
	];

	public function tbl_icd9_cat_diag_codici()
	{
		return $this->hasOne(\App\Models\Icd9\Icd9CatDiagCodici::class, 'codice_categoria', 'codice_categoria');
	}
}
