<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 19 Sep 2018 06:05:02 +0000.
 */

namespace App\Models\CodificheFHIR;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class ConditionClinicalStatus
 * 
 * @property string $Code
 * 
 * @property \Illuminate\Database\Eloquent\Collection $tbl_diagnosis
 *
 * @package App\Models
 */
class ConditionClinicalStatus extends Eloquent
{
	protected $table = 'ConditionClinicalStatus';
	protected $primaryKey = 'Code';
	public $incrementing = false;
	public $timestamps = false;

	public function tbl_diagnosis()
	{
		return $this->hasMany(\App\Models\TblDiagnosi::class, 'diagnosi_stato');
	}
}
