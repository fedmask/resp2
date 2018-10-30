<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 25 Dec 2017 12:47:05 +0000.
 */

namespace App\Models\InvestigationCenter;

use Reliese\Database\Eloquent\Model as Eloquent;
use App\Traits\Encryptable;

/**
 * Class CentriContatti
 * 
 * @property int $id_contatto
 * @property int $id_centro
 * @property int $id_modalita_contatto
 * @property string $contatto_valore
 * 
 * @property \App\Models\CentriIndagini $tbl_centri_indagini
 * @property \App\Models\ModalitaContatti $tbl_modalita_contatti
 *
 * @package App\Models
 */
class CentriContatti extends Eloquent
{
	
	use Encryptable;
	
	protected $table = 'tbl_centri_contatti';
	protected $primaryKey = 'id_contatto';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id_contatto' => 'int',
		'id_centro' => 'int',
		'id_modalita_contatto' => 'int'
	];
	protected $encryptable = ['contatto_valore'];
	protected $fillable = [
		'id_centro',
		'id_modalita_contatto',
		'contatto_valore'
	];

	public function setIDCenter($id){
	    $this->id_centro = $id;
	}
	
	public function setIDModContact($idModContact){
	    $this->id_modalita_contatto = $idModContact;
	}
	    
	public function setValueContact($value){
	    $this->contatto_valore = $value;
	}
	    
	public function tbl_centri_indagini()
	{
		return $this->belongsTo(\App\Models\InvestigationCenter\CentriIndagini::class, 'id_centro');
	}

	public function tbl_modalita_contatti()
	{
		return $this->belongsTo(\App\Models\InvestigationCenter\ModalitaContatti::class, 'id_modalita_contatto');
	}
}
