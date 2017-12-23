<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 23 Dec 2017 16:46:47 +0000.
 */

namespace App\Models;

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
		return $this->hasMany(\App\Models\CentriContatti::class, 'id_modalita_contatto');
	}
}
