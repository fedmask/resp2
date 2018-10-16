<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 25 Dec 2017 12:47:05 +0000.
 */

namespace App\Models\Diagnosis;

use App\Models\CodificheFHIR\ConditionCode;
use App\Models\CodificheFHIR\ConditionClinicalStatus;
use App\Models\CodificheFHIR\ConditionVerificationStatus;
use App\Models\CodificheFHIR\ConditionSeverity;
use App\Models\CodificheFHIR\ConditionBodySite;
use App\Models\CodificheFHIR\ConditionStageSummary;
use App\Models\CodificheFHIR\ConditionEvidenceCode;
use Reliese\Database\Eloquent\Model as Eloquent;
use App\Models\Patient\Pazienti;

/**
 * Class Diagnosi
 * 
 * @property int $id_diagnosi
 * @property int $id_paziente
 * @property int $diagnosi_confidenzialita
 * @property \Carbon\Carbon $diagnosi_inserimento_data
 * @property \Carbon\Carbon $diagnosi_aggiornamento_data
 * @property string $diagnosi_patologia
 * @property bool $diagnosi_stato
 * @property \Carbon\Carbon $diagnosi_guarigione_data
 * 
 * @property \App\Models\LivelliConfidenzialita $tbl_livelli_confidenzialitum
 * @property \App\Models\Pazienti $tbl_pazienti
 * @property \App\Models\CppDiagnosi $tbl_cpp_diagnosi
 * @property \Illuminate\Database\Eloquent\Collection $tbl_diagnosi_eliminates
 * @property \Illuminate\Database\Eloquent\Collection $tbl_indaginis
 *
 * @package App\Models
 */
class Diagnosi extends Eloquent
{
	protected $table = 'tbl_diagnosi';
	protected $primaryKey = 'id_diagnosi';
	public $timestamps = false;

	protected $casts = [
	    'id_diagnosi' => 'int',
		'id_paziente' => 'int',
		'diagnosi_confidenzialita' => 'int',
	];

	protected $dates = [
		'diagnosi_inserimento_data',
		'diagnosi_aggiornamento_data',
		'diagnosi_guarigione_data'
	];

	protected $fillable = [
	    'id_diagnosi',
		'id_paziente',
	    'verificationStatus',
	    'severity',
	    'code',
	    'bodySite',
	    'stageSummary',
	    'evidenceCode',
		'diagnosi_confidenzialita',
		'diagnosi_inserimento_data',
		'diagnosi_aggiornamento_data',
		'diagnosi_patologia',
		'diagnosi_stato',
		'diagnosi_guarigione_data',
	    'note'
	];

	
	
	public function condition_clinical_status()
	{
	    return $this->belongsTo(\App\Models\ConditionClinicalStatus::class, 'diagnosi_stato');
	}
	
	public function condition_verification_status()
	{
	    return $this->belongsTo(\App\Models\ConditionVerificationStatus::class, 'verificationStatus');
	}
	
	public function condition_severity()
	{
	    return $this->belongsTo(\App\Models\ConditionSeverity::class, 'severity');
	}
	
	public function condition_code()
	{
	    return $this->belongsTo(\App\Models\ConditionCode::class, 'code');
	}
	
	public function condition_body_site()
	{
	    return $this->belongsTo(\App\Models\ConditionBodySite::class, 'bodySite');
	}
	
	public function condition_stage_summary()
	{
	    return $this->belongsTo(\App\Models\ConditionStageSummary::class, 'stageSummary');
	}
	
	public function condition_evidence_code()
	{
	    return $this->belongsTo(\App\Models\ConditionEvidenceCode::class, 'evidenceCode');
	}
	
	
	public function tbl_proc_terapeutiches()
	{
	    return $this->hasMany(\App\Models\TblProcTerapeutiche::class, 'Diagnosi');
	}
	
	
	
	
	public function tbl_livelli_confidenzialitum()
	{
		return $this->belongsTo(\App\Models\LivelliConfidenzialita::class, 'diagnosi_confidenzialita');
	}

	public function tbl_pazienti()
	{
		return $this->belongsTo(\App\Models\Patient\Pazienti::class, 'id_paziente');
	}

	public function tbl_cpp_diagnosi()
	{
		return $this->hasOne(\App\Models\CareProvider\CppDiagnosi::class, 'id_diagnosi');
	}

	public function tbl_diagnosi_eliminates()
	{
		return $this->hasMany(\App\Models\Diagnosis\DiagnosiEliminate::class, 'id_diagnosi');
	}

	public function tbl_indaginis()
	{
		return $this->hasMany(\App\Models\InvestigationCenter\Indagini::class, 'id_diagnosi');
	}
	
	public function tbl_proc_ter()
	{
	    return $this->hasMany(\App\Models\ProcedureTerapeutiche::class, 'id_Procedure_Terapeutiche');
	}
	
	public function getId(){
	    return $this->id_diagnosi;
	}
	
	public function getDataInserimento(){
	    $data = date_format($this->diagnosi_inserimento_data,"Y-m-d");
	    return $data;
	}
	
	public function getCode(){
	    return $this->code;
	}
	
	public function getCodeDisplay(){
	    $dis = ConditionCode::where('Code', $this->getCode())->first();
	    return $dis->Text;
	}
	
	public function getSeverity(){
	    return $this->severity;
	}
	
	public function getSeverityDisplay(){
	    $dis = ConditionSeverity::where('Code', $this->getSeverity())->first();
	    return $dis->Text;
	}
	
	public function getClinicalStatus(){
	    return $this->diagnosi_stato;
	}
	
	public function getVerificationStatus(){
	    return $this->verificationStatus;
	}
	
	public function getBodySite(){
	    return $this->bodySite;
	}
	
	public function getBodySiteDisplay(){
	    $dis = ConditionBodySite::where('Code', $this->getBodySite())->first();
	    return $dis->Text;
	}
	
	public function getStage(){
	    return $this->stageSummary;
	}
	
	public function getStageDisplay(){
	    $dis = ConditionStageSummary::where('Code', $this->getStage())->first();
	    return $dis->Text;
	}
	
	public function getEvidence(){
	    return $this->evidenceCode;
	}
	
	public function getEvidenceDisplay(){
	    $dis = ConditionEvidenceCode::where('Code', $this->getEvidence())->first();
	    return $dis->Text;
	}
	
	public function getPazienteId(){
	    return $this->id_paziente;
	}
	
	public function getPaziente(){
	    $paz = Pazienti::where('id_paziente', $this->id_paziente)->first();
	    return $paz->getFullName();
	}
	
	public function getNote(){
	    return $this->note;
	}
	
	public function getConfidenzialita(){
	    return $this->diagnosi_confidenzialita;
	}
	
	public function getDataInizio(){
	    $data = date_format($this->diagnosi_inserimento_data,"Y-m-d");
	    return $data;
	}
	
	public function getDataFine(){
	    $data = date_format($this->diagnosi_guarigione_data,"Y-m-d");
	    return $data;
	}
	
	public function getDataAggiornamento(){
	    $data = date_format($this->diagnosi_aggiornamento_data,"Y-m-d");
	    return $data;
	}
}
