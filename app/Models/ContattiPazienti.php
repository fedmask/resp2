<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 23 Dec 2017 16:46:47 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class ContattiPazienti
 * 
 * @property int $id_contatto
 * @property int $id_paziente
 * @property int $id_contatto_tipologia
 * @property string $contatto_nominativo
 * @property string $contatto_telefono
 * 
 * @property \App\Models\TblPazienti $tbl_pazienti
 * @property \App\Models\TblTipologieContatti $tbl_tipologie_contatti
 *
 * @package App\Models
 */
class ContattiPazienti extends Eloquent
{
	protected $table = 'tbl_contatti_pazienti';
	protected $primaryKey = 'id_contatto';
	public $timestamps = false;

	protected $casts = [
		'id_paziente' => 'int',
		'id_contatto_tipologia' => 'int'
	];

	protected $fillable = [
		'id_paziente',
		'id_contatto_tipologia',
		'contatto_nominativo',
		'contatto_telefono'
	];

	public function tbl_pazienti()
	{
		return $this->belongsTo(\App\Models\TblPazienti::class, 'id_paziente');
	}

	public function tbl_tipologie_contatti()
	{
		return $this->belongsTo(\App\Models\TblTipologieContatti::class, 'id_contatto_tipologia');
	}
}
