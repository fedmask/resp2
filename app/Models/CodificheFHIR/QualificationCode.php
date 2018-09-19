<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 19 Sep 2018 06:05:03 +0000.
 */

namespace App\Models\CodificheFHIR;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class QualificationCode
 * 
 * @property string $Code
 * @property string $Display
 * 
 * @property \App\Models\CppQualification $cpp_qualification
 *
 * @package App\Models
 */
class QualificationCode extends Eloquent
{
	protected $table = 'QualificationCode';
	protected $primaryKey = 'Code';
	public $incrementing = false;
	public $timestamps = false;

	protected $fillable = [
		'Display'
	];

	public function cpp_qualification()
	{
		return $this->hasOne(\App\Models\CppQualification::class, 'Code');
	}
}
