<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 23 Dec 2017 16:46:47 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class PazientiFamiliaritum
 * 
 * @property int $id_familiarita
 * @property int $id_paziente
 * @property int $id_parente
 * @property string $familiarita_grado_parentela
 * @property \Carbon\Carbon $familiarita_aggiornamento_data
 * @property bool $familiarita_conferma
 * 
 * @property \App\Models\TblPazienti $tbl_pazienti
 * @property \App\Models\TblUtenti $tbl_utenti
 * @property \App\Models\TblFamiliaritaDecessi $tbl_familiarita_decessi
 *
 * @package App\Models
 */
class PazientiFamiliaritum extends Eloquent
{
	protected $primaryKey = 'id_familiarita';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id_familiarita' => 'int',
		'id_paziente' => 'int',
		'id_parente' => 'int',
		'familiarita_conferma' => 'bool'
	];

	protected $dates = [
		'familiarita_aggiornamento_data'
	];

	protected $fillable = [
		'id_paziente',
		'id_parente',
		'familiarita_grado_parentela',
		'familiarita_aggiornamento_data',
		'familiarita_conferma'
	];

	public function tbl_pazienti()
	{
		return $this->belongsTo(\App\Models\TblPazienti::class, 'id_paziente');
	}

	public function tbl_utenti()
	{
		return $this->belongsTo(\App\Models\TblUtenti::class, 'id_parente');
	}

	public function tbl_familiarita_decessi()
	{
		return $this->hasOne(\App\Models\TblFamiliaritaDecessi::class, 'id_paziente');
	}
}
