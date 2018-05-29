<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
class CppSpecialization extends Model
{
    protected $table = 'tbl_cpp_specialization';
    protected $primaryKey = 'id_cpp_specialization';
    public $incrementing = false;
    public $timestamps = false;
    
    
    
    protected $casts = [
        'id_cpp_specialization' => 'int',
        'id_specialization' => 'int',
        'id_cpp' => 'int'
    ];
    
    
    protected $fillable = [
        'id_specialization',
         'id_cpp'
    ];
    
    public function getID(){
        return $this->id_cpp_specialization;
    }
    
    public function getIdSpec(){
        return $this->id_specialization;
    }
    public function getIdCpp(){
        return $this->id_cpp;
    }
    
    public function setIdSpec($id){
        $this->id_specialization = $id;
    }
    public function setIdCpp($cpp){
        $this->id_cpp = $cpp;
    }
    
    public function getSpecializzation() {
    	return $this->Specialization ()->first ()->getDesc ();
    }
    public function getCpp() {
    	return $this->CareProvider()->first ()->getID ();
    }
    
    public function Specialization(){
        return $this->belongsTo(\App\Models\Specialization::class, 'id_spec');
    }
    
    public function CareProvider(){
        return $this->belongsTo(\App\Models\CareProviders\CareProvider::class, 'id_cpp');
    }
}
