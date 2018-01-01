<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 25 Dec 2017 12:47:05 +0000.
 */

namespace App\Models\Patient;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Taccuino
 * 
 * @property int $id_taccuino
 * @property int $id_paziente
 * @property string $taccuino_descrizione
 * @property \Carbon\Carbon $taccuino_data
 * @property boolean $taccuino_report_anteriore
 * @property boolean $taccuino_report_posteriore
 * 
 * @property \App\Models\Pazienti $tbl_pazienti
 *
 * @package App\Models
 */
class Taccuino extends Eloquent
{
	protected $table = 'tbl_taccuino';
	protected $primaryKey = 'id_taccuino';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id_taccuino' => 'int',
		'id_paziente' => 'int',
	];

	protected $dates = [
		'taccuino_data'
	];

	protected $fillable = [
		'id_paziente',
		'taccuino_descrizione',
		'taccuino_data',
		'taccuino_report_anteriore',
		'taccuino_report_posteriore'
	];

	public function tbl_pazienti()
	{
		return $this->belongsTo(\App\Models\Patient\Pazienti::class, 'id_paziente');
	}
}
