<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 19 Sep 2018 06:05:02 +0000.
 */

namespace App\Models\CodificheFHIR;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class AllergyIntolleranceClinicalStatus
 * 
 * @property string $Code
 * 
 * @property \Illuminate\Database\Eloquent\Collection $allergy_intollerances
 *
 * @package App\Models
 */
class AllergyIntolleranceClinicalStatus extends Eloquent
{
	protected $table = 'AllergyIntolleranceClinicalStatus';
	protected $primaryKey = 'Code';
	public $incrementing = false;
	public $timestamps = false;

	public function allergy_intollerances()
	{
		return $this->hasMany(\App\Models\AllergyIntollerance::class, 'clinicalStatus');
	}
}
