<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 25 Dec 2017 12:47:05 +0000.
 */

namespace App\Models\Log;

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
		return $this->hasMany(\App\Models\Log\OperazioniLog::class, 'operazione_codice');
	}
}
