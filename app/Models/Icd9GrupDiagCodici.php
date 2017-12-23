<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 23 Dec 2017 16:46:47 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Icd9GrupDiagCodici
 * 
 * @property string $codice
 * @property string $gruppo_descrizione
 * 
 * @property \Illuminate\Database\Eloquent\Collection $tbl_icd9_bloc_diag_codicis
 * @property \Illuminate\Database\Eloquent\Collection $tbl_icd9_cat_diag_codicis
 *
 * @package App\Models
 */
class Icd9GrupDiagCodici extends Eloquent
{
	protected $table = 'tbl_icd9_grup_diag_codici';
	protected $primaryKey = 'codice';
	public $incrementing = false;
	public $timestamps = false;

	protected $fillable = [
		'gruppo_descrizione'
	];

	public function tbl_icd9_bloc_diag_codicis()
	{
		return $this->hasMany(\App\Models\TblIcd9BlocDiagCodici::class, 'codice_gruppo');
	}

	public function tbl_icd9_cat_diag_codicis()
	{
		return $this->hasMany(\App\Models\TblIcd9CatDiagCodici::class, 'codice_blocco');
	}
}
