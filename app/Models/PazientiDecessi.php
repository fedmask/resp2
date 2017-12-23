<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 23 Dec 2017 16:46:47 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class PazientiDecessi
 * 
 * @property int $id_paziente
 * @property \Carbon\Carbon $paziente_data_decesso
 * 
 * @property \App\Models\TblPazienti $tbl_pazienti
 *
 * @package App\Models
 */
class PazientiDecessi extends Eloquent
{
	protected $table = 'tbl_pazienti_decessi';
	protected $primaryKey = 'id_paziente';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id_paziente' => 'int'
	];

	protected $dates = [
		'paziente_data_decesso'
	];

	protected $fillable = [
		'paziente_data_decesso'
	];

	public function tbl_pazienti()
	{
		return $this->belongsTo(\App\Models\Pazienti::class, 'id_paziente');
	}
}
