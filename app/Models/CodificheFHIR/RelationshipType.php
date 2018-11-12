<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 19 Sep 2018 06:05:03 +0000.
 */

namespace App\Models\CodificheFHIR;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class RelationshipType
 * 
 * @property string $Code
 * @property string $Text
 * 
 * 
 * @package App\Models
 */
class RelationshipType extends Eloquent
{
	protected $table = 'RelationshipType';
	protected $primaryKey = 'Code';
	public $incrementing = false;
	public $timestamps = false;

	protected $fillable = [
		'Display'
	];

	
}
