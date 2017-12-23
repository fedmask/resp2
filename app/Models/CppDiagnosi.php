<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 23 Dec 2017 16:46:47 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class CppDiagnosi
 * 
 * @property int $id_diagnosi
 * @property string $diagnosi_stato
 * @property int $id_cpp
 * @property string $careprovider
 * 
 * @property \App\Models\TblCareProvider $tbl_care_provider
 * @property \App\Models\TblDiagnosi $tbl_diagnosi
 *
 * @package App\Models
 */
class CppDiagnosi extends Eloquent
{
	protected $table = 'tbl_cpp_diagnosi';
	protected $primaryKey = 'id_diagnosi';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id_diagnosi' => 'int',
		'id_cpp' => 'int'
	];

	protected $fillable = [
		'diagnosi_stato',
		'id_cpp',
		'careprovider'
	];

	public function tbl_care_provider()
	{
		return $this->belongsTo(\App\Models\TblCareProvider::class, 'id_cpp');
	}

	public function tbl_diagnosi()
	{
		return $this->belongsTo(\App\Models\TblDiagnosi::class, 'id_diagnosi');
	}
}
