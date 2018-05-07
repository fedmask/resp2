<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 25 Dec 2017 12:47:05 +0000.
 */

namespace App\Models\Diagnosis;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class DiagnosiEliminate
 * 
 * @property int $id_diagnosi_eliminata
 * @property int $id_utente
 * @property int $id_diagnosi
 * 
 * @property \App\Models\Diagnosi $tbl_diagnosi
 * @property \App\Models\Pazienti $tbl_pazienti
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

	public function diagnosi()
	{
		return $this->belongsTo(\App\ModelsDiagnosis\Diagnosi::class, 'id_diagnosi');
	}

	public function pazienti()
	{
		return $this->belongsTo(\App\Models\Patient\Pazienti::class, 'id_utente');
	}
}
