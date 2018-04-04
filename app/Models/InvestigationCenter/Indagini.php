<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 25 Dec 2017 12:47:05 +0000.
 */

namespace App\Models\InvestigationCenter;

use Reliese\Database\Eloquent\Model as Eloquent;
use DateTime;
/**
 * Class Indagini
 * 
 * @property int $id_indagine
 * @property int $id_centro_indagine
 * @property int $id_diagnosi
 * @property int $id_paziente
 * @property int $id_audit_log
 * @property string $indagine_codice_icd
 * @property string $indagine_codice_loinc
 * @property \Carbon\Carbon $indagine_data
 * @property \Carbon\Carbon $indagine_aggiornamento
 * @property string $indagine_stato
 * @property string $indagine_tipologia
 * @property string $indagine_motivo
 * @property string $indagine_referto
 * @property string $indagine_allegato
 * 
 * @property \App\Models\TblAuditlogLog $tbl_auditlog_log
 * @property \App\Models\CentriIndagini $tbl_centri_indagini
 * @property \App\Models\Diagnosi $tbl_diagnosi
 * @property \App\Models\Icd9EsamiStrumentiCodici $tbl_icd9_esami_strumenti_codici
 * @property \App\Models\Loinc $tbl_loinc
 * @property \App\Models\Pazienti $tbl_pazienti
 *
 * @package App\Models
 */
class Indagini extends Eloquent
{
	protected $table = 'tbl_indagini';
	protected $primaryKey = 'id_indagine';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id_indagine' => 'int',
		'id_centro_indagine' => 'int',
		'id_diagnosi' => 'int',
		'id_paziente' => 'int',
		'id_audit_log' => 'int'
	];

	protected $dates = [
		'indagine_data',
		'indagine_aggiornamento'
	];

	protected $fillable = [
		'id_centro_indagine',
		'id_diagnosi',
		'id_paziente',
	    'id_cpp',
		'id_audit_log',
		'indagine_codice_icd',
		'indagine_codice_loinc',
		'indagine_data',
		'indagine_aggiornamento',
		'indagine_stato',
		'indagine_tipologia',
		'indagine_motivo',
		'indagine_referto',
		'indagine_allegato'
	];

	
	/** FHIR **/
	
	public function setID($id){
	    $this->$primaryKey = $id;
	}
	
	public function setIDPatient($id){
	    $this->id_paziente = $id;
	}
	
	public function setTipology($tipology){
	    $this->indagine_tipologia = $tipology;
	}
	
	public function setReason($reason){
	    $this->indagine_motivo = $reason;
	}
	
	public function setCodeLoinc($codeLoinc){
	    $this->indagine_codice_loinc = $codeLoinc;
	}
	
	public function setDate($date){
	    $this->indagine_data = $date;
	}
	
	public function setCppID($idCpp){
	    $this->id_cpp = $idCpp;
	}

	public function setIDiagnosis($id){
	    $this->id_diagnosi = $id;
	}
	
	public function getID(){
	    return $this->$primaryKey;
	}
	
	public function getTipology(){
	    return $this->indagine_tipologia;
	}
	
	public function getReason(){
	    return $this->indagine_motivo;
	}
	
	public function getCodeLoinc(){
	    return $this->indagine_codice_loinc;
	}
	
	public function getDate(){
	    return $this->indagine_data;
	}
	
	public function getCppID(){
	    return $this->id_cpp;
	}
	
	public function isClosed(){
	    return $this->getStatus() == "conclusa" ? true : false;
	}
	
	public function getStatus(){
	    
	    $result_status = "final";
	    
	    if($this->indagine_stato == "richiesta"){
	        $result_status = "registered";
	    }elseif($this->indagine_stato == "programmata"){
	       $result_status = "preliminary";
	    }
	    
	    return $result_status;
	}
	
	public function getStatusFromFHIR($status_format_fhir){
	    
	    $result_status = "conclusa";
	    
	    if($status_format_fhir == "registered"){
	        $result_status = "richiesta";
	    }elseif($status_format_fhir == "preliminary"){
	        $result_status = "programmata";
	    }
	    
	    return $result_status;
	}
	
	public function getLoincDescription(){
	    return $this->tbl_loinc()->first()["loinc_classe"];
	}
	
	public function getDateATOM(){
	    $date = new DateTime($this->indagine_data);
	    return $date->format(DateTime::ATOM);
	}
	
	public function getStatusObservation(){
	    $status = "POS";
	    
	    if($this->indagine_stato == "1"){
	        $status = "IE";
	    }elseif($this->indagine_stato == "2"){
	        $status = "NEG";
	    }
	
	    return $status;
	}
	
	public function getStatusDescriptionObservation(){
	    
	    $status_description = "Confermata";
	    
	    if($this->indagine_stato == "1"){
	        $status_description = "Sospetta";
	    }elseif($this->indagine_stato == "2"){
	        $status_description = "Esclusa";
	    }
	    
	    return $status_description;
	}
	
	public function getResponse(){
	    
	    $response = "unknown";
	    
	    if($this->indagine_referto != ""){
	        $response = $this->indagine_referto;
	    }
	    
	    return $response;
	}
	
	public function tbl_cpp()
	{
	    return $this->belongsTo(\App\Models\Log\CareProvider::class, 'id_cpp');
	}
	
	public function tbl_auditlog_log()
	{
		return $this->belongsTo(\App\Models\Log\AuditlogLog::class, 'id_audit_log');
	}

	public function tbl_centri_indagini()
	{
		return $this->belongsTo(\App\Models\InvestigationCenter\CentriIndagini::class, 'id_centro_indagine');
	}

	public function tbl_diagnosi()
	{
		return $this->belongsTo(\App\Models\Diagnosis\Diagnosi::class, 'id_diagnosi');
	}

	public function tbl_icd9_esami_strumenti_codici()
	{
		return $this->belongsTo(\App\Models\Icd9\Icd9EsamiStrumentiCodici::class, 'indagine_codice_icd');
	}

	public function tbl_loinc()
	{
		return $this->belongsTo(\App\Models\Loinc\Loinc::class, 'indagine_codice_loinc');
	}

	public function tbl_pazienti()
	{
		return $this->belongsTo(\App\Models\Patient\Pazienti::class, 'id_paziente');
	}
}
