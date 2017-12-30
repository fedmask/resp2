<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 25 Dec 2017 12:47:05 +0000.
 */

namespace App\Models\InvestigationCenter;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class ModalitaContatti
 * 
 * @property int $id_modalita
 * @property string $modalita_nome
 * 
 * @property \Illuminate\Database\Eloquent\Collection $tbl_centri_contattis
 *
 * @package App\Models
 */
class ModalitaContatti extends Eloquent
{
	protected $table = 'tbl_modalita_contatti';
	protected $primaryKey = 'id_modalita';
	public $timestamps = false;

	protected $fillable = [
		'modalita_nome'
	];

	public function tbl_centri_contattis()
	{
		return $this->hasMany(\App\Models\InvestigationCenter\CentriContatti::class, 'id_modalita_contatto');
	}
}
