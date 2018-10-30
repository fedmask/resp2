<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 25 Dec 2017 12:47:05 +0000.
 */
namespace App\Models\CareProviders;

use Reliese\Database\Eloquent\Model as Eloquent;
use App\Traits\Encryptable;

/**
 * Class CppPaziente
 *
 * @property int $id_cpp
 * @property int $id_paziente
 * @property int $assegnazione_confidenzialita
 *
 * @property \App\Models\LivelliConfidenzialita $tbl_livelli_confidenzialitum
 * @property \App\Models\TblCareProvider $tbl_care_provider
 * @property \App\Models\Pazienti $tbl_pazienti
 *
 * @package App\Models
 */
class CppPaziente extends Eloquent {
	protected $table = 'tbl_cpp_paziente';
	public $incrementing = false;
	public $timestamps = false;
	use Encryptable;
	protected $casts = [ 
			'id_cpp' => 'int',
			'id_paziente' => 'int',
			'assegnazione_confidenzialita' => 'int' 
	];
	protected $encryptable = [ 
	];
	protected $fillable = [ 
			'assegnazione_confidenzialita' 
	];
	public function tbl_livelli_confidenzialitum() {
		return $this->belongsTo ( \App\Models\LivelliConfidenzialita::class, 'assegnazione_confidenzialita' );
	}
	public function tbl_care_provider() {
		return $this->belongsTo ( \App\Models\CareProviders\CareProvider::class, 'id_cpp' );
	}
	public function tbl_pazienti() {
		return $this->belongsTo ( \App\Models\Patient\Pazienti::class, 'id_paziente' );
	}
}
