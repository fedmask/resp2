<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 23 Dec 2017 16:46:47 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Comuni
 * 
 * @property int $id_comune
 * @property int $id_comune_nazione
 * @property string $comune_nominativo
 * @property string $comune_cap
 * 
 * @property \App\Models\TblNazioni $tbl_nazioni
 * @property \Illuminate\Database\Eloquent\Collection $tbl_centri_indaginis
 * @property \Illuminate\Database\Eloquent\Collection $tbl_cpp_personas
 * @property \Illuminate\Database\Eloquent\Collection $tbl_pazienti_contattis
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
		'id_comune_nazione',
		'comune_nominativo',
		'comune_cap'
	];

	public function tbl_nazioni()
	{
		return $this->belongsTo(\App\Models\Nazioni::class, 'id_comune_nazione');
	}

	public function tbl_centri_indaginis()
	{
		return $this->hasMany(\App\Models\CentriIndagini::class, 'id_comune');
	}

	public function tbl_cpp_personas()
	{
		return $this->hasMany(\App\Models\CppPersona::class, 'id_comune');
	}

	public function tbl_pazienti_contattis()
	{
		return $this->hasMany(\App\Models\PazientiContatti::class, 'id_comune_residenza');
	}

	public function tbl_recapitis()
	{
		return $this->hasMany(\App\Models\Recapiti::class, 'id_comune_nascita');
	}
}
