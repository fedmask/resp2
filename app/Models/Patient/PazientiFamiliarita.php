<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 25 Dec 2017 12:47:05 +0000.
 */
namespace App\Models\Patient;

use App\Models\CodificheFHIR\RelationshipType;
use Reliese\Database\Eloquent\Model as Eloquent;
use App\Traits\Encryptable;

/**
 * Class PazientiFamiliarita
 *
 * @property int $id_familiarita
 * @property int $id_paziente
 * @property int $id_parente
 * @property string $familiarita_grado_parentela
 * @property \Carbon\Carbon $familiarita_aggiornamento_data
 * @property bool $familiarita_conferma
 *
 * @property \App\Models\Pazienti $tbl_pazienti
 * @property \App\Models\Utenti $tbl_utenti
 * @property \App\Models\FamiliaritaDecessi $tbl_familiarita_decessi
 *
 * @package App\Models
 */

class PazientiFamiliarita extends Eloquent
{   
    protected $table = 'tbl_pazienti_familiarita';

	
	use Encryptable;

	protected $primaryKey = 'id_familiarita';
	public $incrementing = false;
	public $timestamps = false;
	protected $casts = [ 
			'id_familiarita' => 'int',
			'id_paziente' => 'int',
			'id_parente' => 'int',
			'familiarita_conferma' => 'bool' 
	];
	protected $dates = [ 
			'familiarita_aggiornamento_data' 
	];


	protected $fillable = [
		'id_paziente',
		'id_parente',
	    'relazione',
		'familiarita_grado_parentela',
		'familiarita_aggiornamento_data',
		'familiarita_conferma'
];
	protected $encryptable = [ 
			'familiarita_grado_parentela',

	];

	public function tbl_pazienti() {
		return $this->belongsTo ( \App\Models\Patient\Pazienti::class, 'id_paziente' );
	}
	public function tbl_utenti() {
		return $this->belongsTo ( \App\Models\CurrentUser\User::class, 'id_parente' );
	}
	public function tbl_familiarita_decessi() {
		return $this->hasOne ( \App\Models\Patient\FamiliaritaDecessi::class, 'id_paziente' );
	}
	
	public function getIdPaziente(){
	    return $this->id_paziente;
	}
	
	public function getRelazione(){
	    $rel = RelationshipType::where('Code', $this->relazione)->first();
	    return $rel->Display;
	}
}
