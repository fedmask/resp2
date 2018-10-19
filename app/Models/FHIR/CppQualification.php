<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 19 Sep 2018 06:05:03 +0000.
 */

namespace App\Models\FHIR;
use App\Models\CodificheFHIR\QualificationCode;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class CppQualification
 *
 * @property int $id_cpp
 * @property string $Code
 * @property \Carbon\Carbon $Start_Period
 * @property \Carbon\Carbon $End_Period
 * @property string $Issuer
 *
 * @property \App\Models\QualificationCode $qualification_code
 * @property \App\Models\TblCareProvider $tbl_care_provider
 *
 * @package App\Models
 */
class CppQualification extends Eloquent
{
    protected $table = 'CppQualification';
    protected $primaryKey = 'id_cpp';
    public $incrementing = true;
    public $timestamps = false;
    
    protected $casts = [
        'id_cpp' => 'int'
    ];
    
    protected $dates = [
        'Start_Period',
        'End_Period'
    ];
    
    protected $fillable = [
        'id_cpp',
        'Code',
        'Start_Period',
        'End_Period',
        'Issuer'
    ];
    
    
    public function getIdCpp(){
        return $this->id_cpp;
    }
    
    public function getCode(){
        return $this->Code;
    }
    
    public function getQualificationDisplay(){
        return QualificationCode::where('Code', $this->getCode())->value('Display');
    }
    
    public function getStartPeriod(){
        $y = date_format($this->Start_Period,"Y");
        $m = date_format($this->Start_Period,"m");
        $d = date_format($this->Start_Period,"d");
        
        $date = "";
        
        if(checkdate($m , $d , $y)){
            $date = date_format($this->Start_Period,"Y-m-d");
        }
        return $date;
    }
    
    public function getEndPeriod(){
        $y = date_format($this->End_Period,"Y");
        $m = date_format($this->End_Period,"m");
        $d = date_format($this->End_Period,"d");
        
        $date = "";
        
        if(checkdate($m , $d , $y)){
            $date = date_format($this->End_Period,"Y-m-d");
        }
        return $date;
    }
    
    public function getIssuer(){
        return $this->Issuer;
    }
}
