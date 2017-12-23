<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 23 Dec 2017 16:46:47 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Icd9BlocDiagCodici
 * 
 * @property string $codice_blocco
 * @property string $codice_gruppo
 * @property string $blocco_cod_descrizione
 * 
 * @property \App\Models\TblIcd9GrupDiagCodici $tbl_icd9_grup_diag_codici
 *
 * @package App\Models
 */
class Icd9BlocDiagCodici extends Eloquent
{
	protected $table = 'tbl_icd9_bloc_diag_codici';
	protected $primaryKey = 'codice_blocco';
	public $incrementing = false;
	public $timestamps = false;

	protected $fillable = [
		'codice_gruppo',
		'blocco_cod_descrizione'
	];

	public function tbl_icd9_grup_diag_codici()
	{
		return $this->belongsTo(\App\Models\TblIcd9GrupDiagCodici::class, 'codice_gruppo');
	}
}
