<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FamilyCondiction extends Model
{
    protected $table = 'tbl_family_condiction';
    protected $primaryKey = 'id';
    public $timestamps = false;
    
    protected $casts = [
        'id' => 'int',
        'Codice_ICD9' => 'String',
        'outCome' => 'String',
        'id_anamnesi_familiare'=>'int',
        'onSetAge'=>'boolean',
        'onSetAgeRange_low'=>'int',
        'onSetAgeRange_hight'=>'int',
        'onSetAgeUnit'=>'int',
        'onSetAgeValue'=>'int'
    ];
    
  
    protected $fillable = [
        'Codice_ICD9',
        'outCome',
        'id_anamnesi_familiare',
        'onSetAge',
        'onSetAgeRange_low',
        'onSetAgeRange_hight',
        'onSetAgeUnit',
        'onSetAgeValue'

    ];
    
    public function getID(){
        return $this->id;
    }
    public function getICD9(){
        return $this->Codice_ICD9;
    }
    public function getoutCome(){
        return $this->outCome;
    }
    public function getIDAnamnesi(){
        return $this->id_anamnesi_familiare;
    }
    public function getAge(){
        return $this->onSetAge;
    }
    public function getAgeRangeLow(){
        return $this->onSetAgeRange_low;
    }
    public function getAgeRangeHight(){
        return $this->onSetAgeRange_hight;
    }
    public function getAgeUnit(){
        return $this->onSetAgeUnit;
    }
    public function getAgeValue(){
        return $this->onSetAgeValue;
    }
    
   
    
    public function setID($id){
           $this->id = $id;
    }
    public function setICD9($icd9){
        $this->Codice_ICD9 = $icd9 ;
    }
    public function setoutCome($out){
          $this->outCome = $out;
    }
    public function setIDAnamnesi($id_A){
          $this->id_anamnesi_familiare = $id_A;
    }
    public function setAge($age){
          $this->onSetAge = $age;
    }
    public function setAgeRangeLow($rl){
          $this->onSetAgeRange_low = $rl;
    }
    public function setAgeRangeHight($rh){
          $this->onSetAgeRange_hight = $rh;
    }
    public function setAgeUnit($unit){
          $this->onSetAgeUnit = $unit;
    }
    public function setAgeValue($value){
          $this->onSetAgeValue = $value;
    }
    
    
    
    
    
}
