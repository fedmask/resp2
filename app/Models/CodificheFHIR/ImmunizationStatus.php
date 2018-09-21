<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 19 Sep 2018 06:05:03 +0000.
 */

namespace App\Models\CodificheFHIR;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class ImmunizationStatus
 * 
 * @property string $Code
 * 
 * @property \Illuminate\Database\Eloquent\Collection $tbl_vaccinaziones
 *
 * @package App\Models
 */
class ImmunizationStatus extends Eloquent
{
	protected $table = 'ImmunizationStatus';
	protected $primaryKey = 'Code';
	public $incrementing = false;
	public $timestamps = false;

	public function tbl_vaccinaziones()
	{
		return $this->hasMany(\App\Models\TblVaccinazione::class, 'vaccinazione_stato');
	}
}
