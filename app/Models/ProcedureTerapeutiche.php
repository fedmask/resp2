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
        'Codice_icd9' => 'string'
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
        'descrizione'
    ];
    
    
    /* Metodi per risorse Fhir */
    //@todo da verificare se esistono i metodi get nei rispettivi modelli delle entità considerate, implementa!!
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
    
    
    public function setData($data){
        $this->Data_esecuzione = $data;
    }
    public function setDesc($desc){
        $this->Descrizione = $desc;
    }
    
    
    // da controllare !!!! (belongsTO = realzione uno a uno)
    public function pazienti()
    {
        return $this->belongsTo(\App\Models\Patient\Pazienti::class, 'id_paziente'); // aggiungere relazione hasMany in Pazienti.php
    }
    
    public function cpp()
    {
        return $this->belongsTo(\App\Models\CareProviders\CareProvider::class, 'id_cpp'); // aggiungere relazione hasMany in CareProvider.php
    }
    
    public function diagnosi()
    {
        return $this->belongsTo(\App\Models\Diagnosis\Diangosi::class, 'id_diagnosi'); // aggiungere relazione hasMany in Diagnosi.php
    }
    
    
    public function icd9()
    {
    	return $this->belongsTo(\App\Models\ICD9_ICPT::class, 'Codice_ICD9'); // aggiungere relazione hasMany in Icd9
    }
    
}
