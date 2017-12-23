<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 23 Dec 2017 16:46:47 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class FarmaciVietati
 * 
 * @property int $id_farmaco_vietato
 * @property int $id_paziente
 * @property string $id_farmaco
 * @property string $farmaco_vietato_motivazione
 * @property int $farmaco_vietato_confidenzialita
 * 
 * @property \App\Models\TblFarmaci $tbl_farmaci
 * @property \App\Models\TblLivelliConfidenzialitum $tbl_livelli_confidenzialitum
 * @property \App\Models\TblPazienti $tbl_pazienti
 *
 * @package App\Models
 */
class FarmaciVietati extends Eloquent
{
	protected $table = 'tbl_farmaci_vietati';
	protected $primaryKey = 'id_farmaco_vietato';
	public $timestamps = false;

	protected $casts = [
		'id_paziente' => 'int',
		'farmaco_vietato_confidenzialita' => 'int'
	];

	protected $fillable = [
		'id_paziente',
		'id_farmaco',
		'farmaco_vietato_motivazione',
		'farmaco_vietato_confidenzialita'
	];

	public function tbl_farmaci()
	{
		return $this->belongsTo(\App\Models\Farmaci::class, 'id_farmaco');
	}

	public function tbl_livelli_confidenzialitum()
	{
		return $this->belongsTo(\App\Models\LivelliConfidenzialitum::class, 'farmaco_vietato_confidenzialita');
	}

	public function tbl_pazienti()
	{
		return $this->belongsTo(\App\Models\Pazienti::class, 'id_paziente');
	}
}
