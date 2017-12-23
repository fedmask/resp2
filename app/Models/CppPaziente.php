<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 23 Dec 2017 16:46:47 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class CppPaziente
 * 
 * @property int $id_cpp
 * @property int $id_paziente
 * @property int $assegnazione_confidenzialita
 * 
 * @property \App\Models\TblLivelliConfidenzialitum $tbl_livelli_confidenzialitum
 * @property \App\Models\TblCareProvider $tbl_care_provider
 * @property \App\Models\TblPazienti $tbl_pazienti
 *
 * @package App\Models
 */
class CppPaziente extends Eloquent
{
	protected $table = 'tbl_cpp_paziente';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id_cpp' => 'int',
		'id_paziente' => 'int',
		'assegnazione_confidenzialita' => 'int'
	];

	protected $fillable = [
		'assegnazione_confidenzialita'
	];

	public function tbl_livelli_confidenzialitum()
	{
		return $this->belongsTo(\App\Models\TblLivelliConfidenzialitum::class, 'assegnazione_confidenzialita');
	}

	public function tbl_care_provider()
	{
		return $this->belongsTo(\App\Models\TblCareProvider::class, 'id_cpp');
	}

	public function tbl_pazienti()
	{
		return $this->belongsTo(\App\Models\TblPazienti::class, 'id_paziente');
	}
}
