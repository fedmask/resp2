<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 23 Dec 2017 16:46:47 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class LivelliConfidenzialitum
 * 
 * @property int $id_livello_confidenzialita
 * @property string $confidenzialita_codice
 * @property string $confidenzialita_descrizione
 * 
 * @property \Illuminate\Database\Eloquent\Collection $tbl_cpp_pazientes
 * @property \Illuminate\Database\Eloquent\Collection $tbl_diagnosis
 * @property \Illuminate\Database\Eloquent\Collection $tbl_farmaci_vietatis
 * @property \Illuminate\Database\Eloquent\Collection $tbl_files
 * @property \Illuminate\Database\Eloquent\Collection $tbl_vaccinaziones
 *
 * @package App\Models
 */
class LivelliConfidenzialitum extends Eloquent
{
	protected $primaryKey = 'id_livello_confidenzialita';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id_livello_confidenzialita' => 'int'
	];

	protected $fillable = [
		'confidenzialita_codice',
		'confidenzialita_descrizione'
	];

	public function tbl_cpp_pazientes()
	{
		return $this->hasMany(\App\Models\CppPaziente::class, 'assegnazione_confidenzialita');
	}

	public function tbl_diagnosis()
	{
		return $this->hasMany(\App\Models\Diagnosi::class, 'diagnosi_confidenzialita');
	}

	public function tbl_farmaci_vietatis()
	{
		return $this->hasMany(\App\Models\FarmaciVietati::class, 'farmaco_vietato_confidenzialita');
	}

	public function tbl_files()
	{
		return $this->hasMany(\App\Models\File::class, 'id_file_confidenzialita');
	}

	public function tbl_vaccinaziones()
	{
		return $this->hasMany(\App\Models\Vaccinazione::class, 'vaccinazione_confidenzialita');
	}
}
