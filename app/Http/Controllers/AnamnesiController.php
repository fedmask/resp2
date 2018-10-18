<?php

namespace App\Http\Controllers;

use App\Parente;
use Illuminate\Http\Request;
use App\Models\Anamnesi;
use App\Models\Patient\Pazienti;
use Auth;

class AnamnesiController extends Controller
{

    public function index()
    {

        $userid = Pazienti::where('id_utente', Auth::id())->first()->id_paziente;
        $anamnesiFamiliare = Anamnesi::where('id_paziente', Auth::id())->get();
        $parente = Parente::where('id_paziente', Auth::id())->get();

        return view('pages.anamnesi',compact('userid','anamnesiFamiliare', 'parente'));
    }


    public function store(Request $request)
    {
        if(request()->input_name == 'Familiare') {

            $this->storeFamiliare($request);

        }else if(request()->input_name == 'Parente') {

            $this->storeParenti($request);
        }

        return redirect('/anamnesi');
    }

    public function storeFamiliare(Request $request){

        $userid = Pazienti::where('id_utente', Auth::id())->first()->id_paziente;
        $anamnesi = Anamnesi::find($userid);
        if(isset($anamnesi->id_paziente)){
            $anamnesi->delete();
        }

        //Create Anamensi
        $anamnesi = new Anamnesi;
        $anamnesi->id_paziente = $userid;
        $anamnesi->id_anamnesi_log = 123;
        $anamnesi->anamnesi_contenuto = $request->input('testofam');
        $anamnesi->save();

        return redirect('/anamnesi');

    }

    public function storeParenti(Request $request){

        $parente = new Parente;
        $parente->id_paziente = Pazienti::where('id_utente', Auth::id())->first()->id_paziente;
        $parente->nome = $request->input('nome_componente');
        $parente->grado_parentela = $request->get('grado_parentela');
        $parente->sesso = $request->get('sesso');
        $parente->età = $request->input('età');
        $parente->data_decesso = $request->input('data_decesso');
        $parente->annotazioni = $request->input('annotazioni');
        $parente->save();

        return redirect('/anamnesi');
    }


}
