<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 19 Sep 2018 06:05:03 +0000.
 */

namespace App\Models\CodificheFHIR;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Gender
 * 
 * @property string $Code
 * 
 * @property \Illuminate\Database\Eloquent\Collection $contattos
 * @property \Illuminate\Database\Eloquent\Collection $tbl_care_providers
 * @property \Illuminate\Database\Eloquent\Collection $tbl_pazientis
 *
 * @package App\Models
 */
class Gender extends Eloquent
{
	protected $table = 'Gender';
	protected $primaryKey = 'Code';
	public $incrementing = false;
	public $timestamps = false;

	public function contattos()
	{
		return $this->hasMany(\App\Models\Contatto::class, 'sesso');
	}

	public function tbl_care_providers()
	{
		return $this->hasMany(\App\Models\TblCareProvider::class, 'cpp_sesso');
	}

	public function tbl_pazientis()
	{
		return $this->hasMany(\App\Models\TblPazienti::class, 'paziente_sesso');
	}
}
