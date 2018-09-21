<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 19 Sep 2018 06:05:03 +0000.
 */

namespace App\Models\CodificheFHIR;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class MedicationCode
 * 
 * @property string $Code
 * @property string $Text
 * 
 * @property \App\Models\FarmaciAssunti $farmaci_assunti
 *
 * @package App\Models
 */
class MedicationCode extends Eloquent
{
	protected $table = 'MedicationCode';
	protected $primaryKey = 'Code';
	public $incrementing = false;
	public $timestamps = false;

	protected $fillable = [
		'Text'
	];

	public function farmaci_assunti()
	{
		return $this->hasOne(\App\Models\FarmaciAssunti::class, 'id_farmaco');
	}
}
