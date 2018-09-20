<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 19 Sep 2018 06:05:03 +0000.
 */

namespace App\Models\CodificheFHIR;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class MedicationForm
 * 
 * @property string $Code
 * @property string $Text
 * 
 * @property \App\Models\FarmaciAssunti $farmaci_assunti
 *
 * @package App\Models
 */
class MedicationForm extends Eloquent
{
	protected $table = 'MedicationForm';
	protected $primaryKey = 'Code';
	public $incrementing = false;
	public $timestamps = false;

	protected $fillable = [
		'Text'
	];

	public function farmaci_assunti()
	{
		return $this->hasOne(\App\Models\FarmaciAssunti::class, 'form');
	}
}
