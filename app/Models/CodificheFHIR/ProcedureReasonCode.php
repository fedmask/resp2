<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 19 Sep 2018 06:05:03 +0000.
 */

namespace App\Models\CodificheFHIR;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class ProcedureReasonCode
 * 
 * @property string $Code
 * @property string $Text
 * 
 * @property \Illuminate\Database\Eloquent\Collection $tbl_proc_terapeutiches
 *
 * @package App\Models
 */
class ProcedureReasonCode extends Eloquent
{
	protected $table = 'ProcedureReasonCode';
	protected $primaryKey = 'Code';
	public $incrementing = false;
	public $timestamps = false;

	protected $fillable = [
		'Text'
	];

	public function tbl_proc_terapeutiches()
	{
		return $this->hasMany(\App\Models\TblProcTerapeutiche::class, 'reasonCode');
	}
}
