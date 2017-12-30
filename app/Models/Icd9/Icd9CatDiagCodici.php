<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 25 Dec 2017 12:47:05 +0000.
 */

namespace App\Models\Icd9;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Icd9CatDiagCodici
 * 
 * @property string $codice_categoria
 * @property string $codice_blocco
 * @property string $categoria_cod_descrizione
 * 
 * @property \App\Models\Icd9DiagCodici $tbl_icd9_diag_codici
 * @property \App\Models\Icd9GrupDiagCodici $tbl_icd9_grup_diag_codici
 *
 * @package App\Models
 */
class Icd9CatDiagCodici extends Eloquent
{
	protected $table = 'tbl_icd9_cat_diag_codici';
	protected $primaryKey = 'codice_categoria';
	public $incrementing = false;
	public $timestamps = false;

	protected $fillable = [
		'codice_blocco',
		'categoria_cod_descrizione'
	];

	public function tbl_icd9_diag_codici()
	{
		return $this->belongsTo(\App\Models\Icd9\Icd9DiagCodici::class, 'codice_categoria', 'codice_categoria');
	}

	public function tbl_icd9_grup_diag_codici()
	{
		return $this->belongsTo(\App\Models\Icd9\Icd9GrupDiagCodici::class, 'codice_blocco');
	}
}
