<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 19 Sep 2018 06:05:03 +0000.
 */

namespace App\Models\CodificheFHIR;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class ObservationInterpretation
 * 
 * @property string $Code
 * @property string $Display
 * 
 * @property \Illuminate\Database\Eloquent\Collection $dispositivo_medicos
 *
 * @package App\Models
 */
class ObservationInterpretation extends Eloquent
{
	protected $table = 'ObservationInterpretation';
	protected $primaryKey = 'Code';
	public $incrementing = false;
	public $timestamps = false;

	protected $fillable = [
		'Display'
	];
}
