<?php
namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Patient\Pazienti;
use App\Models\CareProviders\CppPaziente;
use App\Models\Patient\PazientiVisite;
use App\Models\Log\AuditlogLog;
use App\Models\Patient\ParametriVitali;
use App\Models\CurrentUser\User;
use App\Models\CurrentUser\Recapiti;
use App\Models\Domicile\Comuni;
use App\Models\Patient\Taccuino;
use Validator;
use Redirect;
use Auth;
use DB;
use Input;

class VisiteController extends Controller
{


    
    /**
     * Funzione che permette di aggiungere una nuova visita
     */
    public function addVisita()
    {
        $flag=true;

        $paziente = Pazienti::where('id_paziente', Auth::id())->first()->id_paziente;

        $prova = CppPaziente::all();


        $cpp;

        foreach($prova as $p){

            if($p->id_paziente == $paziente){
                $cpp = $p->id_cpp;
            }
        }


        $validator = Validator::make(Input::all(), [
            'add_visita_data' => 'required|date_format:Y-m-d',
            'add_visita_motivazione' => 'required|string',
            'add_visita_osservazioni' =>'required|string',
            'add_visita_conclusioni' =>'required|string',
            'add_parametro_altezza'=>'required|integer',
            'add_parametro_peso'=>'required|integer',
            'add_parametro_pressione_minima'=>'required|integer',
            'add_parametro_pressione_massima'=>'required|integer',
            'add_parametro_frequenza_cardiaca'=>'required|integer'
        ]);



        if ($validator->fails()) {

            $flag=false;

            return Redirect::back()->withErrors($validator);
        }


        $visita = PazientiVisite::create([

            'id_paziente'=> Pazienti::where('id_utente', Auth::id())->first()->id_paziente,
            'status'=>'finished',      //see encounterStatus table
            'class' => 'AMB',              //see encounterClass table
            'start_period'=> Input::get('add_visita_data'),
            'end_period'=>Input::get('add_visita_data'),
            'reason'=>109006,      //see encounterReason table
            'id_cpp'=> $cpp,
            'visita_data'=> Input::get('add_visita_data'),
            'visita_motivazione'=> Input::get('add_visita_motivazione'),
            'visita_osservazioni'=>Input::get('add_visita_osservazioni'),
            'visita_conclusioni'=>Input::get('add_visita_conclusioni'),
            'codice_priorità'=>1
        ]);
        
        
        
        $paz = Pazienti::all();
        $audit = AuditlogLog::all();
        $f;

        foreach($paz as $p){
            foreach($audit as $a){
                if($p->id_utente == $a->id_visitato){
                    $f=$a->id_audit;

                }
            }
        }
        
        $parametri = ParametriVitali::Create([
            'id_paziente'=> Pazienti::where('id_utente', Auth::id())->first()->id_paziente,
            'id_audit_log'=>$f,
            'parametro_altezza'=> Input::get('add_parametro_altezza'),
            'parametro_peso'=> Input::get('add_parametro_peso'),
            'parametro_pressione_minima'=> Input::get('add_parametro_pressione_minima'),
            'parametro_pressione_massima'=> Input::get('add_parametro_pressione_massima'),
            'parametro_frequenza_cardiaca'=> Input::get('add_parametro_frequenza_cardiaca')
        ]);


        $parametri->save();
        $visita->save();

        return Redirect::back()->with('visita_added');
    }
}
