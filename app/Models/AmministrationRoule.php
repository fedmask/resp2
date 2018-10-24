<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AmministrationRoule extends Model
{
    //
    
	protected $table = 'Consenso_Paziente';
	protected $primaryKey = 'Id_Consenso_P';
	public $timestamps = false;
	protected $casts = [
		
	];
	protected $dates = [
	];
	protected $fillable = [
			'ruolo'
	];
	public function getRuolo() {
		return $this->ruolo;
	}

	public function Amministration()
	{
		return $this->hasMany(\App\Models\Amministration::class, 'Ruolo');
	}
	
	
	
}
