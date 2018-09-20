<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 19 Sep 2018 06:05:02 +0000.
 */

namespace App\Models\CodificheFHIR;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class AllergyIntolleranceCode
 * 
 * @property string $Code
 * @property string $Text
 * 
 * @property \Illuminate\Database\Eloquent\Collection $allergy_intollerances
 *
 * @package App\Models
 */
class AllergyIntolleranceCode extends Eloquent
{
	protected $table = 'AllergyIntolleranceCode';
	protected $primaryKey = 'Code';
	public $incrementing = false;
	public $timestamps = false;

	protected $fillable = [
		'Text'
	];

	public function allergy_intollerances()
	{
		return $this->hasMany(\App\Models\AllergyIntollerance::class, 'code');
	}
}
