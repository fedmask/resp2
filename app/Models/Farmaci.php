<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 23 Dec 2017 16:46:47 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Farmaci
 * 
 * @property string $id_farmaco
 * @property string $id_categoria_farmaco
 * @property string $farmaco_nome
 * 
 * @property \App\Models\TblFarmaciCategorie $tbl_farmaci_categorie
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
		return $this->belongsTo(\App\Models\FarmaciCategorie::class, 'id_categoria_farmaco');
	}

	public function tbl_farmaci_vietatis()
	{
		return $this->hasMany(\App\Models\FarmaciVietati::class, 'id_farmaco');
	}
}
