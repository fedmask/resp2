<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 25 Dec 2017 12:47:05 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class AnamnesiFamiliare
 * 
 * @property int $id_anamnesi_familiare
 * @property int $id_paziente
 * @property int $id_anamnesi_log
 * @property string $anamnesi_contenuto
 *
 * @package App\Models
 */
class AnamnesiFamiliare extends Eloquent
{
	protected $table = 'tbl_anamnesi_familiare';
	protected $primaryKey = 'id_anamnesi_familiare';
	public $timestamps = false;

	protected $casts = [
		'id_paziente' => 'int',
		'id_anamnesi_log' => 'int'
	];

	protected $fillable = [
		'id_paziente',
		'id_anamnesi_log',
		'anamnesi_contenuto'
	];
}
