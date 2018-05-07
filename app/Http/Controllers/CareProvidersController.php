<?php

namespace App\Http\Controllers;

use App\Models\CareProviders\CppPaziente;
use App\Models\Patient\Pazienti;
use Auth;
use Illuminate\Http\Request;
use Redirect;

class CareProvidersController extends Controller
{

    /**
     * Serve ad associare un cpp all'utente loggato
     */
    public function associaCpp($getvalue)
    {
        $arrayCpp = array();
        $arrayCpp = CppPaziente::all();
        $val = false;
        
        foreach($arrayCpp as $cpp){
            if($cpp->id_cpp == $getvalue){
                $val = true;
            }
        }
        
        if($val){
            return Redirect::back();
        }else{
            $cpp = CppPaziente::create([
                'id_cpp'=> $getvalue,
                'id_paziente'=> Pazienti::where('id_utente', Auth::id())->first()->id_paziente,
                'assegnazione_confidenzialita'=> '1'
            ]);
            
            $cpp->save();
            return Redirect::back();
        }
    }
    
    /**
     * Serve a modificare la confidenzialità tra l'utente loggato e il cpp selezionato
     */
    public function modificaConfidenzialita($getValue, $getIdUser, $getIdCpp)
    {
        $match = ['id_cpp' => $getIdCpp, 'id_paziente' => $getIdUser];
        
        $edited_character = \DB::table('tbl_cpp_paziente')->where($match)->update([
            'assegnazione_confidenzialita' => $getValue            
        ]);
         return Redirect::back();
    }
    
    /**
     * Serve a rimuovere la confidenzialità tra l'utente loggato e il cpp selezionato
     */
    public function rimuoviConfidenzialita($getConf, $getIdUser, $getIdCpp)
    {
        $match = ['id_cpp' => $getIdCpp, 'id_paziente' => $getIdUser, 'assegnazione_confidenzialita' => $getConf];
        
        $edited_character = \DB::table('tbl_cpp_paziente')->where($match)->delete();
        
        return Redirect::back();
    }
}