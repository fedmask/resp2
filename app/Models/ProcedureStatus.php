<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProcedureStatus extends Model
{
    protected $table = 'tbl_proc_status';
    protected $primaryKey = 'codice';
    public $incrementing = true;
    public $timestamps = false;
    
    
    //$casts permette di convertire gli attributi di un db in tipo di dato comune
    protected $casts = [
        'codice' => 'int',
        
    ];
    
  
    protected $fillable = [
        'descrizione',
        
    ];
    
    public function getID(){
        return $this->codice;
    }
    public function getDesc(){
        return $this->desc;
    }
    
    public function setID($id){
        $this->codice = $id;
    }
    public function setDesc($desc){
        $this->descrizione = $desc;
    }
    
    public function Status()
    {
        return $this->hasMany(\App\Models\ProcedureTerapeutiche::class, 'Status');
    }
    
    
    
    
}
