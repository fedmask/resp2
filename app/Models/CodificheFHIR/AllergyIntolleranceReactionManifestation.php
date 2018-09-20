<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 19 Sep 2018 06:05:02 +0000.
 */

namespace App\Models\CodificheFHIR;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class AllergyIntolleranceReactionManifestation
 * 
 * @property string $Code
 * @property string $Text
 * 
 * @property \App\Models\AllergyIntolleranceReaction $allergy_intollerance_reaction
 *
 * @package App\Models
 */
class AllergyIntolleranceReactionManifestation extends Eloquent
{
	protected $table = 'AllergyIntolleranceReactionManifestation';
	protected $primaryKey = 'Code';
	public $incrementing = false;
	public $timestamps = false;

	protected $fillable = [
		'Text'
	];

	public function allergy_intollerance_reaction()
	{
		return $this->hasOne(\App\Models\AllergyIntolleranceReaction::class, 'manifestation');
	}
}
