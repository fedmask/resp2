<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 25 Dec 2017 12:47:05 +0000.
 */

namespace App\Models\Domicile;

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
	
	public function getCountryName(){
	    return $this->nazione_nominativo;
	}

	public function tbl_comunis()
	{
		return $this->hasMany(\App\Models\Domicile\Comuni::class, 'id_comune_nazione');
	}
}
