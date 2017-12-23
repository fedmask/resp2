<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 23 Dec 2017 16:46:47 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class PazientiContatti
 * 
 * @property int $id_paziente
 * @property int $id_comune_residenza
 * @property int $id_comune_nascita
 * @property string $paziente_telefono
 * @property string $paziente_indirizzo
 * 
 * @property \App\Models\TblComuni $tbl_comuni
 * @property \Illuminate\Database\Eloquent\Collection $tbl_pazientis
 *
 * @package App\Models
 */
class PazientiContatti extends Eloquent
{
	protected $table = 'tbl_pazienti_contatti';
	protected $primaryKey = 'id_paziente';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id_paziente' => 'int',
		'id_comune_residenza' => 'int',
		'id_comune_nascita' => 'int'
	];

	protected $fillable = [
		'id_comune_residenza',
		'id_comune_nascita',
		'paziente_telefono',
		'paziente_indirizzo'
	];

	public function tbl_comuni()
	{
		return $this->belongsTo(\App\Models\TblComuni::class, 'id_comune_residenza');
	}

	public function tbl_pazientis()
	{
		return $this->hasMany(\App\Models\TblPazienti::class, 'id_paziente_contatti');
	}
}
