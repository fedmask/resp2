<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 23 Dec 2017 16:46:47 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class AnamnesiFisiologica
 * 
 * @property int $id_anamnesi_fisiologica
 * @property int $id_paziente
 * @property int $id_anamnesi_log
 *
 * @package App\Models
 */
class AnamnesiFisiologica extends Eloquent
{
	protected $table = 'tbl_anamnesi_fisiologica';
	protected $primaryKey = 'id_anamnesi_fisiologica';
	public $timestamps = false;

	protected $casts = [
		'id_paziente' => 'int',
		'id_anamnesi_log' => 'int'
	];

	protected $fillable = [
		'id_paziente',
		'id_anamnesi_log'
	];
}
