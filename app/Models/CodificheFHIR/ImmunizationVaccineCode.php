<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 19 Sep 2018 06:05:03 +0000.
 */

namespace App\Models\CodificheFHIR;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class ImmunizationVaccineCode
 * 
 * @property string $Code
 * @property string $Text
 * 
 * @property \Illuminate\Database\Eloquent\Collection $tbl_vaccinaziones
 *
 * @package App\Models
 */
class ImmunizationVaccineCode extends Eloquent
{
	protected $table = 'ImmunizationVaccineCode';
	protected $primaryKey = 'Code';
	public $incrementing = false;
	public $timestamps = false;

	protected $fillable = [
		'Text'
	];

	public function tbl_vaccinaziones()
	{
		return $this->hasMany(\App\Models\TblVaccinazione::class, 'vaccineCode');
	}
}
