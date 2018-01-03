<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 25 Dec 2017 12:47:05 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class UtentiTipologie
 * 
 * @property int $id_tipologia
 * @property string $tipologia_descrizione
 * 
 * @property \Illuminate\Database\Eloquent\Collection $tbl_utentis
 *
 * @package App\Models
 */
class UtentiTipologie extends Eloquent
{
	protected $table = 'tbl_utenti_tipologie';
	protected $primaryKey = 'id_tipologia';
	public $timestamps = false;
	public $incrementing = false;

	protected $fillable = [
	    'tipologia_nome',
		'tipologia_descrizione'
	];

	public function tbl_utentis()
	{
		return $this->hasMany(\App\Models\Utenti::class, 'id_tipologia');
	}
}
