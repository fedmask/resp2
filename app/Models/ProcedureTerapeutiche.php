<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ProcedureTerapeutiche extends Eloquent
{
    protected $table = 'tbl_proc_terapeutiche';
    protected $primaryKey = 'id_Procedure_Terapeutiche';
    public $incrementing = true;
    public $timestamps = false;
    
    
    //$casts permette di convertire gli attributi di un db in tipo di dato comune
    protected $casts = [
        'id_Procedure_Terapeutiche' => 'int',
        'Pazinte' => 'int',
        'Diagnosi' => 'int',
        'CareProvider' => 'int',
        'Codice_icd9' => 'string',
        'Status' => 'string',
        'Category' => 'int',
        'outCome' => 'int',
        'note' => 'string'
        
    ];
    
    //$date permette di prendere in considerazione le date che cambiano nel tempo
    protected $dates = [
        'Data_esecuzione'
    ];
    
    
    protected $fillable = [
        'Pazinte',
        'Codice_icd9',
        'Diagnosi',
        'CareProvider',
        'Data_esecuzione',
        'descrizione',
        'Status',
        'code',
        'reasonCode',
        'bodySite',
        'followUp',
        'notDoneReason',
        'complication',
        'Category',
        'outCome',
        'note'
    ];
    
    
    public function tbl_care_provider()
    {
        return $this->belongsTo(\App\Models\TblCareProvider::class, 'CareProvider');
    }
    
    public function tbl_diagnosi()
    {
        return $this->belongsTo(\App\Models\TblDiagnosi::class, 'Diagnosi');
    }
    
    public function tbl_i_c_d9_i_c_p_t()
    {
        return $this->belongsTo(\App\Models\TblICD9ICPT::class, 'Codice_icd9');
    }
    
    public function tbl_pazienti()
    {
        return $this->belongsTo(\App\Models\TblPazienti::class, 'Paziente');
    }
    
    public function tbl_proc_cat()
    {
        return $this->belongsTo(\App\Models\TblProcCat::class, 'Category');
    }
    
    public function tbl_proc_outcome()
    {
        return $this->belongsTo(\App\Models\TblProcOutcome::class, 'outCome');
    }
    
    public function tbl_proc_status()
    {
        return $this->belongsTo(\App\Models\TblProcStatus::class, 'Status');
    }
    
    public function procedure_code()
    {
        return $this->belongsTo(\App\Models\ProcedureCode::class, 'code');
    }
    
    public function procedure_reason_code()
    {
        return $this->belongsTo(\App\Models\ProcedureReasonCode::class, 'reasonCode');
    }
    
    public function procedure_body_site()
    {
        return $this->belongsTo(\App\Models\ProcedureBodySite::class, 'bodySite');
    }
    
    public function procedure_follow_up()
    {
        return $this->belongsTo(\App\Models\ProcedureFollowUp::class, 'followUp');
    }
    
    public function procedure_not_done_reason()
    {
        return $this->belongsTo(\App\Models\ProcedureNotDoneReason::class, 'notDoneReason');
    }
    
    public function procedure_complication()
    {
        return $this->belongsTo(\App\Models\ProcedureComplication::class, 'complication');
    }
    
    
    public function getID(){
        return $this->id_Procedure_Terapeutiche;
    }
    public function getData(){
        return $this->Data_esecuzione;
    }
    public function getDesc(){
        return $this->descrizione;
    }
    public function getPatientID(){
        return $this->pazienti->first()->getID();
    }
    public function getCppID(){
        return $this->cpp->first()->getID();
    }
    public function getDiagnosisID(){
        return $this->diagnosi->first()->getID();
    }
    
    public function getIcd9ID(){
        return $this->icd9()->first()->getID();
    }
    public function getStatus(){
        return $this->ProcStatus()->first()->getID();
    }
    public function getnotDone(){
        return $this->notDone;
    }
    public function getCategory(){
        return $this->ProcCat()->first()->getID();
    }
    public function getOutcome(){
        return $this->ProcOutcome()->first()->getID();
    }
    public function getNote(){
        return $this->note;
    }
    
    
    
    
    
    
    
    public function setData($data){
        $this->Data_esecuzione = $data;
    }
    public function setDesc($desc){
        $this->Descrizione = $desc;
    }
    public function setPaziene($paz){
        $this->Paziente = $paz;
    }
    public function setCpp($cpp){
        $this->CareProvider = $cpp;
    }
    public function setDiagnosi($dia){
        $this->Diagnosi = $dia;
    }
    public function setICD9($icd){
        $this->Codice_icd9 = $icd;
    }
    public function setNote($note){
        $this->note = $note;
    }
    public function setNotDone($nd){
        $this->notDone = $nd;
    }
   
    
    
    
    
    
    public function tbl_pazienti()
    {
        return $this->belongsTo(\App\Models\Patient\Pazienti::class, 'id_paziente');
    }
    
    public function tbl_cpp()
    {
        return $this->belongsTo(\App\Models\CareProviders\CareProvider::class, 'id_cpp');
    }
    
    public function tbl_diagnosi()
    {
        return $this->belongsTo(\App\Models\Diagnosis\Diangosi::class, 'id_diagnosi');
    }
    
    public function tbl_icd9()
    {
        return $this->belongsTo(\App\Models\ICD9_ICPT::class, 'Codice_ICD9');
    }
    
    
    public function ProcCat()
    {
        return $this->belongsTo(\App\Models\ProcedureCategory::class, 'codice');
    }
    
    public function ProcOutcome()
    {
        return $this->belongsTo(\App\Models\ProcedureOutCome::class, 'codice');
    }
    
    public function ProcStatus()
    {
        return $this->belongsTo(\App\Models\ProcedureStatus::class, 'codice');
    }
    
    
    
}
