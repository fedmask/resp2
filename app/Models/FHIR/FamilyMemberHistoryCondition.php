<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 19 Sep 2018 06:05:03 +0000.
 */

namespace App\Models\FHIR;

use Reliese\Database\Eloquent\Model as Eloquent;
use App\Models\CodificheFHIR\ConditionCode;
use App\Models\CodificheFHIR\FamilyMemberHistoryConditionOutcome;

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
	
	public function getCode(){
	    return $this->code;
	}
	
	public function getCodeDisplay(){
	    $dis = ConditionCode::where('Code', $this->getCode())->first();
	    return $dis->Text;
	}
	
	public function getOutcome(){
	    return $this->outcome;
	}
	
	public function getOutComeDisplay(){
	   $dis = FamilyMemberHistoryConditionOutcome::where('Code', $this->getOutcome())->first();
	    return $dis->Text;
	}
	
	public function getNote(){
	    return $this->note;
	}
}
