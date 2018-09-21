<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 19 Sep 2018 06:05:03 +0000.
 */

namespace App\Models\CodificheFHIR;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class FamilyMemberHistoryConditionOutcome
 * 
 * @property string $Code
 * @property string $Text
 * 
 * @property \Illuminate\Database\Eloquent\Collection $tbl__family_condictions
 *
 * @package App\Models
 */
class FamilyMemberHistoryConditionOutcome extends Eloquent
{
	protected $table = 'FamilyMemberHistoryConditionOutcome';
	protected $primaryKey = 'Code';
	public $incrementing = false;
	public $timestamps = false;

	protected $fillable = [
		'Text'
	];

	public function tbl__family_condictions()
	{
		return $this->hasMany(\App\Models\TblFamilyCondiction::class, 'outCome');
	}
}
