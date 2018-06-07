<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProcedureOutCome extends Model
{
    
    protected $table = 'tbl_proc_outcome';
    protected $primaryKey = 'codice';
    public $incrementing = true;
    public $timestamps = false;
    
    
    protected $casts = [
        'codice' => 'int',
        'descrizione'=>'string'
        
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
         $this->codice = $id;
    }
    public function setDesc($desc){
        $this->descrizione = $desc;
    }
    
    
    public function Outcome()
    {
        return $this->hasMany(\App\Models\ProcedureTerapeutiche::class, 'outCome');
    }
}
