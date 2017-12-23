<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 23 Dec 2017 16:46:47 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class AccessiLog
 * 
 * @property string $accesso_ip
 * @property bool $accesso_contatore
 * @property \Carbon\Carbon $accesso_data
 *
 * @package App\Models
 */
class AccessiLog extends Eloquent
{
	protected $table = 'tbl_accessi_log';
	protected $primaryKey = 'accesso_ip';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'accesso_contatore' => 'bool'
	];

	protected $dates = [
		'accesso_data'
	];

	protected $fillable = [
		'accesso_contatore',
		'accesso_data'
	];
}
