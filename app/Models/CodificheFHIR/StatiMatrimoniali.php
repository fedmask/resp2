<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 19 Sep 2018 06:05:03 +0000.
 */

namespace App\Models\CodificheFHIR;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class StatiMatrimoniali
 * 
 * @property string $code
 * @property string $display
 * 
 * @property \App\Models\UtentiAmministrativi $utenti_amministrativi
 *
 * @package App\Models
 */
class StatiMatrimoniali extends Eloquent
{
	protected $table = 'Stati_matrimoniali';
	protected $primaryKey = 'code';
	public $incrementing = false;
	public $timestamps = false;

	protected $fillable = [
		'display'
	];

	public function utenti_amministrativi()
	{
		return $this->hasOne(\App\Models\UtentiAmministrativi::class, 'Stato_Civile');
	}
}
