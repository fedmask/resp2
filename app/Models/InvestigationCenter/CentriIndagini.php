<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 25 Dec 2017 12:47:05 +0000.
 */
namespace App\Models\InvestigationCenter;

use App\Traits\Encryptable;
use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class CentriIndagini
 *
 * @property int $id_centro
 * @property int $id_tipologia
 * @property int $id_comune
 * @property int $id_ccp_persona
 * @property string $centro_nome
 * @property string $centro_indirizzo
 * @property string $centro_mail
 * @property bool $centro_resp
 *
 * @property \App\Models\CentriTipologie $tbl_centri_tipologie
 * @property \App\Models\Comuni $tbl_comuni
 * @property \App\Models\CppPersona $tbl_cpp_persona
 * @property \Illuminate\Database\Eloquent\Collection $tbl_centri_contattis
 * @property \Illuminate\Database\Eloquent\Collection $tbl_indaginis
 *
 * @package App\Models
 */
class CentriIndagini extends Eloquent {
	
	use Encryptable;
	protected $table = 'tbl_centri_indagini';
	protected $primaryKey = 'id_centro';
	public $timestamps = false;
	protected $casts = [ 
			'id_tipologia' => 'int',
			'id_comune' => 'int',
			'id_ccp_persona' => 'int',
			'centro_resp' => 'bool' 
	];
	protected $encryptable = [ 
			'centro_nome',
			'centro_indirizzo',
			
			'centro_resp' 
	];
	protected $fillable = [ 
			'id_tipologia',
			'id_comune',
			'id_ccp_persona',
			'centro_nome',
			'centro_indirizzo',
			'centro_mail',
			'centro_resp' 
	];
	public function getCareProviderName() {
		return $this->tbl_cpp_persona ()->first ()->persona_nome;
	}
	public function getCareProviderSurname() {
		return $this->tbl_cpp_persona ()->first ()->persona_cognome;
	}
	public function getCareProvider() {
		return $this->getCareProviderSurname () . " " . $this->getCareProviderName ();
	}
	public function getContactPhone() {
		return $this->tbl_centri_contattis ()->select ( 'contatto_valore' )->where ( "id_modalita_contatto", ModalitaContatti::$PHONE_TYPE )->first () ["contatto_valore"];
	}
	public function getAllContactPhone() {
		return $this->tbl_centri_contattis ()->select ( 'contatto_valore' )->where ( "id_modalita_contatto", ModalitaContatti::$PHONE_TYPE )->get ();
	}
	public function getContactEmail() {
		return $this->tbl_centri_contattis ()->select ( 'contatto_valore' )->where ( "id_modalita_contatto", ModalitaContatti::$EMAIL_TYPE )->first () ["contatto_valore"];
	}
	public function getCenterTipology() {
		return $this->tbl_centri_tipologie ()->first () ["tipologia_nome"];
	}
	public function getTown() {
		return $this->tbl_comuni ()->first ()->getTown ();
	}
	public function tbl_centri_tipologie() {
		return $this->belongsTo ( \App\Models\InvestigationCenter\CentriTipologie::class, 'id_tipologia' );
	}
	public function tbl_comuni() {
		return $this->belongsTo ( \App\Models\Domicile\Comuni::class, 'id_comune' );
	}
	public function tbl_cpp_persona() {
		return $this->belongsTo ( \App\Models\CareProviders\CppPersona::class, 'id_ccp_persona' );
	}
	public function tbl_centri_contattis() {
		return $this->hasMany ( \App\Models\InvestigationCenter\CentriContatti::class, 'id_centro' );
	}
	public function tbl_indaginis() {
		return $this->hasMany ( \App\Models\InvestigationCenter\Indagini::class, 'id_centro_indagine' );
	}
	public function tbl_vaccinazioni() {
		return $this->hasOne ( \App\Models\Vaccine::class, 'id_centro' );
	}
	
	/**
	 * FHIR *
	 */
	public function getID() {
		return $this->id_centro;
	}
	public function getIDCpp() {
		return $this->id_ccp_persona;
	}
	public function getName() {
		return $this->centro_nome;
	}
	public function getAddress() {
		return $this->centro_indirizzo;
	}
	public function setName($name) {
		$this->centro_nome = $name;
	}
	public function setAddress($address) {
		$this->centro_indirizzo = $address;
	}
	public function setIDCpp($idCpp) {
		$this->id_ccp_persona = $idCpp;
	}
	public function setIDTown($idTown) {
		$this->id_comune = $idTown;
	}
	public function setIDTipology($idTipology) {
		$this->id_tipologia = $idTipology;
	}
}
