<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 19 Sep 2018 06:05:03 +0000.
 */

namespace App\Models\FHIR;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class ImmunizationProvider
 * 
 * @property string $id_cpp
 * @property string $role
 * 
 * @property \Illuminate\Database\Eloquent\Collection $dispositivo_medicos
 *
 * @package App\Models
 */
class ImmunizationProvider extends Eloquent
{
	protected $table = 'ImmunizationProvider';
	protected $primaryKey = 'id_vaccinazione';
	public $incrementing = false;
	public $timestamps = false;

	protected $fillable = [
	    'id_vaccinazione',
		'id_cpp',
		'role'
	];
}
