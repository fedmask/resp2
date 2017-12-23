<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 23 Dec 2017 16:46:47 +0000.
 */

namespace App\Models;

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
 * @property \App\Models\TblPazienti $tbl_pazienti
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
		'taccuino_report_anteriore' => 'boolean',
		'taccuino_report_posteriore' => 'boolean'
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
		return $this->belongsTo(\App\Models\TblPazienti::class, 'id_paziente');
	}
}
