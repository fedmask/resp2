<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 25 Dec 2017 12:47:05 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class CentriTipologie
 * 
 * @property int $id_centro_tipologia
 * @property string $tipologia_nome
 * 
 * @property \Illuminate\Database\Eloquent\Collection $tbl_centri_indaginis
 *
 * @package App\Models
 */
class CentriTipologie extends Eloquent
{
	protected $table = 'tbl_centri_tipologie';
	protected $primaryKey = 'id_centro_tipologia';
	public $timestamps = false;

	protected $fillable = [
		'tipologia_nome'
	];

	public function tbl_centri_indaginis()
	{
		return $this->hasMany(\App\Models\CentriIndagini::class, 'id_tipologia');
	}
}
