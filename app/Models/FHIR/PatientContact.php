<?php

namespace App\Models\FHIR;

use Illuminate\Database\Eloquent\Model;
use App\Models\CodificheFHIR\ContactRelationship;
use App\Traits\Encryptable;

class PatientContact extends Model {
	use Encryptable;
	protected $table = 'PatientContact';
	protected $primaryKey = 'Id_Patient';
	public $incrementing = true;
	public $timestamps = false;
	protected $encryptable = [ 
			
			'Name',
			'Surname',
			
			'Mail' 
	];
	protected $fillable = [ 
			'Id_Patient',
			'Relationship',
			'Name',
			'Surname',
			'Telephone',
			'Mail' 
	];
	public function getIdPatient() {
		return $this->Id_Patient;
	}
	public function getRelationship() {
		return $this->Relationship;
	}
	public function getName() {
		return $this->Name;
	}
	public function getSurname() {
		return $this->Surname;
	}
	public function getTelephone() {
		return $this->Telephone;
	}
	public function getMail() {
		return $this->Mail;
	}
	public function getRelationshipDisplay() {
		return ContactRelationship::where ( 'Code', $this->getRelationship () )->value ( 'Display' );
	}
}
