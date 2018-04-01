<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 25 Dec 2017 12:47:05 +0000.
 */

namespace App\Models\Patient;

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
 * @property \App\Models\Pazienti $tbl_pazienti
 * @property \App\Models\TipologieContatti $tbl_tipologie_contatti
 *
 * @package App\Models
 */
class PazientiContatti extends Eloquent
{
	protected $table = 'tbl_pazienti_contatti';
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
	
	public function getPhoneType(){
	    return $this->contacts_type()->first()->get_phone_type();
	}
	
	
	public function getTypeContact(){
	    return $this->contacts_type()->first()->tipologia_nome;
	}
	
	public function getCount(){
	    return $this::count();
	}

	public function tbl_pazienti()
	{
		return $this->belongsTo(\App\Models\Patient\Pazienti::class, 'id_paziente');
	}

	public function contacts_type()
	{
		return $this->belongsTo(\App\Models\TipologieContatti::class, 'id_contatto_tipologia');
	}
	
	/** FHIR **/
	
	public function getPhone(){
	    return $this->contatto_telefono;
	}
	
	public function getFullName(){
	    return $this->contatto_nominativo;
	}
}
