<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 23 Dec 2017 16:46:47 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class CppTipologie
 * 
 * @property int $id_tipologia
 * @property string $tipologia_nome
 * 
 * @property \Illuminate\Database\Eloquent\Collection $tbl_care_providers
 *
 * @package App\Models
 */
class CppTipologie extends Eloquent
{
	protected $table = 'tbl_cpp_tipologie';
	protected $primaryKey = 'id_tipologia';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id_tipologia' => 'int'
	];

	protected $fillable = [
		'tipologia_nome'
	];

	public function tbl_care_providers()
	{
		return $this->hasMany(\App\Models\TblCareProvider::class, 'id_cpp_tipologia');
	}
}
