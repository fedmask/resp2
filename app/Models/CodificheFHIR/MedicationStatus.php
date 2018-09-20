<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 19 Sep 2018 06:05:03 +0000.
 */

namespace App\Models\CodificheFHIR;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class MedicationStatus
 * 
 * @property string $Code
 * 
 * @property \App\Models\FarmaciAssunti $farmaci_assunti
 *
 * @package App\Models
 */
class MedicationStatus extends Eloquent
{
	protected $table = 'MedicationStatus';
	protected $primaryKey = 'Code';
	public $incrementing = false;
	public $timestamps = false;

	public function farmaci_assunti()
	{
		return $this->hasOne(\App\Models\FarmaciAssunti::class, 'status');
	}
}
