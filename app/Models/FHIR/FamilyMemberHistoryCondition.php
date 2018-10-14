<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 19 Sep 2018 06:05:03 +0000.
 */

namespace App\Models\FHIR;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class FamilyMemberHistoryCondition
 * 
 * @package App\Models
 */
class FamilyMemberHistoryCondition extends Eloquent
{
	protected $table = 'FamilyMemberHistoryCondition';
	protected $primaryKey = 'id_anamnesiF';
	public $incrementing = false;
	public $timestamps = false;


    protected $casts = [
		'id_anamnesiF' => 'int'
	];


	protected $fillable = [
		'id_anamnesiF',
		'code',
		'outcome',
		'note'
	];
}
