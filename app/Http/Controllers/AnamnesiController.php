<?php

namespace App\Http\Controllers;



use App\Models\Gravidanza;
use App\Models\History\AnamnesiFisiologica;
use App\Models\History\AnamnesiPtProssima;
use App\Models\History\AnamnesiPtRemotum;
use App\Models\Icd9\Icd9GrupDiagCodici;
use App\Models\Parente;
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

    public function printAnamnesi(Request $request){

        $user = Pazienti::where('id_utente', Auth::id())->first();
        $parente = Parente::where('id_paziente', Auth::id())->get();
        $gravidanza = Gravidanza::where('id_paziente', Auth::id())->get();

        //PRINT ANAMNESI FAMILIARE
        $anamFamiliare_cont  = $request->input('anamFamiliare');

        $Parente = "";
        foreach($parente as $p){
            if($request->input('anamAnnotazioni'.$p->id_parente) != null or $request->input('anamEta'.$p->id_parente)) {
                $Parente = $Parente . $request->input('anamAnnotazioni' . $p->id_parente) . " a " . $p->grado_parentela . " a " . $request->input('anamEta' . $p->id_parente) . " anni" . "<br>";
            }
        }

        $anamnesifamiliare = "";
        if($anamFamiliare_cont != null or $Parente != null)
            $anamnesifamiliare = "<h2>Anamnesi familiare</h2><hr> " . $anamFamiliare_cont . "<br>" . $Parente;

        //PRINT ANAMNESI FISIOLOGICA
        $parto = "";
        if($request->input('Parto') != null){
           $parto = "Nato da parto " . $request->input('Parto') . ", ";
        }

        $tipoParto = "";
        if($request->input('tipoParto') != null){
            $tipoParto = "tipo parto " . $request->input('tipoParto') . ", ";
        }

        $allattamento = "";
        if($request->input('Allattamento') != null){
            $allattamento = "allattamento " . $request->input('Allattamento') . ", ";
        }

        $sviluppoVegRel = "";
        if($request->input('sviluppoVegRel') != null){
            $sviluppoVegRel= "sviluppo vegetativo e relazionale: " . $request->input('sviluppoVegRel') . ", ";
        }

        $noteInfanzia = "";
        if($request->input('noteInfanzia') != null){
            $noteInfanzia= "note infanzia " . $request->input('noteInfanzia') . ".<br>";
        }

        $livelloScol = "";
        if($request->input('livScol') != null){
            $livelloScol= "Livello scolastico " . $request->input('livScol') . ".<br>";
        }

        $attivitaFisica = "";
        if($request->input('attivitaFisica') != null){
            $attivitaFisica= "Attività fisica " . $request->input('attivitaFisica') . ", ";
        }

        $abitudAlim = "";
        if($request->input('abitudAlim') != null){
            $abitudAlim= "abitudini alimentari " . $request->input('abitudAlim') . ", ";
        }

        $fumo = "";
        if($request->input('fumo') != null){
            $fumo= "fumo " . $request->input('fumo') . ", ";
        }

        $freqFumo = "";
        if($request->input('freqFumo') != null){
            $freqFumo= "con una frequenza/quantità di " . $request->input('freqFumo') . ", ";
        }

        $alcool = "";
        if($request->input('alcool') != null){
            $alcool= "alcool " . $request->input('alcool') . ", ";
        }

        $freqAlcool = "";
        if($request->input('freqAlcool') != null){
            $freqAlcool= "con una frequenza/quantità di " . $request->input('freqAlcool') . ", ";
        }

        $droghe = "";
        if($request->input('droghe') != null){
            $droghe= "droghe " . $request->input('droghe') . ", ";
        }

        $freqDroghe = "";
        if($request->input('freqDroghe') != null){
            $freqDroghe= "con una frequenza/quantità di " . $request->input('freqDroghe') . ", ";
        }

        $noteStileVita = "";
        if($request->input('noteStileVita') != null){
            $noteStileVita= "note stile di vita " . $request->input('noteStileVita') . ".<br>";
        }

        $professione = "";
        if($request->input('professione') != null){
            $professione= "Professione </strong>" . $request->input('professione') . ", ";
        }

        $noteAttLav = "";
        if($request->input('noteAttLav') != null){
            $noteAttLav= "note professione " . $request->input('noteAttLav') . ".<br>";
        }

        $alvo = "";
        if($request->input('alvo') != null){
            $alvo= "Alvo " . $request->input('alvo') . ", ";
        }

        $minzione = "";
        if($request->input('minzione') != null){
            $minzione= "minzione " . $request->input('minzione') . ", ";
        }

        $noteAlvoMinz = "";
        if($request->input('noteAlvoMinz') != null){
            $noteAlvoMinz= "note alvo/minzione " . $request->input('noteAlvoMinz') . ".<br>";
        }

        $cicloMesturale = "";
        $Gravidanze = "";
        if($user->paziente_sesso == "F" or $user->paziente_sesso == "female"){

            $etaMenarca = "";
            if($request->input('etaMenarca') != null){
                $etaMenarca= "Età menarca " . $request->input('etaMenarca') . " anni, ";
            }

            $ciclo = "";
            if($request->input('ciclo') != null){
                $ciclo= "ciclo " . $request->input('ciclo') . ", ";
            }

            $etaMenopausa = "";
            if($request->input('etaMenopausa') != null){
                $etaMenopausa= "età menopausa " . $request->input('etaMenopausa') . " anni, ";
            }

            $menopausa = "";
            if($request->input('menopausa') != null){
                $menopausa= "menopausa " . $request->input('menopausa') . ", ";
            }

            $noteCiclo = "";
            if($request->input('noteCiclo') != null){
                $noteCiclo= "note ciclo " . $request->input('noteCiclo') . ".<br>";
            }

            $cicloMesturale = $etaMenarca . $ciclo . $etaMenopausa . $menopausa . $noteCiclo;


            foreach ($gravidanza as $g){
                $Gravidanze = $Gravidanze . "Gravidanza con esito " . $request->input('esitoGrav'.$g->id_gravidanza) . " all'età di " . $request->input('etaGrav'.$g->id_gravidanza) . " anni, " .
                                            "inizio gravidanza " . $request->input('inizioGrav'.$g->id_gravidanza) . ", fine gravidanza " . $request->input('fineGrav'.$g->id_gravidanza) . ", sesso bambino " . $request->input('sessoBambinoGrav'.$g->id_gravidanza) . ", note gravidanza" . $request->input('noteGrav'.$g->id_gravidanza) . ".<br>";

            }


        }

        if($parto != null or $tipoParto != null or $allattamento != null or $sviluppoVegRel != null or $noteInfanzia != null or $livelloScol != null or $attivitaFisica != null or $abitudAlim != null or $fumo != null or $freqFumo != null or $alcool != null or $freqAlcool != null or $droghe != null or $freqDroghe != null or $noteStileVita != null or $professione != null or $noteAttLav != null or $alvo != null or $minzione != null or $noteAlvoMinz != null or $cicloMesturale != null or $Gravidanze != null) {
            $anamnesifisiologica = "<h2>Anamnesi fisiologica</h2><hr>" . $parto . $tipoParto . $allattamento . $sviluppoVegRel . $noteInfanzia . $livelloScol . $attivitaFisica . $abitudAlim . $fumo . $freqFumo . $alcool . $freqAlcool . $droghe . $freqDroghe . $noteStileVita . $professione . $noteAttLav . $alvo . $minzione . $noteAlvoMinz . $cicloMesturale . $Gravidanze;
        }

        //PRINT ANAMNESI PAT. REMOTA
        $anamPatRemota_cont  = $request->input('anamPatRemota');
        if ($anamPatRemota_cont != null){
            $anamPatRemota_cont = $anamPatRemota_cont;
        }

        if($request->input('icd9PatRemota') != null)
            $anamPatRemota_icd9  = "<br><br><strong>Patologie remote raggruppate per Categorie Diagnostiche (MDC): </strong><br>". $request->input('icd9PatRemota');


        $anamnesipatologicaremota = "";
        if($anamPatRemota_cont != null or $anamPatRemota_icd9 != null) {
            $anamnesipatologicaremota = "<h2>Anamnesi patologica remota</h2><hr>" . $anamPatRemota_cont . $anamPatRemota_icd9;
        }

        //PRINT ANAMNESI PAT. PROSSIMA
        $anamPatProssima_cont  = $request->input('anamPatProssima');
        if ($anamPatProssima_cont != null){
            $anamPatProssima_cont = "- " . $anamPatProssima_cont;
        }

        $anamPatProssima_icd9 = "";
        if($request->input('icd9PatProssima') != null)
            $anamPatProssima_icd9  = "<br><br><strong>Patologie prossime raggruppate per Categorie Diagnostiche (MDC): </strong><br>". $request->input('icd9PatProssima');


        if($anamPatProssima_cont != null or $anamPatProssima_icd9 != null) {
            $anamnesipatologicaprossima = "<h2>Anamnesi patologica prossima</h2><hr>" . $anamPatProssima_cont . $anamPatProssima_icd9;
        }

        $nomePaziente = "";
        if($user->paziente_sesso == "female" or $user->paziente_sesso == "F"){
            $nomePaziente = "<h1>Sig.ra $user->paziente_nome $user->paziente_cognome</h1>";
        }else{
            $nomePaziente = "<h1>Sig. $user->paziente_nome $user->paziente_cognome</h1>";
        }

        $print = $nomePaziente .  $anamnesifamiliare . $anamnesifisiologica . $anamnesipatologicaremota . $anamnesipatologicaprossima;

        $pdf = PDF::loadhtml($print);
        return $pdf->stream('result.pdf');
    }


}
