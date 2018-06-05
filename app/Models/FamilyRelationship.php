<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FamilyRelationship extends Model
{
    protected $table = 'tbl_famely_relationship';
    protected $primaryKey = 'Codice_ICD9';
    public $incrementing = false;
    public $timestamps = false;
    
    // $casts permette di convertire gli attributi di un db in tipo di dato comune
    protected $casts = [
        'codice' => 'String',
        'codice_descrizione' => 'String'
        
        
    ];
    protected $fillable = [
        'codice_descrizione',
        'descrizione'
    ];
    
    
    public function getID(){
        return $this->codice;
    }
    public function getCodiceDesc(){
        return $this->codice_descrizione;
    }
    public function getDesc(){
        return $this->descrizione;
    }
    
    
    public function setID($id){
         $this->codice = $id;
    }
    public function setCodiceDesc($cod){
        $this->codice_descrizione = $cod;
    }
    public function setDesc($desc){
        $this->descrizione = $desc;
    }
    
    
}
