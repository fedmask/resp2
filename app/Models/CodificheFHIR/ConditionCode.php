<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 19 Sep 2018 06:05:02 +0000.
 */

namespace App\Models\CodificheFHIR;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class ConditionCode
 * 
 * @property string $Code
 * @property string $Text
 * 
 * @property \Illuminate\Database\Eloquent\Collection $tbl__family_condictions
 * @property \Illuminate\Database\Eloquent\Collection $tbl_diagnosis
 *
 * @package App\Models
 */
class ConditionCode extends Eloquent
{
	protected $table = 'ConditionCode';
	protected $primaryKey = 'Code';
	public $incrementing = false;
	public $timestamps = false;

	protected $fillable = [
		'Text'
	];

	public function tbl__family_condictions()
	{
		return $this->hasMany(\App\Models\TblFamilyCondiction::class, 'code_fhir');
	}

	public function tbl_diagnosis()
	{
		return $this->hasMany(\App\Models\TblDiagnosi::class, 'code');
	}
}
