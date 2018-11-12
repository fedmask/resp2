<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 19 Sep 2018 06:05:03 +0000.
 */

namespace App\Models\CodificheFHIR;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class FamilyMemberHistoryStatus
 * 
 * @property string $Code
 * @property string $Text
 * 
 * @property \Illuminate\Database\Eloquent\Collection $tbl__family_condictions
 *
 * @package App\Models
 */
class FamilyMemberHistoryStatus extends Eloquent
{
	protected $table = 'FamilyMemberHistoryStatus';
	protected $primaryKey = 'Code';
	public $incrementing = false;
	public $timestamps = false;

	protected $fillable = [
		'Display'
	];

}
