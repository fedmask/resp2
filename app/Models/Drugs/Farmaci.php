<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 25 Dec 2017 12:47:05 +0000.
 */

namespace App\Models\Drugs;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Farmaci
 * 
 * @property string $id_farmaco
 * @property string $id_categoria_farmaco
 * @property string $farmaco_nome
 * 
 * @property \App\Models\FarmaciCategorie $tbl_farmaci_categorie
 * @property \Illuminate\Database\Eloquent\Collection $tbl_farmaci_vietatis
 *
 * @package App\Models
 */
class Farmaci extends Eloquent
{
	protected $table = 'tbl_farmaci';
	protected $primaryKey = 'id_farmaco';
	public $incrementing = false;
	public $timestamps = false;

	protected $fillable = [
		'id_categoria_farmaco',
		'farmaco_nome'
	];

	public function tbl_farmaci_categorie()
	{
		return $this->belongsTo(\App\Models\Drugs\FarmaciCategorie::class, 'id_categoria_farmaco');
	}

	public function tbl_farmaci_vietatis()
	{
		return $this->hasMany(\App\Models\Drugs\FarmaciVietati::class, 'id_farmaco');
	}
}
