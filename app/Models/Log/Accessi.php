<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 25 Dec 2017 12:47:05 +0000.
 */

namespace App\Models\Log;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Accessi
 * 
 * @property string $ip
 * @property int $accesso_contatore
 * @property \Carbon\Carbon $accesso_data
 *
 * @package App\Models
 */
class Accessi extends Eloquent
{
	protected $table = 'tbl_accessi';
	protected $primaryKey = 'ip';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'accesso_contatore' => 'int'
	];

	protected $dates = [
		'accesso_data'
	];

	protected $fillable = [
		'accesso_contatore',
		'accesso_data'
	];
}
