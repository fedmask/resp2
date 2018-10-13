<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 19 Sep 2018 06:05:03 +0000.
 */

namespace App\Models\CodificheFHIR;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class EncounterParticipant
 * 
 * @package App\Models
 */
class EncounterParticipant extends Eloquent
{
	protected $table = 'EncounterParticipant';
	protected $primaryKey = 'id_visita';
	public $incrementing = false;
	public $timestamps = false;


protected $casts = [
		'id_visita' => 'int',
		'individual' => 'int'
	];

	protected $dates = [
		'start_period',
	    'end_period'
	];


	protected $fillable = [
		'id_visita',
		'individual',
		'type',
		'start_period',
		'end_period'
	];
}
