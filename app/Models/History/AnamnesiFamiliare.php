<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 25 Dec 2017 12:47:05 +0000.
 */
namespace App\Models\History;

use Reliese\Database\Eloquent\Model as Eloquent;
use App\Traits\Encryptable;

/**
 * Class AnamnesiFamiliare
 *
 * @property int $id_anamnesi_familiare
 * @property int $id_paziente
 * @property int $id_anamnesi_log
 * @property string $anamnesi_contenuto
 *
 * @package App\Models
 */
class AnamnesiFamiliare extends Eloquent {
	
	use Encryptable;
	protected $table = 'tbl_anamnesi_familiare';
	protected $primaryKey = 'id_paziente';
	public $timestamps = false;
	protected $casts = [ 
			'id_paziente' => 'int',
			'id_anamnesi_log' => 'int',
			'status' => 'String',
			'notDoneReason' => 'String',
			'codice_relazione' => 'String',
			'genere' => 'String',
			'età' => 'int',
			'decesso' => 'boolean',
			'condizione' => 'int',
			'età_decesso' => 'int',
			'data_nascita' => 'date',
			'data_decesso' => 'date' 
	];
	protected $encryptable = [ 
'condizione' 
	];
	protected $dates = [ 
			'data_nascita',
			'data_decesso' 
	];
	protected $fillable = [ 
			'id_paziente',
			'id_anamnesi_log',
			'status',
			'notDoneReason',
			'codice_relazione',
			'anamnesi_contenuto',
			'genere',
			'eta',
			'decesso',
			'eta_decesso',
			'condizione' 
	];
	public function getID() {
		return $this->id_paziente;
	}
	public function getStatus() {
		return $this->status;
	}
	public function getNotDone() {
		return $this->notDoneReason;
	}
	public function getCodRela() {
		return $this->codice_relazione;
	}
	public function getContenuto() {
		return $this->anamnesi_contenuto;
	}
	public function getGenere() {
		return $this->genere;
	}
	public function getEta() {
		return $this->eta;
	}
	public function getEtaDecesso() {
		return $this->eta_decesso;
	}
	public function getDecesso() {
		return $this->decesso;
	}
	public function getCondizione() {
		return $this->condizione;
	}
	public function getDataNascita() {
		return $this->data_nascita;
	}
	public function getDataDecesso() {
		return $this->data_decesso;
	}
	public function setID($id) {
		$this->id_anamnesi_familiare = $id;
	}
	public function setIDPaziente($id) {
		$this->id_paziente = $id;
	}
	public function setStatus($status) {
		$this->status = $status;
	}
	public function setNotDone($not) {
		$this->notDoneReason = $not;
	}
	public function setCodRela($code) {
		$this->codice_relazione = $code;
	}
	public function setContenuto($cont) {
		$this->anamnesi_contenuto = $cont;
	}
	public function setGenere($genere) {
		$this->genere = $genere;
	}
	public function setEta($eta) {
		$this->età;
	}
	public function setEtaDecesso($etad) {
		$this->eta_decesso = $etad;
	}
	public function setDecesso($dec) {
		$this->decesso = $dec;
	}
	public function setCondizione($cond) {
		$this->condizione = $cond;
	}
	public function setDataNascita($dataN) {
		$this->data_nascita = $dataN;
	}
	public function setDataDecesso($dataD) {
		$this->data_decesso = $dataD;
	}
	public function codiceRelazione() {
		return $this->belongsTo ( \App\Models\FamilyRelationship::class, 'codice_relazione' );
	}
	public function codiceCondizione() {
		return $this->belongsTo ( \App\Models\FamilyCondiction::class, 'condizione' );
	}
	public function codiceCondizione() {
		return $this->hasMany ( \App\Models\AnamnesiF::class, 'id_paziente' );
	}
}
