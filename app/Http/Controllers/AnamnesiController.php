<?php

namespace App\Http\Controllers;



use App\Models\Gravidanza;
use App\Models\History\AnamnesiFisiologica;
use App\Models\History\AnamnesiPtProssima;
use App\Models\History\AnamnesiPtRemotum;
use App\Models\Icd9\Icd9GrupDiagCodici;
use App\Parente;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Anamnesi;
use App\Models\Patient\Pazienti;
use Auth;
use PDF;

class AnamnesiController extends Controller
{

    public function index()
    {

        $this->fillicd9gruopdiagcode();
        $this->setAnamnesi();
        $userid = Pazienti::where('id_utente', Auth::id())->first()->id_paziente;
        $user = Pazienti::where('id_utente', Auth::id())->first();
        $anamnesiFamiliare = Anamnesi::where('id_paziente', Auth::id())->get();
        $parente = Parente::where('id_paziente', Auth::id())->get();
        $anamnesiFisiologica = AnamnesiFisiologica::where('id_paziente', Auth::id())->first();
        $anamnesiPatologicaRemota = AnamnesiPtRemotum::where('id_paziente', Auth::id())->get();
        $anamnesiPatologicaProssima = AnamnesiPtProssima::where('id_paziente', Auth::id())->get();
        $icd9groupcode = Icd9GrupDiagCodici::orderBy('codice')->get();
        $gravidanza = Gravidanza::where('id_paziente', Auth::id())->get();
        $printthis = false;
        return view('pages.anamnesi',compact('user','userid','anamnesiFamiliare', 'parente', 'anamnesiFisiologica', 'anamnesiPatologicaRemota', 'anamnesiPatologicaProssima', 'icd9groupcode', 'gravidanza', 'printthis'));
    }

    public function fillicd9gruopdiagcode(){

        $group = Icd9GrupDiagCodici::find('a');
        if($group != null){
            return false;
        }else{
            $group = new Icd9GrupDiagCodici;
            $group->codice = 'a';
            $group->gruppo_descrizione = "MALATTIE INFETTIVE E PARASSITARIE";
            $group->save();
            $group = new Icd9GrupDiagCodici;
            $group->codice = 'b';
            $group->gruppo_descrizione = "TUMORI";
            $group->save();
            $group = new Icd9GrupDiagCodici;
            $group->codice = 'c';
            $group->gruppo_descrizione = "MALATTIE ENDOCRINE NUTRIZIONALI, METABOLICHE E DISTURBI IMMUNITARI";
            $group->save();
            $group = new Icd9GrupDiagCodici;
            $group->codice = 'd';
            $group->gruppo_descrizione = "MALATTIE DEL SANGUE E DEGLI ORGANI EMATOPOIETICI";
            $group->save();
            $group = new Icd9GrupDiagCodici;
            $group->codice = 'e';
            $group->gruppo_descrizione = "DISTURBI MENTALI";
            $group->save();
            $group = new Icd9GrupDiagCodici;
            $group->codice = 'f';
            $group->gruppo_descrizione = "MALATTIE DEL SISTEMA NERVOSO E DEGLI ORGANI DEI SENSI";
            $group->save();
            $group = new Icd9GrupDiagCodici;
            $group->codice = 'g';
            $group->gruppo_descrizione = "MALATTIE DEL SISTEMA CIRCOLATORIO";
            $group->save();
            $group = new Icd9GrupDiagCodici;
            $group->codice = 'h';
            $group->gruppo_descrizione = "MALATTIE DELL'APPARATO RESPIRATORIO";
            $group->save();
            $group = new Icd9GrupDiagCodici;
            $group->codice = 'i';
            $group->gruppo_descrizione = "MALATTIE DELL'APPARATO DIGERENTE";
            $group->save();
            $group = new Icd9GrupDiagCodici;
            $group->codice = 'l';
            $group->gruppo_descrizione = "MALATTIE DEL SISTEMA GENITOURINARIO";
            $group->save();
            $group = new Icd9GrupDiagCodici;
            $group->codice = 'm';
            $group->gruppo_descrizione = "COMPLICAZIONI DELLA GRAVIDANZA DEL PARTO E DEL PUERPERIO";
            $group->save();
            $group = new Icd9GrupDiagCodici;
            $group->codice = 'n';
            $group->gruppo_descrizione = "MALATTIE DELLA CUTE E DEL TESSUTO SOTTOCUTANEO";
            $group->save();
            $group = new Icd9GrupDiagCodici;
            $group->codice = 'o';
            $group->gruppo_descrizione = "MALATTIE DEL SISTEMA OSTEOMUSCOLARE E DEL TESSUTO CONNETTIVO";
            $group->save();
            $group = new Icd9GrupDiagCodici;
            $group->codice = 'p';
            $group->gruppo_descrizione = "MALFORMAZIONI CONGENITE";
            $group->save();
            $group = new Icd9GrupDiagCodici;
            $group->codice = 'q';
            $group->gruppo_descrizione = "ALCUNE MANIFESTAZIONI MORBOSE DI ORIGINE PERINATALE";
            $group->save();
            $group = new Icd9GrupDiagCodici;
            $group->codice = 'r';
            $group->gruppo_descrizione = "SINTOMI, SEGNI E STATI MORBOSI MAL DEFINITI";
            $group->save();
            $group = new Icd9GrupDiagCodici;
            $group->codice = 's';
            $group->gruppo_descrizione = "TRAUMATISMI E AVVELENAMENTI";
            $group->save();
            $group = new Icd9GrupDiagCodici;
            $group->codice = 't';
            $group->gruppo_descrizione = "ALTRO";
            $group->save();
            $group = new Icd9GrupDiagCodici;
            $group->codice = 'u';
            $group->gruppo_descrizione = "CLASSIFICAZIONE SUPPLEMENTARE DEI FATTORI CHE INFLUENZANO LO STATO DI SALUTE E IL RICORSO AI SERVIZI SANITARI";
            $group->save();
            return true;
        }
    }

    public function setAnamnesi(){

        $userid = Pazienti::where('id_utente', Auth::id())->first()->id_paziente;
        $anamnesiFisiologica = AnamnesiFisiologica::where('id_paziente', Auth::id())->first();
        $anamnesiPatologicaRemota = AnamnesiPtRemotum::where('id_paziente', Auth::id())->first();
        $anamnesiPatologicaProssima = AnamnesiPtProssima::where('id_paziente', Auth::id())->first();

        if($anamnesiFisiologica == null){

            $fisiologica = new AnamnesiFisiologica;
            $fisiologica->id_paziente = $userid;
            $fisiologica->dataAggiornamento = Carbon::now();
            $fisiologica->save();
        }

        if($anamnesiPatologicaRemota == null){

            $remota = new AnamnesiPtRemotum;
            $remota->id_paziente = $userid;
            $remota->save();
        }
        if($anamnesiPatologicaProssima == null){

            $prossima = new AnamnesiPtProssima;
            $prossima->id_paziente = $userid;
            $prossima->save();
        }
    }

    public function store(Request $request)
    {
        $input = request()->input_name;

        switch ($input){
            case "Familiare":
                $this->storeFamiliare($request);
                break;
            case "Parente":
                $this->storeParenti($request);
                break;
            case "Fisiologica":
                $this->storeFisiologica($request);
                break;
            case "PatologicaRemota":
                $this->storePatologicaRemota($request);
                break;
            case "PatologicaProssima":
                $this->storePatologicaProssima($request);
                break;
            case "SpostaPatologicaProssima":
                $this->spostaPatologicaProssima($request);
                break;
            case "icd9groupcodeRemota":
                $this->storeicd9groupcodeRemota($request);
                break;
            case "icd9groupcodeProssima":
                $this->storeicd9groupcodeProssima($request);
                break;
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

    public function storeFisiologica(Request $request){

        $userid = Pazienti::where('id_utente', Auth::id())->first()->id_paziente;
        $fisiologica = AnamnesiFisiologica::find($userid);

        if(isset($fisiologica->id_paziente)){
            $fisiologica->delete();
        }



        $fisiologica = new AnamnesiFisiologica;
        $fisiologica->id_paziente = $userid;
        $fisiologica->dataAggiornamento = Carbon::now();

        //Infanzia
        $fisiologica->tempoParto = $request->get('parto');
        $fisiologica->tipoParto = $request->get('tipoparto');
        $fisiologica->allattamento = $request->get('allattamento');
        $fisiologica->sviluppoVegRel = $request->get('sviluppoVegRel');
        $fisiologica->noteInfanzia = $request->input('noteinfanzia');

        //Scolarità
        $fisiologica->livelloScol = $request->get('livelloScol');

        //Ciclo Mestruale
        $fisiologica->etaMenarca = $request->get('etaMenarca');
        $fisiologica->ciclo = $request->get('ciclo');
        $fisiologica->etaMenopausa = $request->input('etaMenopausa');
        $fisiologica->menopausa = $request->get('menopausa');
        $fisiologica->noteCicloMes = $request->input('noteCicloMes');

        //Stile di vita
        $fisiologica->attivitaFisica = $request->input('attivitaFisica');
        $fisiologica->abitudAlim = $request->input('abitudAlim');
        $fisiologica->ritmoSV = $request->input('ritmoSV');
        $fisiologica->fumo = $request->get('fumo');
        $fisiologica->freqFumo = $request->input('freqFumo');
        $fisiologica->alcool = $request->get('alcool');
        $fisiologica->freqAlcool = $request->input('freqAlcool');
        $fisiologica->droghe = $request->get('droghe');
        $fisiologica->freqDroghe = $request->input('freqDroghe');
        $fisiologica->noteStileVita = $request->input('noteStileVita');

        //Alvo e minzione
        $fisiologica->alvo = $request->get('alvo');
        $fisiologica->minzione = $request->get('minzione');
        $fisiologica->noteAlvoMinz = $request->input('noteAlvoMinz');

        //Professione
        $fisiologica->professione = $request->input('professione');
        $fisiologica->noteAttLav = $request->input('noteAttLav');

        $fisiologica->save();

        //Gravidanza
        if(($request->get('esito') != null) or ($request->input('etaGravidanza') != null) or ($request->input('dataInizioGrav') != null) or
            ($request->input('dataFineGrav') != null) or ($request->get('sessoBambino') != null) or ($request->input('noteGravidanza') != null)){

            $gravidanza = new Gravidanza;
            $gravidanza->id_paziente = $userid;
            $gravidanza->esito = $request->get('esito');
            $gravidanza->eta = $request->input('etaGravidanza');
            $gravidanza->inizio_gravidanza = $request->input('dataInizioGrav');
            $gravidanza->fine_gravidanza = $request->input('dataFineGrav');
            $gravidanza->sesso_bambino = $request->get('sessoBambino');
            $gravidanza->note_gravidanza = $request->input('noteGravidanza');
            $gravidanza->save();
        }



        return redirect('/anamnesi');
    }



    public function storePatologicaRemota(Request $request){

        $userid = Pazienti::where('id_utente', Auth::id())->first()->id_paziente;
        $anamnesi = AnamnesiPtRemotum::find($userid);
        $oldanamPtRemota = $anamnesi->icd9_group_code;

        if(isset($anamnesi->id_paziente)){
            $anamnesi->delete();
        }

        //Create Anamensi
        $anamnesi = new AnamnesiPtRemotum;
        $anamnesi->id_paziente = $userid;
        $anamnesi->anamnesi_remota_contenuto = $request->input('testopat');
        $anamnesi->icd9_group_code = $oldanamPtRemota;
        $anamnesi->save();

        return redirect('/anamnesi');
    }

    public function storeicd9groupcodeRemota(Request $request){

        $userid = Pazienti::where('id_utente', Auth::id())->first()->id_paziente;
        $anamnesiPtRemota = AnamnesiPtRemotum::find($userid);
        $oldanamPtRemota = $anamnesiPtRemota->anamnesi_remota_contenuto;

        $anamnesiPtRemota->delete();

        $anamnesiPtRemota = new AnamnesiPtRemotum;
        $anamnesiPtRemota->id_paziente = $userid;
        $anamnesiPtRemota->anamnesi_remota_contenuto = $oldanamPtRemota;


        if($request->get('icd9groupcode') != null){
            $anamnesiPtRemota->icd9_group_code = implode("_",$request->get('icd9groupcode')) . "_";
        }

        $anamnesiPtRemota->save();



        return redirect('/anamnesi');
    }

    public function storePatologicaProssima(Request $request){

        $userid = Pazienti::where('id_utente', Auth::id())->first()->id_paziente;
        $anamnesi = AnamnesiPtProssima::find($userid);
        $oldanamPtRemota = $anamnesi->icd9_group_code;

        if(isset($anamnesi->id_paziente)){
            $anamnesi->delete();
        }

        //Create Anamensi
        $anamnesi = new AnamnesiPtProssima();
        $anamnesi->id_paziente = $userid;
        $anamnesi->anamnesi_prossima_contenuto = $request->input('testopatpp');
        $anamnesi->icd9_group_code = $oldanamPtRemota;
        $anamnesi->save();

        return redirect('/anamnesi');
    }

    public function storeicd9groupcodeProssima(Request $request){

        $userid = Pazienti::where('id_utente', Auth::id())->first()->id_paziente;
        $anamnesiPtProssima = AnamnesiPtProssima::find($userid);
        $oldanamPtProssima = $anamnesiPtProssima->anamnesi_prossima_contenuto;

        $anamnesiPtProssima->delete();

        $anamnesiPtProssima = new AnamnesiPtProssima;
        $anamnesiPtProssima->id_paziente = $userid;
        $anamnesiPtProssima->anamnesi_prossima_contenuto = $oldanamPtProssima;

        if($request->get('icd9groupcode') != null){
            $anamnesiPtProssima->icd9_group_code = implode("_",$request->get('icd9groupcode')) . "_";
        }



        $anamnesiPtProssima->save();



        return redirect('/anamnesi');
    }

    public function spostaPatologicaProssima(Request $request){

        $userid = Pazienti::where('id_utente', Auth::id())->first()->id_paziente;
        $anamnesiPtProssima = AnamnesiPtProssima::find($userid);
        $anamnesiPtRemota = AnamnesiPtRemotum::find($userid);
        $oldanamPtRemota_cont = $anamnesiPtRemota->anamnesi_remota_contenuto;
        $oldanamPtRemota_icd9 = $anamnesiPtRemota->icd9_group_code;
        $oldanamPtProssima_icd9 = $anamnesiPtProssima->icd9_group_code;

        $anamnesiPtRemota->delete();

        $anamnesiPtRemota = new AnamnesiPtRemotum;
        $anamnesiPtRemota->id_paziente = $userid;

        if ($request->input('testoSposta') != null) {
            $anamnesiPtRemota->anamnesi_remota_contenuto = $oldanamPtRemota_cont . ', ' . $request->input('testoSposta');
        } else {
            $anamnesiPtRemota->anamnesi_remota_contenuto = $oldanamPtRemota_cont;
        }

        if ($request->get('icd9groupcode') != null) {
            foreach ($request->get('icd9groupcode') as $key => $value) {
                if (!strstr($oldanamPtRemota_icd9, $value)) {
                    $oldanamPtRemota_icd9 = $oldanamPtRemota_icd9 . $value . "_";
                }
            }
        }

        $newanamPtRemota_icd9 = $oldanamPtRemota_icd9;
        $anamnesiPtRemota->icd9_group_code = $newanamPtRemota_icd9;
        $anamnesiPtRemota->save();

        $anamnesiPtProssima->delete();

        if ($request->get('icd9groupcode') != null) {
            foreach ($request->get('icd9groupcode') as $key => $value) {
                if (strstr($oldanamPtProssima_icd9, $value)) {
                    $oldanamPtProssima_icd9 = str_replace($value . "_", "", $oldanamPtProssima_icd9);
                }
            }
        }

        $newanamPtProssima_icd9 = $oldanamPtProssima_icd9;
        if($newanamPtProssima_icd9 != " "){
            $anamPtProssima = new AnamnesiPtProssima;
            $anamPtProssima->id_paziente = $userid;
            $anamPtProssima->icd9_group_code = $newanamPtProssima_icd9;
            $anamPtProssima->save();
        }

        return redirect('/anamnesi');
    }

    public function update(Request $request, $id){

        $input = request()->input_name;

        switch ($input) {
            case "UpdateParente":
                $this->updateParente($request, $id);
                break;
            case "UpdateGravidanze";
                $this->updateGravidanze($request, $id);
                break;
        }

        return redirect('/anamnesi');
    }

    public function updateParente(Request $request, $id){

        $parente = Parente::find($id);
        $parente->nome = $request->input('nome_componente');
        $parente->grado_parentela = $request->get('grado_parentela');
        $parente->sesso = $request->get('sesso');
        $parente->età = $request->input('età');
        $parente->data_decesso = $request->input('data_decesso');
        $parente->annotazioni = $request->input('annotazioni');
        $parente->annotazioni = $request->input('annotazioni');
        $parente->save();

        return redirect('/anamnesi');
    }

    public function updateGravidanze($request, $id){

        $gravidanza = Gravidanza::find($id);
        $gravidanza->esito = $request->get('esito');
        $gravidanza->eta = $request->input('etaGravidanza');
        $gravidanza->inizio_gravidanza = $request->input('dataInizioGrav');
        $gravidanza->fine_gravidanza = $request->input('dataFineGrav');
        $gravidanza->sesso_bambino = $request->get('sessoBambino');
        $gravidanza->note_gravidanza = $request->input('noteGravidanza');
        $gravidanza->save();
        return redirect('/anamnesi');
    }

    public function delete($id){

        $input = request()->input_name;

        switch ($input) {
            case "DeleteParente":
                $this->deleteParente($id);
                break;
            case "DeleteGravidanze":
                $this->deleteGravidanze($id);
                break;
        }

        return redirect('/anamnesi');
    }

    public function deleteParente($id){

        $parente = Parente::find($id);
        $parente->delete();

        return redirect('/anamnesi');
    }

    public function deleteGravidanze($id){

        $gravidanza = Gravidanza::find($id);
        $gravidanza->delete();

        return redirect('/anamnesi');
    }

    public function printAnamnesi(){

        $anamnesiFamiliare = Anamnesi::where('id_paziente', Auth::id())->get();
        $parente = Parente::where('id_paziente', Auth::id())->get();
        $anamnesiFisiologica = AnamnesiFisiologica::where('id_paziente', Auth::id())->first();
        $anamnesiPatologicaRemota = AnamnesiPtRemotum::where('id_paziente', Auth::id())->get();
        $anamnesiPatologicaProssima = AnamnesiPtProssima::where('id_paziente', Auth::id())->get();
        $gravidanza = Gravidanza::where('id_paziente', Auth::id())->get();
        $printthis = true;

        $data = compact('anamnesiFamiliare', 'parente', 'anamnesiFisiologica', 'anamnesiPatologicaRemota', 'anamnesiPatologicaProssima', 'gravidanza', 'printthis');

        $pdf = PDF::loadView('pages.anamnesi_print', $data);
        return $pdf->stream('result.pdf');
    }



}
