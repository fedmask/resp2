<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 25 Dec 2017 12:47:05 +0000.
 */
namespace App\Models\Vaccine;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class TblVaccini
 *
 * @property int $id_vaccino
 * @property string $vaccino_codice
 * @property string $vaccino_descrizione
 * @property string $vaccino_nome
 * @property int $vaccino_durata
 *
 * @property \Illuminate\Database\Eloquent\Collection $tbl_vaccinaziones
 *
 * @package App\Models
 */
class TblVaccini extends Eloquent {
	protected $table = 'tbl_vaccini';
	protected $primaryKey = 'id_vaccino';
	public $timestamps = false;
	protected $casts = [ 
			'vaccino_durata' => 'int',
			'id_vaccinazione'=>'int'
	];
	protected $fillable = [ 
			'vaccino_codice',
			'vaccino_descrizione',
			'vaccino_nome',
			'vaccino_durata',
			'vaccino_manufactured',
			'vaccino_expirationDate' 
	];
	public function getId() {
		return $this->id_vaccino;
	}
	public function getCodice() {
		return $this->vaccino_codice;
	}
	public function getDescrizione() {
		return $this->vaccino_descrizione;
	}
	public function getNome() {
		return $this->vaccino_nome;
	}
	public function getDurata() {
		return $this->vaccino_durata;
	}
	public function getId() {
		return $this->vaccino_manufactured;
	}
	public function getExpDate() {
		return $this->vaccino_expirationDate;
	}
	public function getManufactured() {
		return $this->vaccino_manufactured;
	}
	public function setCodice($Codice) {
		$this->vaccino_codice = $Codice;
	}
	public function setDescrizione($Descrizione) {
		$this->vaccino_descrizione = $Descrizione;
	}
	public function setNome($Nome) {
		$this->vaccino_nome = $Nome;
	}
	public function setDurata($Durata) {
		$this->vaccino_durata = $Durata;
	}
	public function setManufactured($Manufacturer) {
		$this->vaccino_manufactured = $Manufacturer;
	}
	public function setExpDate($Date) {
		return $this->vaccino_expirationDate = $Date;
	}
	public function tbl_vaccinaziones() {
		return $this->belongsTo ( \App\Models\Vaccine\Vaccinazione::class, 'id_vaccinazione' );
	}
}
