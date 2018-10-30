<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 25 Dec 2017 12:47:05 +0000.
 */

namespace App\Models\History;

use Reliese\Database\Eloquent\Model as Eloquent;
use App\Traits\Encryptable;
/**
 * Class AnamnesiPtRemotum
 * 
 * @property int $id_anamnesi_remota
 * @property int $id_paziente
 * @property int $id_anamnesi_log
 * @property string $anamnesi_remota_contenuto
 *
 * @package App\Models
 */
class AnamnesiPtRemotum extends Eloquent
{
	
	
	
	use Encryptable;
	
	protected $primaryKey = 'id_anamnesi_remota';
	public $timestamps = false;

	protected $casts = [
		'id_paziente' => 'int',
		'id_anamnesi_log' => 'int'
	];
	
	
	protected $encryptable = ['anamnesi_remota_contenuto'];

	protected $fillable = [
		'id_paziente',
		'id_anamnesi_log',
		'anamnesi_remota_contenuto'
	];
}
