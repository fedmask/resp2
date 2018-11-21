<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 25 Dec 2017 12:47:05 +0000.
 */
namespace App\Models\CareProviders;

use Reliese\Database\Eloquent\Model as Eloquent;
use App\Traits\Encryptable;

/**
 * Class CppPersona
 *
 * @property int $id_persona
 * @property int $id_utente
 * @property int $id_comune
 * @property string $persona_nome
 * @property string $persona_cognome
 * @property string $persona_telefono
 * @property string $persona_fax
 * @property string $persona_reperibilita
 * @property bool $persona_attivo
 *
 * @property \App\Models\Comuni $tbl_comuni
 * @property \App\Models\Utenti $tbl_utenti
 * @property \Illuminate\Database\Eloquent\Collection $tbl_centri_indaginis
 *
 * @package App\Models
 */
class CppPersona extends Eloquent {
	
	protected $table = 'tbl_cpp_persona';
	protected $primaryKey = 'id_persona';
	public $incrementing = false;
	public $timestamps = false;
	use Encryptable;
	protected $casts = [ 
			'id_persona' => 'int',
			'id_utente' => 'int',
			'id_comune' => 'int',
			'persona_attivo' => 'bool' 
	];
	protected $encryptable = [ 
			'persona_nome',
			'persona_cognome',
			'persona_telefono',
		
			
			 
	];
	protected $fillable = [ 
			'id_utente',
			'id_comune',
			'persona_nome',
			'persona_cognome',
			'persona_telefono',
			'persona_fax',
			'persona_reperibilita',
			'persona_attivo' 
	];
	public function tbl_comuni() {
		return $this->belongsTo ( \App\Models\Domicile\Comuni::class, 'id_comune' );
	}
	public function tbl_utenti() {
		return $this->belongsTo ( \App\Models\CurrentUser\User::class, 'id_utente' );
	}
	public function tbl_centri_indaginis() {
		return $this->hasMany ( \App\Models\InvestigationCenter\CentriIndagini::class, 'id_ccp_persona' );
	}
}
