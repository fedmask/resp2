<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 25 Dec 2017 12:47:05 +0000.
 */
namespace App\Models\CareProviders;

use Reliese\Database\Eloquent\Model as Eloquent;
use App\Traits\Encryptable;

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
class CppTipologie extends Eloquent {
	use Encryptable;
	protected $table = 'tbl_cpp_tipologie';
	protected $primaryKey = 'id_tipologia';
	public $incrementing = false;
	public $timestamps = false;
	protected $casts = [		// 'id_tipologia' => 'int'
	];
	protected $encryptable = [ 
			'tipologia_nome',
			'tipologia_descrizione' 
	];
	protected $fillable = [ 
			'tipologia_nome',
			'tipologia_descrizione' 
	];
	public function tbl_care_providers() {
		return $this->hasMany ( \App\Models\CareProviders\CareProvider::class, 'id_cpp_tipologia' );
	}
}
