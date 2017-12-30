<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 25 Dec 2017 12:47:05 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class TipologieContatti
 * 
 * @property int $id_tipologia_centro_contatto
 * @property string $tipologia_nome
 * 
 * @property \Illuminate\Database\Eloquent\Collection $tbl_contatti_pazientis
 *
 * @package App\Models
 */
class TipologieContatti extends Eloquent
{
	protected $table = 'tbl_tipologie_contatti';
	protected $primaryKey = 'id_tipologia_contatto';
	public $timestamps = false;

	protected $fillable = [
		'tipologia_nome'
	];

	public function tbl_contatti_pazientis()
	{
		return $this->hasMany(\App\Models\ContattiPazienti::class, 'id_contatto_tipologia');
	}
}
