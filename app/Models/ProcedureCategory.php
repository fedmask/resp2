<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProcedureCategory extends Model
{
    protected $table = 'tbl_proc_cat';
    protected $primaryKey = 'codice';
    public $incrementing = false;
    public $timestamps = false;
    
    
    
    protected $casts = [
        'descrizione' => 'string',
    ];
    
    
    protected $fillable = [
        'descrizione',
    ];
    
    
    
    public function getID(){
        return $this->codice;
    }
    public function getDesc(){
        return $this->descrizione;
    }
    
    public function setID($id){
        if(strlen($id) == 9 || strlen($id) == 8){
            $this->codice = $id;
        }
    }
    public function setDesc($desc){
        $this->descrizione = $desc;
    }
    
    
    public function Categoria(){
        return $this->hasMany(\App\Models\ProcedureTerapeutiche::class, 'Category');
    }
    
    
    
    
}
