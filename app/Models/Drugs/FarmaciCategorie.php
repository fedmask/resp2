<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 25 Dec 2017 12:47:05 +0000.
 */

namespace App\Models\Drugs;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class FarmaciCategorie
 * 
 * @property string $id_categoria
 * @property string $categoria_descrizione
 * 
 * @property \Illuminate\Database\Eloquent\Collection $tbl_farmacis
 *
 * @package App\Models
 */
class FarmaciCategorie extends Eloquent
{
	protected $table = 'tbl_farmaci_categorie';
	protected $primaryKey = 'id_categoria';
	public $incrementing = false;
	public $timestamps = false;

	protected $fillable = [
		'categoria_descrizione'
	];

	public function tbl_farmacis()
	{
		return $this->hasMany(\App\Models\Drugs\Farmaci::class, 'id_categoria_farmaco');
	}
}
