<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ATCSottogruppoChimico extends Model
{
    protected $table = 'ATC_Sottogruppo_Chimico';
    protected $primaryKey = 'Codice_ATC';
    public $timestamps = false;
    
    protected $casts = [
        'Codice_ATC' => 'char',
        'Codice_Sottogruppo_CTF' => 'char',
        'ID_Sottogruppo_CTF' => 'char',
        'Descrizione' => 'string'
    ];
    
    protected $fillable = [
        'Descrizione',
        'Codice_Sottogruppo_CTF',
        'ID_Sottogruppo_CTF'
        
    ];
    
    public function getID(){
        return $this->Codice_ATC;
    }
    public function getCodiceSCTF(){
        return $this->Codice_Sottogruppo_CTF;
    }
    public function getID_GruppoSCFT(){
        return $this->ID_Sottogruppo_CTF;
    }
    
    public function getDesc(){
        return $this->Descrizione;
    }
    
  
    
    
    public function setID($id){
        $this->Codice_ATC = $id;
    }
    public function setSCTF($codice_s){
        $this->Codice_Sottogruppo_CTF = $codice_S;
    }
    public function setID_GruppoSCFT($id){
        $this->ID_Sottogruppo_CTF = $id;
    }
    public function getDesc($desc){
        $this->Descrizione = $desc;
    }
    
    public function sottogruppoChimicoTF() {
        return $this->belongsTo (\App\Models\ATCSottogruppoTerapeuticoF::class, 'ID_Sottogruppo_CTF' );
    }
    
    public function vaccino() {
    	return $this->hasMany (\App\Models\Vaccine\Vaccini::class, 'Codice_ATC' );
    }
    
}
