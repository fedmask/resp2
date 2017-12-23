<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 23 Dec 2017 16:46:47 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class UtentiRuoli
 * 
 * @property bool $id_ruolo
 * @property string $ruolo_nome
 *
 * @package App\Models
 */
class UtentiRuoli extends Eloquent
{
	protected $table = 'tbl_utenti_ruoli';
	protected $primaryKey = 'id_ruolo';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id_ruolo' => 'bool'
	];

	protected $fillable = [
		'ruolo_nome'
	];
}
