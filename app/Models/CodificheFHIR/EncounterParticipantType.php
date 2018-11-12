<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 19 Sep 2018 06:05:03 +0000.
 */

namespace App\Models\CodificheFHIR;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class EncounterParticipantType
 * 
 * @property string $Code
 * @property string $Text
 * 
 * @property \App\Models\VisitaCP $visita_c_p
 * @property \App\Models\VisitaContatto $visita_contatto
 *
 * @package App\Models
 */
class EncounterParticipantType extends Eloquent
{
	protected $table = 'EncounterParticipantType';
	protected $primaryKey = 'Code';
	public $incrementing = false;
	public $timestamps = false;

	protected $fillable = [
		'Display'
	];

	public function visita_c_p()
	{
		return $this->hasOne(\App\Models\VisitaCP::class, 'tipo');
	}

	public function visita_contatto()
	{
		return $this->hasOne(\App\Models\VisitaContatto::class, 'tipo');
	}
}
