<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ATCGruppoTerapeuticoP extends Model
{
    protected $table = 'ATC_Gruppo_Terapeutico_P';
    protected $primaryKey = 'Codice_Gruppo_Teraputico';
    public $timestamps = false;
    
    protected $casts = [
        'Codice_Gruppo_Teraputico' => 'char',
        'Codice_GTP' => 'char',
        'ID_Gruppo_Anatomico' => 'char',
        'Descrizione' => 'string'
    ];
    
    protected $fillable = [
        'Descrizione',
        'Codice_GTP',
        'ID_Gruppo_Anatomico'
        
    ];
    
    public function getID(){
        return $this->Codice_Gruppo_Teraputico;
    }
    public function getCodiceGPT(){
        return $this->Codice_GTP;
    }
    public function getID_GruppoA(){
        return $this->ID_Gruppo_Anatomico;
    }
    
    public function getDesc(){
        return $this->Descrizione;
    }
    
    
    public function setID($id){
        $this->Codice_Gruppo_Teraputico = $id;
    }
    public function setGPT($gpt){
        $this->Codice_GTP = $gpt;
    }
    public function setID_GruppoA($id){
        $this->ID_Gruppo_Anatomico = $id;
    }
    public function getDesc($desc){
        $this->Descrizione = $desc;
    }
    
    
    public function gruppoAnatomico() {
        return $this->belongsTo (\App\Models\ATCGruppoAnatomicoP::class, 'ID_Gruppo_Anatomico' );
    }
    
    public function sottogruppoTerapeutico() {
        return $this->hasMany (\App\Models\ATCSottogruppoTerapeuticoF::class, 'Codice_Gruppo_Teraputico' );
    }
    
}
