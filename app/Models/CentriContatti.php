<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 23 Dec 2017 16:46:47 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class CentriContatti
 * 
 * @property int $id_contatto
 * @property int $id_centro
 * @property int $id_modalita_contatto
 * @property string $contatto_valore
 * 
 * @property \App\Models\TblCentriIndagini $tbl_centri_indagini
 * @property \App\Models\TblModalitaContatti $tbl_modalita_contatti
 *
 * @package App\Models
 */
class CentriContatti extends Eloquent
{
	protected $table = 'tbl_centri_contatti';
	protected $primaryKey = 'id_contatto';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id_contatto' => 'int',
		'id_centro' => 'int',
		'id_modalita_contatto' => 'int'
	];

	protected $fillable = [
		'id_centro',
		'id_modalita_contatto',
		'contatto_valore'
	];

	public function tbl_centri_indagini()
	{
		return $this->belongsTo(\App\Models\TblCentriIndagini::class, 'id_centro');
	}

	public function tbl_modalita_contatti()
	{
		return $this->belongsTo(\App\Models\TblModalitaContatti::class, 'id_modalita_contatto');
	}
}
