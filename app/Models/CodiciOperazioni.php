<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 23 Dec 2017 16:46:47 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class CodiciOperazioni
 * 
 * @property string $id_codice
 * @property string $codice_descrizione
 * 
 * @property \Illuminate\Database\Eloquent\Collection $tbl_operazioni_logs
 *
 * @package App\Models
 */
class CodiciOperazioni extends Eloquent
{
	protected $table = 'tbl_codici_operazioni';
	protected $primaryKey = 'id_codice';
	public $incrementing = false;
	public $timestamps = false;

	protected $fillable = [
		'codice_descrizione'
	];

	public function tbl_operazioni_logs()
	{
		return $this->hasMany(\App\Models\OperazioniLog::class, 'operazione_codice');
	}
}
