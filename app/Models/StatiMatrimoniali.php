<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 25 Dec 2017 12:47:05 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class StatiMatrimoniali
 * 
 * @property int $id_stato_matrimoniale
 * @property string $stato_matrimoniale_nome
 * @property string $stato_matrimoniale_descrizione
 *
 * @package App\Models
 */
class StatiMatrimoniali extends Eloquent
{
	protected $table = 'tbl_stati_matrimoniali';
	protected $primaryKey = 'id_stato_matrimoniale';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id_stato_matrimoniale' => 'int'
	];

	protected $fillable = [
		'stato_matrimoniale_nome',
		'stato_matrimoniale_descrizione'
	];
}
