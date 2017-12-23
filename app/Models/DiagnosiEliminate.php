<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 23 Dec 2017 16:46:47 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class DiagnosiEliminate
 * 
 * @property int $id_diagnosi_eliminata
 * @property int $id_utente
 * @property int $id_diagnosi
 * 
 * @property \App\Models\TblDiagnosi $tbl_diagnosi
 * @property \App\Models\TblPazienti $tbl_pazienti
 *
 * @package App\Models
 */
class DiagnosiEliminate extends Eloquent
{
	protected $table = 'tbl_diagnosi_eliminate';
	protected $primaryKey = 'id_diagnosi_eliminata';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id_diagnosi_eliminata' => 'int',
		'id_utente' => 'int',
		'id_diagnosi' => 'int'
	];

	protected $fillable = [
		'id_utente',
		'id_diagnosi'
	];

	public function tbl_diagnosi()
	{
		return $this->belongsTo(\App\Models\Diagnosi::class, 'id_diagnosi');
	}

	public function tbl_pazienti()
	{
		return $this->belongsTo(\App\Models\Pazienti::class, 'id_utente');
	}
}
