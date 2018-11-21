<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Encryptable;
class FamilyRelationship extends Model
{
use Encryptable;

    protected $table = 'tbl_famely_relationship';
    protected $primaryKey = 'codice';
    public $incrementing = false;
    public $timestamps = false;
    
    // $casts permette di convertire gli attributi di un db in tipo di dato comune
    protected $casts = [
        'codice' => 'String',
        'codice_descrizione' => 'String'
        
        
    ];
    
    protected $encryptable = ['descrizione'];
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
    
    public function anamnesiFamigliare()
    {
        return $this->hasMany(\App\Models\History\AnamnesiFamiliare::class, 'codice');
    }
    
}
