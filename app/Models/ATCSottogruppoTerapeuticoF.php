<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ATCSottogruppoTerapeuticoF extends Model
{
    protected $table = 'ATC_Sottogruppo_Terapeutico_F';
    protected $primaryKey = 'id_sottogruppoTF';
    public $timestamps = false;
    
    protected $casts = [
        'id_sottogruppoTF' => 'char',
        'Codice_Gruppo_Teraputico' => 'char',
        'ID_Gruppo_Anatomico' => 'char',
        'Descrizione' => 'string'
    ];
    
    protected $fillable = [
        'Descrizione',
        'Codice_Gruppo_Teraputico',
        'ID_Gruppo_Terapeutico'
        
    ];
    
    public function getID(){
        return $this->id_sottogruppoTF;
    }
    public function getCodiceGT(){
        return $this->Codice_Gruppo_Teraputico;
    }
    public function getID_GruppoT(){
        return $this->ID_Gruppo_Terapeutico;
    }
    
    public function getDesc(){
        return $this->Descrizione;
    }
    
    
    public function setID($id){
        $this->id_sottogruppoTF = $id;
    }
    public function setGT($gt){
        $this->Codice_Gruppo_Teraputico = $gt;
    }
    public function setID_GruppoT($id){
        $this->ID_Gruppo_Anatomico = $id;
    }
    public function getDesc($desc){
        $this->Descrizione = $desc;
    }
    
    public function gruppoTerapeutico() {
        return $this->belongsTo (\App\Models\ATCGruppoTerapeuticoP::class, 'ID_Gruppo_Terapeutico' );
    }
    
    public function sottogruppoChimicoTF() {
        return $this->hasMany (\App\Models\ATCSottogruppoChimicoTF::class, 'id_sottogruppoTF' );
    }
    
    
}
