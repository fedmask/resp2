<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 23 Dec 2017 16:46:47 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class PazientiVisite
 * 
 * @property string $id_visita
 * @property int $id_cpp
 * @property int $id_paziente
 * @property \Carbon\Carbon $visita_data
 * @property string $visita_motivazione
 * @property string $visita_osservazioni
 * @property string $visita_conclusioni
 * 
 * @property \App\Models\TblCareProvider $tbl_care_provider
 * @property \App\Models\TblPazienti $tbl_pazienti
 *
 * @package App\Models
 */
class PazientiVisite extends Eloquent
{
	protected $table = 'tbl_pazienti_visite';
	protected $primaryKey = 'id_visita';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id_cpp' => 'int',
		'id_paziente' => 'int'
	];

	protected $dates = [
		'visita_data'
	];

	protected $fillable = [
		'id_cpp',
		'id_paziente',
		'visita_data',
		'visita_motivazione',
		'visita_osservazioni',
		'visita_conclusioni'
	];

	public function tbl_care_provider()
	{
		return $this->belongsTo(\App\Models\TblCareProvider::class, 'id_cpp');
	}

	public function tbl_pazienti()
	{
		return $this->belongsTo(\App\Models\TblPazienti::class, 'id_paziente');
	}
}
