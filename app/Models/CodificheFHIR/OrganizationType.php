<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 19 Sep 2018 06:05:03 +0000.
 */

namespace App\Models\CodificheFHIR;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class OrganizationType
 * 
 * @property string $Code
 * @property string $Text
 * 
 * @property \App\Models\TblCentriTipologie $tbl_centri_tipologie
 *
 * @package App\Models
 */
class OrganizationType extends Eloquent
{
	protected $table = 'OrganizationType';
	protected $primaryKey = 'Code';
	public $incrementing = false;
	public $timestamps = false;

	protected $fillable = [
		'Text'
	];

	public function tbl_centri_tipologie()
	{
		return $this->hasOne(\App\Models\TblCentriTipologie::class, 'code_fhir');
	}
}
