<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ATCSottogruppoChimicoTF extends Model
{
    protected $table = 'ATC_Sottogruppo_Chimico_TF';
    protected $primaryKey = 'id_sottogruppoCTF';
    public $timestamps = false;
    
    protected $casts = [
        'id_sottogruppoCTF' => 'char',
        'Codice_Sottogruppo_Teraputico' => 'char',
        'ID_Sottogruppo_Terapeutico' => 'char',
        'Descrizione' => 'string'
    ];
    
    protected $fillable = [
        'Descrizione',
        'Codice_Sottogruppo_Teraputico',
        'ID_Sottogruppo_Terapeutico'
        
    ];
    
    public function getID(){
        return $this->id_sottogruppoCTF;
    }
    public function getCodiceST(){
        return $this->Codice_Sottogruppo_Teraputico;
    }
    public function getID_SottogruppoT(){
        return $this->ID_Sottogruppo_Terapeutico;
    }
    
    public function getDesc(){
        return $this->Descrizione;
    }
    
    
    public function setID($id){
        $this->id_sottogruppoCTF = $id;
    }
    public function setST($st){
        $this->Codice_Sottogruppo_Teraputico = $st;
    }
    public function setID_SottogruppoT($id){
        $this->ID_Sottogruppo_Terapeutico = $id;
    }
    public function getDesc($desc){
        $this->Descrizione = $desc;
    }
    
    public function sottogruppoTerapeutico() {
        return $this->belongsTo (\App\Models\ATCSottogruppoTerapeuticoF::class, 'ID_Sottogruppo_Terapeutico' );
    }
    
    public function sottogruppoChimico() {
        return $this->hasMany (\App\Models\ATCSottogruppoChimico::class, 'id_sottogruppoCTF' );
    }
}
