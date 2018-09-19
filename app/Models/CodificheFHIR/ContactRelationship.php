<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 19 Sep 2018 06:05:03 +0000.
 */

namespace App\Models\CodificheFHIR;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class ContactRelationship
 * 
 * @property string $Code
 * @property string $Display
 * 
 * @property \Illuminate\Database\Eloquent\Collection $patient_contacts
 *
 * @package App\Models
 */
class ContactRelationship extends Eloquent
{
	protected $table = 'ContactRelationship';
	protected $primaryKey = 'Code';
	public $incrementing = false;
	public $timestamps = false;

	protected $fillable = [
		'Display'
	];

	public function patient_contacts()
	{
		return $this->hasMany(\App\Models\PatientContact::class, 'Relationship');
	}
}
