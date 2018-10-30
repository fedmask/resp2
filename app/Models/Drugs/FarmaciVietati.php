<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 25 Dec 2017 12:47:05 +0000.
 */
namespace App\Models\Drugs;

use Reliese\Database\Eloquent\Model as Eloquent;
use App\Traits\Encryptable;

/**
 * Class FarmaciVietati
 *
 * @property int $id_farmaco_vietato
 * @property int $id_paziente
 * @property string $id_farmaco
 * @property string $farmaco_vietato_motivazione
 * @property int $farmaco_vietato_confidenzialita
 *
 * @property \App\Models\Farmaci $tbl_farmaci
 * @property \App\Models\LivelliConfidenzialita $tbl_livelli_confidenzialitum
 * @property \App\Models\Pazienti $tbl_pazienti
 *
 * @package App\Models
 */
class FarmaciVietati extends Eloquent {
	use Encryptable;
	protected $table = 'tbl_farmaci_vietati';
	protected $primaryKey = 'id_farmaco_vietato';
	public $timestamps = false;
	protected $casts = [ 
			'id_paziente' => 'int',
			'farmaco_vietato_confidenzialita' => 'int' 
	];
	protected $encryptable = [ 
			'farmaco_vietato_motivazione'
	];
	protected $fillable = [ 
			'id_paziente',
			'id_farmaco',
			'farmaco_vietato_motivazione',
			'farmaco_vietato_confidenzialita' 
	];
	public function tbl_farmaci() {
		return $this->belongsTo ( \App\Models\Drugs\Farmaci::class, 'id_farmaco' );
	}
	public function tbl_livelli_confidenzialitum() {
		return $this->belongsTo ( \App\Models\LivelliConfidenzialita::class, 'farmaco_vietato_confidenzialita' );
	}
	public function tbl_pazienti() {
		return $this->belongsTo ( \App\Models\Patient\Pazienti::class, 'id_paziente' );
	}
}
