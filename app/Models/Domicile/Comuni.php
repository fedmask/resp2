<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 25 Dec 2017 12:47:05 +0000.
 */

namespace App\Models\Domicile;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Comuni
 * 
 * @property int $id_comune
 * @property int $id_comune_nazione
 * @property string $comune_nominativo
 * @property string $comune_cap
 * 
 * @property \App\Models\Nazioni $tbl_nazioni
 * @property \Illuminate\Database\Eloquent\Collection $tbl_centri_indaginis
 * @property \Illuminate\Database\Eloquent\Collection $tbl_cpp_personas
 * @property \Illuminate\Database\Eloquent\Collection $tbl_recapitis
 *
 * @package App\Models
 */
class Comuni extends Eloquent
{
	protected $table = 'tbl_comuni';
	protected $primaryKey = 'id_comune';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id_comune' => 'int',
		'id_comune_nazione' => 'int'
	];

	protected $fillable = [
			'id_comune',
		'id_comune_nazione',
		'comune_nominativo',
		'comune_cap'
	];

	
	public function getID(){
	    return $this->primaryKey;
	}
	
	public function getTown(){
	    return $this->comune_nominativo;
	}
	
	public function tbl_nazioni()
	{
		return $this->belongsTo(\App\Models\Domicile\Nazioni::class, 'id_comune_nazione');
	}

	public function tbl_centri_indaginis()
	{
		return $this->hasMany(\App\Models\InvestigationCenter\CentriIndagini::class, 'id_comune');
	}

	public function tbl_cpp_personas()
	{
		return $this->hasMany(\App\Models\CareProvider\CppPersona::class, 'id_comune');
	}

	public function tbl_recapitis()
	{
		return $this->hasMany(\App\Models\CurrentUser\Recapiti::class, 'id_comune_nascita');
	}
}
