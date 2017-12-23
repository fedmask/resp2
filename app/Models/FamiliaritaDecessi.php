<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 23 Dec 2017 16:46:47 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class FamiliaritaDecessi
 * 
 * @property int $id_paziente
 * @property \Carbon\Carbon $familiare_data_decesso
 * 
 * @property \App\Models\TblPazientiFamiliaritum $tbl_pazienti_familiaritum
 *
 * @package App\Models
 */
class FamiliaritaDecessi extends Eloquent
{
	protected $table = 'tbl_familiarita_decessi';
	protected $primaryKey = 'id_paziente';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id_paziente' => 'int'
	];

	protected $dates = [
		'familiare_data_decesso'
	];

	protected $fillable = [
		'familiare_data_decesso'
	];

	public function tbl_pazienti_familiaritum()
	{
		return $this->belongsTo(\App\Models\PazientiFamiliaritum::class, 'id_paziente');
	}
}
