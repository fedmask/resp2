<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 25 Dec 2017 12:47:05 +0000.
 */

namespace App\Models\History;

use Reliese\Database\Eloquent\Model as Eloquent;
use App\Traits\Encryptable;
/**
 * Class AnamnesiPtProssima
 * 
 * @property int $id_anamnesi_prossima
 * @property int $id_paziente
 * @property int $id_anamnesi_log
 * @property string $anamnesi_prossima_contenuto
 *
 * @package App\Models
 */
class AnamnesiPtProssima extends Eloquent
{
	
	use Encryptable;
	
	protected $table = 'tbl_anamnesi_pt_prossima';
	protected $primaryKey = 'id_paziente';
	public $timestamps = false;

	protected $casts = [
		'id_paziente' => 'int',
		'id_anamnesi_log' => 'int',
        'icd9_group_code' => 'string'
	];
	
	protected $encryptable = ['anamnesi_prossima_contenuto'];

	protected $fillable = [
		'id_paziente',
		'id_anamnesi_log',
		'anamnesi_prossima_contenuto',
        'icd9_group_code'
	];
}
