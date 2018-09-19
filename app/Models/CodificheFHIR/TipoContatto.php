<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 19 Sep 2018 06:05:03 +0000.
 */

namespace App\Models\CodificheFHIR;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class TipoContatto
 * 
 * @property string $Code
 * @property string $Text
 * 
 * @property \Illuminate\Database\Eloquent\Collection $contattos
 *
 * @package App\Models
 */
class TipoContatto extends Eloquent
{
	protected $table = 'TipoContatto';
	protected $primaryKey = 'Code';
	public $incrementing = false;
	public $timestamps = false;

	protected $fillable = [
		'Text'
	];

	public function contattos()
	{
		return $this->hasMany(\App\Models\Contatto::class, 'tipo');
	}
}
