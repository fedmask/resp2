<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Specialization extends Model
{
    protected $table = 'tbl_specialization';
    protected $primaryKey = 'id_spec';
    public $incrementing = false;
    public $timestamps = false;
    
    protected $casts = [
        'id_spec' => 'int',
        'desc_specialization' => 'string'
    ];
    
 
    protected $fillable = [
        'desc_specialization'
    ];
    
    public function getIdSpec(){
        return $this->id_spec;
    }
    
    public function getDesc(){
        return $this->desc_specialization;
    }
    
    public function setIdSpec($id){
         $this->id_spec = $id;
    }
    public function setDesc($desc){
        $this->desc_specialization = $desc;
    }
    
    public function Cpp_Specialization(){
        return $this->hasMany(\App\Models\CppSpecialization::class, 'id_specialization');
    }
    
    public function Visita_Spec(){
        return $this->hasMany(\App\Models\VisitaSpecialization::class, 'id_specialization');
    }
    
    
    
    
    
    
    
}
