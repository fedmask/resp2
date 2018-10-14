<?php

namespace App\Models\History;

use Illuminate\Database\Eloquent\Model;

class AnamnesiF extends Model {
	//
	protected $table = 'tbl_AnamnesiF';
	protected $primaryKey = 'id_anamnesiF';
	public $incrementing = true;
	public $timestamps = false;
	protected $casts = [ 
			'id_paziente' => 'int',
			'id_parente' => 'int',
			'id_anamnesiF' => 'int'
	];
	protected $dates = [ 
			'data' 
	
	];
	protected $fillable = [ 
		'id_anamnesiF',
		'descrizione',
		'id_paziente',
		'id_parente',
		'status',
		'notDoneReason',
		'note',
		'data'

	];
	
}
