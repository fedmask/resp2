<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 25 Dec 2017 12:47:05 +0000.
 */
namespace App\Models\CurrentUser;

use Reliese\Database\Eloquent\Model as Eloquent;
use App\Traits\Encryptable;

/**
 * Class Recapiti
 *
 * @property int $id_contatto
 * @property int $id_utente
 * @property int $id_comune_residenza
 * @property int $id_comune_nascita
 * @property string $contatto_telefono
 * @property string $contatto_indirizzo
 *
 * @property \App\Models\Comuni $tbl_comuni
 * @property \App\Models\Utenti $tbl_utenti
 *
 * @package App\Models
 */
class Recapiti extends Eloquent {
	

	use Encryptable;
	
	protected $table = 'tbl_recapiti';
	protected $primaryKey = 'id_contatto';
	public $incrementing = false;
	public $timestamps = false;
	protected $casts = [ 
			'id_contatto' => 'int',
			'id_utente' => 'int',
			'id_comune_residenza' => 'int',
			'id_comune_nascita' => 'int' 
	];
	protected $encryptable = [ 
			'contatto_telefono',
			'contatto_indirizzo' 
	];
	protected $fillable = [ 
			'id_utente',
			'id_contatto',
			'id_comune_residenza',
			'id_comune_nascita',
			'contatto_telefono',
			'contatto_indirizzo' 
	];
	public function town() {
		return $this->belongsTo ( \App\Models\Domicile\Comuni::class, 'id_comune_nascita' );
	}
	public function utente() {
		return $this->belongsTo ( \App\Models\CurrentUser\User::class, 'id_utente' );
	}
}
