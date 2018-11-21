<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 25 Dec 2017 12:47:05 +0000.
 */

namespace App\Models\InvestigationCenter;

use Reliese\Database\Eloquent\Model as Eloquent;
use App\Traits\Encryptable;
/**
 * Class ModalitaContatti
 * 
 * @property int $id_modalita
 * @property string $modalita_nome
 * 
 * @property \Illuminate\Database\Eloquent\Collection $tbl_centri_contattis
 *
 * @package App\Models
 */
class ModalitaContatti extends Eloquent
{
	
	
	use Encryptable;
	
	protected $table = 'tbl_modalita_contatti';
	protected $primaryKey = 'id_modalita';
	public $timestamps = false;
	
	public static $PHONE_TYPE = 1;
	public static $EMAIL_TYPE = 2;
	
	protected $fillable = [
		'modalita_nome'
	];

	
	protected $encryptable = ['modalita_nome'];
	
	public function tbl_centri_contattis()
	{
		return $this->hasMany(\App\Models\InvestigationCenter\CentriContatti::class, 'id_modalita_contatto');
	}
}
