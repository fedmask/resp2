<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 23 Dec 2017 16:46:47 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Nazioni
 * 
 * @property int $id_nazione
 * @property string $nazione_nominativo
 * @property string $nazione_prefisso_telefonico
 * 
 * @property \Illuminate\Database\Eloquent\Collection $tbl_comunis
 *
 * @package App\Models
 */
class Nazioni extends Eloquent
{
	protected $table = 'tbl_nazioni';
	protected $primaryKey = 'id_nazione';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id_nazione' => 'int'
	];

	protected $fillable = [
		'nazione_nominativo',
		'nazione_prefisso_telefonico'
	];

	public function tbl_comunis()
	{
		return $this->hasMany(\App\Models\Comuni::class, 'id_comune_nazione');
	}
}
