<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 25 Dec 2017 12:47:05 +0000.
 */

namespace App\Models\Drugs;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class FarmaciTipologieSomm
 * 
 * @property string $id_farmaco_somministrazione
 * @property string $somministrazione_descrizione
 *
 * @package App\Models
 */
class FarmaciTipologieSomm extends Eloquent
{
	protected $table = 'tbl_farmaci_tipologie_somm';
	protected $primaryKey = 'id_farmaco_somministrazione';
	public $incrementing = false;
	public $timestamps = false;

	protected $fillable = [
		'somministrazione_descrizione'
	];
}
