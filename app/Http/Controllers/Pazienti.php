<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;

class Pazienti extends Model
{
    protected $table        = 'tbl_pazienti';
    protected $primaryKey   = "id_paziente";
    
    public function contacts(){
        return $this->belongsTo("App\Http\Controllers\Contatti", "id_paziente");
    }
    
    public function list(){
        $patient = $this::find(1);
       
        echo $patient->paziente_nome . "<- dalla tabella tbl_pazienti";
        echo $patient->contacts->paziente_telefono . "<- dalla tabella tbl_pazienti_contatti";
    }
}
