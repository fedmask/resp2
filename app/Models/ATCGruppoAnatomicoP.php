<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ATCGruppoAnatomicoP extends Model
{
    protected $table = 'tbl_Gruppo_Anatomico_P';
    protected $primaryKey = 'ID_Gruppo_Anatomico';
    public $timestamps = false;
    
    protected $casts = [
        'ID_Gruppo_Anatomico' => 'char',
        'Descrizione' => 'string'
    ];
    
    protected $fillable = [
        'Descrizione'
        
    ];
    
    public function getID(){
        return $this->ID_Gruppo_Anatomico;
    }
    public function getDesc(){
        return $this->Descrizione;
    }
    
    
    public function setID($id){
        $this->ID_Gruppo_Anatomico = $id;
    }
    public function getDesc($desc){
         $this->Descrizione = $desc;
    }
    
    
    public function gruppoTerapeutico() {
        return $this->hasMany (\App\Models\ATCGruppoTerapeuticoP::class, 'ID_Gruppo_Anatomico' );
    }
    
    
}
