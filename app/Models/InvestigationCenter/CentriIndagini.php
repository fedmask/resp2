<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 25 Dec 2017 12:47:05 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class CentriIndagini
 * 
 * @property int $id_centro
 * @property int $id_tipologia
 * @property int $id_comune
 * @property int $id_ccp_persona
 * @property string $centro_nome
 * @property string $centro_indirizzo
 * @property bool $centro_resp
 * 
 * @property \App\Models\CentriTipologie $tbl_centri_tipologie
 * @property \App\Models\Comuni $tbl_comuni
 * @property \App\Models\CppPersona $tbl_cpp_persona
 * @property \Illuminate\Database\Eloquent\Collection $tbl_centri_contattis
 * @property \Illuminate\Database\Eloquent\Collection $tbl_indaginis
 *
 * @package App\Models
 */
class CentriIndagini extends Eloquent
{
	protected $table = 'tbl_centri_indagini';
	protected $primaryKey = 'id_centro';
	public $timestamps = false;

	protected $casts = [
		'id_tipologia' => 'int',
		'id_comune' => 'int',
		'id_ccp_persona' => 'int',
		'centro_resp' => 'bool'
	];

	protected $fillable = [
		'id_tipologia',
		'id_comune',
		'id_ccp_persona',
		'centro_nome',
		'centro_indirizzo',
		'centro_resp'
	];

	public function tbl_centri_tipologie()
	{
		return $this->belongsTo(\App\Models\CentriTipologie::class, 'id_tipologia');
	}

	public function tbl_comuni()
	{
		return $this->belongsTo(\App\Models\Comuni::class, 'id_comune');
	}

	public function tbl_cpp_persona()
	{
		return $this->belongsTo(\App\Models\CppPersona::class, 'id_ccp_persona');
	}

	public function tbl_centri_contattis()
	{
		return $this->hasMany(\App\Models\CentriContatti::class, 'id_centro');
	}

	public function tbl_indaginis()
	{
		return $this->hasMany(\App\Models\Indagini::class, 'id_centro_indagine');
	}
}
