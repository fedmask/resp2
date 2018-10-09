<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 19 Sep 2018 06:05:03 +0000.
 */

namespace App\Models\FHIR;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Contatto
 * 
 * @property int $id_contatto
 * @property int $id_paziente
 * @property bool $attivo
 * @property string $tipo
 * @property string $nome
 * @property string $cognome
 * @property string $sesso
 * @property string $indirizzo_residenza
 * @property string $telefono
 * @property string $mail
 * @property \Carbon\Carbon $data_nascita
 * @property \Carbon\Carbon $data_inizio
 * @property \Carbon\Carbon $data_fine
 * 
 * @property \App\Models\Gender $gender
 * @property \App\Models\TipoContatto $tipo_contatto
 * @property \App\Models\VisitaContatto $visita_contatto
 *
 * @package App\Models
 */
class Contatto extends Eloquent
{
	protected $table = 'Contatto';
	protected $primaryKey = 'id_contatto';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id_paziente' => 'int',
		'id_contatto' => 'int',
		'attivo' => 'bool'
	];

	protected $dates = [
		'data_nascita',
		'data_inizio',
		'data_fine'
	];

	protected $fillable = [
		'attivo',
		'relazione',
		'nome',
		'cognome',
		'sesso',
		'telefono',
		'mail',
		'data_nascita',
		'data_inizio',
		'data_fine'
	];

	public function gender()
	{
		return $this->belongsTo(\App\Models\Gender::class, 'sesso');
	}

	public function tipo_contatto()
	{
		return $this->belongsTo(\App\Models\TipoContatto::class, 'tipo');
	}

	public function visita_contatto()
	{
		return $this->hasOne(\App\Models\VisitaContatto::class, 'id_contatto');
	}

		public function tbl_pazienti()
	{
		return $this->belongsTo(\App\Models\Patient\Pazienti::class, 'id_paziente');
	}
}
