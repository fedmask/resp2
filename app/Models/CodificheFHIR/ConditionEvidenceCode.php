<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 19 Sep 2018 06:05:02 +0000.
 */

namespace App\Models\CodificheFHIR;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class ConditionEvidenceCode
 * 
 * @property string $Code
 * @property string $Text
 * 
 * @property \Illuminate\Database\Eloquent\Collection $tbl_diagnosis
 *
 * @package App\Models
 */
class ConditionEvidenceCode extends Eloquent
{
	protected $table = 'ConditionEvidenceCode';
	protected $primaryKey = 'Code';
	public $incrementing = false;
	public $timestamps = false;

	protected $fillable = [
		'Text'
	];

	public function tbl_diagnosis()
	{
		return $this->hasMany(\App\Models\TblDiagnosi::class, 'evidenceCode');
	}
}
