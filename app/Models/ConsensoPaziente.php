<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConsensoPaziente extends Model
{
    //
	protected $table = 'Consenso_Paziente';
	protected $primaryKey = 'Id_Consenso_P';
	public $timestamps = false;
	protected $casts = [
			'Id_Consenso_P' =>'int',
			'Id_Trattamento' => 'int',
			'Id_Paziente' => 'int',
			
	];
	protected $dates = [
			'data_consenso'
	];
	protected $fillable = [
			'Id_Consenso_P',
			'Id_Trattamento',
			'Id_Paziente',
			'Consenso',
			'data_consenso'
	];
	
	public function getID_Paziente()
	{
		return $this->Id_Paziente;
	}
	
	public function getID_Trattamento()
	{
		return $this->Id_Trattamento;
	}
	public function getConsenso()
	{
				return ($this->Consenso == 0) ? false : true;
	}
	public function getDataConsenso()
	{
		return $this->data_consenso;
	}
	
	public function setTime(){
		
		$this->data_consenso=now();
		
	}
	
	public function getTrattamentoNome(){
		
		return   \App\TrattamentiPaziente::where('Id_Trattamento', $this->getID_Trattamento())->first()->Nome_T;
		
	}
	
	public function getTrattamentoInformativa(){
		
		return   \App\TrattamentiPaziente::where('Id_Trattamento', $this->getID_Trattamento())->first()->Informativa;
		
	}
	
	public function Paziente() {
		return $this->belongsTo ( \App\Models\Patient\Pazienti::class, 'id_paziente' );
	}
	public function Trattamento() {
		return $this->belongsTo ( \App\Models\TrattamentiPaziente::class, 'Id_Trattamento' );
	}
	
	
}
