<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 19 Sep 2018 06:05:03 +0000.
 */

namespace App\Models\CodificheFHIR;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class DeviceType
 * 
 * @property string $Code
 * @property string $Text
 * 
 * @property \Illuminate\Database\Eloquent\Collection $dispositivo_medicos
 *
 * @package App\Models
 */
class DeviceType extends Eloquent
{
	protected $table = 'DeviceType';
	protected $primaryKey = 'Code';
	public $incrementing = false;
	public $timestamps = false;

	protected $fillable = [
		'Text'
	];

	public function dispositivo_medicos()
	{
		return $this->hasMany(\App\Models\DispositivoMedico::class, 'tipologia');
	}
}
