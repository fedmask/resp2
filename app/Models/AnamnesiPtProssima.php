<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 25 Dec 2017 12:47:05 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class AnamnesiPtProssima
 * 
 * @property int $id_anamnesi_prossima
 * @property int $id_paziente
 * @property int $id_anamnesi_log
 * @property string $anamnesi_prossima_contenuto
 *
 * @package App\Models
 */
class AnamnesiPtProssima extends Eloquent
{
	protected $table = 'tbl_anamnesi_pt_prossima';
	protected $primaryKey = 'id_anamnesi_prossima';
	public $timestamps = false;

	protected $casts = [
		'id_paziente' => 'int',
		'id_anamnesi_log' => 'int'
	];

	protected $fillable = [
		'id_paziente',
		'id_anamnesi_log',
		'anamnesi_prossima_contenuto'
	];
}
