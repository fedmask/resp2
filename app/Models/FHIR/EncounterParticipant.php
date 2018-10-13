<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 19 Sep 2018 06:05:03 +0000.
 */

namespace App\Models\FHIR;

use Reliese\Database\Eloquent\Model as Eloquent;
use App\Models\CodificheFHIR\EncounterParticipantType;
use App\Models\CareProviders\CareProvider;

/**
 * Class EncounterParticipant
 * 
 * @package App\Models
 */
class EncounterParticipant extends Eloquent
{
	protected $table = 'EncounterParticipant';
	protected $primaryKey = 'id_visita';
	public $incrementing = false;
	public $timestamps = false;


protected $casts = [
		'id_visita' => 'int',
		'individual' => 'int'
	];

	protected $dates = [
		'start_period',
	    'end_period'
	];


	protected $fillable = [
		'id_visita',
		'individual',
		'type',
		'start_period',
		'end_period'
	];
	
	
	public function getId(){
	    return $this->id_visita();
	}
	
	public function getIndividualId(){
	    return $this->individual;
	}
	
	public function getIndividual(){
	    $cpp = CareProvider::where('id_cpp', $this->getIndividualId())->first();
	    return $cpp->getFullName();
	}
	
	public function getType(){
	    return $this->type;
	}
	
	public function getTypeDisplay(){
	    $dis = EncounterParticipantType::where('Code', $this->getType())->first();
	    return $dis->Display;
	}
	
	public function getStartPeriod(){
	    $t = $this->start_period;
	    date_default_timezone_set("Europe/Rome");
	    
	    $date = date(DATE_ATOM,mktime(date("H", strtotime($t)),date("m", strtotime($t)),date("s", strtotime($t)),date("m", strtotime($t)),date("d", strtotime($t)),date("Y", strtotime($t))));
	    return $date;
	}
	
	public function getEndPeriod(){
	    $t = $this->end_period;
	    date_default_timezone_set("Europe/Rome");
	    
	    $date = date(DATE_ATOM,mktime(date("H", strtotime($t)),date("m", strtotime($t)),date("s", strtotime($t)),date("m", strtotime($t)),date("d", strtotime($t)),date("Y", strtotime($t))));
	    return $date;
	}
}
