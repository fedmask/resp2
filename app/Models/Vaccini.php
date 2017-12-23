<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 23 Dec 2017 16:46:47 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Vaccini
 * 
 * @property int $id_vaccino
 * @property string $vaccino_codice
 * @property string $vaccino_descrizione
 * @property string $vaccino_nome
 * @property int $vaccino_durata
 * 
 * @property \Illuminate\Database\Eloquent\Collection $tbl_vaccinaziones
 *
 * @package App\Models
 */
class Vaccini extends Eloquent
{
	protected $table = 'tbl_vaccini';
	protected $primaryKey = 'id_vaccino';
	public $timestamps = false;

	protected $casts = [
		'vaccino_durata' => 'int'
	];

	protected $fillable = [
		'vaccino_codice',
		'vaccino_descrizione',
		'vaccino_nome',
		'vaccino_durata'
	];

	public function tbl_vaccinaziones()
	{
		return $this->hasMany(\App\Models\Vaccinazione::class, 'id_vaccino');
	}
}
