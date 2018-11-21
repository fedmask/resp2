<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrattamentiCareProvider extends Model
{
	protected $table = 'Trattamenti_CP';
	protected $primaryKey = 'Id_Trattamento';
	public $incrementing = false;
	public $timestamps = false;
	protected $casts = [
			'Id_Trattamento' => 'int',
	];
	protected $fillable = [
			'Nome_T',
			'Finalita_T',
			'Modalita_T',
			'Informativa',
			'Incaricati'
	];
	

	public function getId() {
		return $this->Id_Trattamento;
	}
	
	public function getNomeT() {
		return $this->Nome_T;
	}
	
	
	public function getFinalità() {
		return $this->Finalita_T;
	}
	
	public function getModalità() {
		return $this->Modalita_T;
	}
	
	public function getInformativa() {
		return $this->Informativa;
	}
	
	public function getIncaricati() {
		return $this->Incaricati;
	}
	
	
}
