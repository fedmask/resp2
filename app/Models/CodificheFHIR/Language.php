<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 19 Sep 2018 06:05:03 +0000.
 */

namespace App\Models\CodificheFHIR;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Language
 * 
 * @property string $Code
 * @property string $Display
 * 
 * @property \Illuminate\Database\Eloquent\Collection $tbl_care_providers
 * @property \Illuminate\Database\Eloquent\Collection $tbl_pazientis
 *
 * @package App\Models
 */
class Language extends Eloquent
{
    protected $table = 'Languages';
	protected $primaryKey = 'Code';
	public $incrementing = false;
	public $timestamps = false;

	protected $fillable = [
		'Display'
	];

	public function tbl_care_providers()
	{
		return $this->hasMany(\App\Models\TblCareProvider::class, 'cpp_lingua');
	}

	public function tbl_pazientis()
	{
		return $this->hasMany(\App\Models\TblPazienti::class, 'paziente_lingua');
	}
	
	public function getCode() {
	    return $this->Code;
	}
	
	public function getDisplay() {
	    return $this->Display;
	}
}
