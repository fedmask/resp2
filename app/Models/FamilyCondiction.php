<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FamilyCondiction extends Model
{
    protected $table = 'tbl_FamilyCondiction';
    protected $primaryKey = 'id';
    public $timestamps = false;
    
    protected $casts = [
        'id_Condition' => 'int',
        'Codice_ICD9' => 'String',
        'outCome' => 'String',
        'id_parente'=>'int',
        'onSetAge'=>'boolean',
        'onSetAgeRange_low'=>'int',
        'onSetAgeRange_hight'=>'int',
        'onSetAgeValue'=>'int'
    ];
    
  
    protected $fillable = [
        'Codice_ICD9',
        'outCome',
        'id_parente',
        'onSetAge',
        'onSetAgeRange_low',
        'onSetAgeRange_hight',
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
    public function getIDParente(){
        return $this->id_parente;
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
    public function setIDParente($id){
        $this->id_parente = $id;
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
 
    public function setAgeValue($value){
          $this->onSetAgeValue = $value;
    }
    
    
    public function anamnesiFamigliare()
    {
        return $this->hasMany(\App\Models\History\AnamnesiFamiliare::class, 'id');
    }
    
    
    
    
}
