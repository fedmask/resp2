<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 19 Sep 2018 06:05:02 +0000.
 */

namespace App\Models\CodificheFHIR;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class AllergyIntolleranceReactionSeverity
 * 
 * @property string $Code
 * 
 * @property \App\Models\AllergyIntolleranceReaction $allergy_intollerance_reaction
 *
 * @package App\Models
 */
class AllergyIntolleranceReactionSeverity extends Eloquent
{
	protected $table = 'AllergyIntolleranceReactionSeverity';
	protected $primaryKey = 'Code';
	public $incrementing = false;
	public $timestamps = false;

	public function allergy_intollerance_reaction()
	{
		return $this->hasOne(\App\Models\AllergyIntolleranceReaction::class, 'severity');
	}
}
