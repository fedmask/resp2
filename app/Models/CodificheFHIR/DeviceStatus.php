<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 19 Sep 2018 06:05:03 +0000.
 */

namespace App\Models\CodificheFHIR;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class DeviceStatus
 * 
 * @property string $Code
 * 
 * @property \Illuminate\Database\Eloquent\Collection $dispositivo_impiantabiles
 *
 * @package App\Models
 */
class DeviceStatus extends Eloquent
{
	protected $table = 'DeviceStatus';
	protected $primaryKey = 'Code';
	public $incrementing = false;
	public $timestamps = false;

	public function dispositivo_impiantabiles()
	{
		return $this->hasMany(\App\Models\DispositivoImpiantabile::class, 'stato');
	}
}
