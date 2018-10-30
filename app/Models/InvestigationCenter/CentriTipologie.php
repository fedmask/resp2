<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 25 Dec 2017 12:47:05 +0000.
 */

namespace App\Models\InvestigationCenter;

use Reliese\Database\Eloquent\Model as Eloquent;
use App\Traits\Encryptable;

/**
 * Class CentriTipologie
 * 
 * @property int $id_centro_tipologia
 * @property string $tipologia_nome
 * 
 * @property \Illuminate\Database\Eloquent\Collection $tbl_centri_indaginis
 *
 * @package App\Models
 */
class CentriTipologie extends Eloquent
{
	
	
	use Encryptable;
	
	protected $table = 'tbl_centri_tipologie';
	protected $primaryKey = 'id_centro_tipologia';
	public $timestamps = false;

	protected $fillable = [
		'tipologia_nome'
	];
	protected $encryptable = ['tipologia_nome'];
	
	public function getID(){
	    return $this->$primaryKey;
	}
	
	public function getName(){
	    return $this->tipologia_nome;
	}

	public function tbl_centri_indaginis()
	{
		return $this->hasMany(\App\Models\InvestigationCenter\CentriIndagini::class, 'id_tipologia');
	}
}
