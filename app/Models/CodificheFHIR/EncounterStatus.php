<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 19 Sep 2018 06:05:03 +0000.
 */

namespace App\Models\CodificheFHIR;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class EncounterStatus
 * 
 * @property string $Code
 * @property string $Display
 * 
 * @property \App\Models\Esito $esito
 *
 * @package App\Models
 */
class EncounterStatus extends Eloquent
{
	protected $table = 'EncounterStatus';
	protected $primaryKey = 'Code';
	public $incrementing = false;
	public $timestamps = false;

	protected $fillable = [
		'Display'
	];
}
