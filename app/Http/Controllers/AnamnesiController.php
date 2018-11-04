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

    public function printAnamnesi(Request $request){

        $user = Pazienti::where('id_utente', Auth::id())->first();
        $parente = Parente::where('id_paziente', Auth::id())->get();
        $gravidanza = Gravidanza::where('id_paziente', Auth::id())->get();

        //PRINT ANAMNESI FAMILIARE
        $anamFamiliare_cont  = $request->input('anamFamiliare');
        if ($anamFamiliare_cont != null){
            $anamFamiliare_cont = "- " . $anamFamiliare_cont;
        }

        $Parente = "";
        foreach($parente as $p){
            $Parente = $Parente . "<strong>Componente: </strong>". $request->input('anamComponente'.$p->id_parente) . "<br>
                                   <strong> Sesso: </strong>". $request->input('anamSesso'.$p->id_parente) . "<br>
                                   <strong>Anni: </strong>". $request->input('anamEta'.$p->id_parente). "<br>
                                   <strong>Annotazioni: </strong>" .$request->input('anamAnnotazioni'.$p->id_parente). "<br><br>";
        }

        if($Parente != null){
            $Parente = "<h3>Anamnesi familiare FHIR</h3>" . $Parente;
        }
        $pathLogo = public_path('img/logo.png');
        $anamnesifamiliare = " <br><h2>Anamnesi familiare</h2><hr><br> " . $anamFamiliare_cont . $Parente;

        //PRINT ANAMNESI FISIOLOGICA
        $parto = "";
        if($request->input('Parto') != null){
           $parto = "<strong>Nato da parto: </strong>" . $request->input('Parto') . "<br>";
        }

        $tipoParto = "";
        if($request->input('tipoParto') != null){
            $tipoParto = "<strong>Tipo parto: </strong>" . $request->input('tipoParto') . "<br>";
        }

        $allattamento = "";
        if($request->input('Allattamento') != null){
            $allattamento = "<strong>Allattamento: </strong>" . $request->input('Allattamento') . "<br>";
        }

        $sviluppoVegRel = "";
        if($request->input('sviluppoVegRel') != null){
            $sviluppoVegRel= "<strong>Sviluppo vegetativo e relazionale: </strong>" . $request->input('sviluppoVegRel') . "<br>";
        }

        $noteInfanzia = "";
        if($request->input('noteInfanzia') != null){
            $noteInfanzia= "<strong>Note: </strong>" . $request->input('noteInfanzia') . "<br>";
        }

        $livelloScol = "";
        if($request->input('livScol') != null){
            $livelloScol= "<strong>Livello scolastico: </strong>" . $request->input('livScol') . "<br>";
        }

        $attivitaFisica = "";
        if($request->input('attivitaFisica') != null){
            $attivitaFisica= "<strong>Attività fisica: </strong>" . $request->input('attivitaFisica') . "<br>";
        }

        $abitudAlim = "";
        if($request->input('abitudAlim') != null){
            $abitudAlim= "<strong>Abitudini alimentari: </strong>" . $request->input('abitudAlim') . "<br>";
        }

        $fumo = "";
        if($request->input('fumo') != null){
            $fumo= "<strong>Fumo: </strong>" . $request->input('fumo') . "<br>";
        }

        $freqFumo = "";
        if($request->input('freqFumo') != null){
            $freqFumo= "<strong>Frequenza fumo: </strong>" . $request->input('freqFumo') . "<br>";
        }

        $alcool = "";
        if($request->input('alcool') != null){
            $alcool= "<strong>Alcool: </strong>" . $request->input('alcool') . "<br>";
        }

        $freqAlcool = "";
        if($request->input('freqAlcool') != null){
            $freqAlcool= "<strong>Frequenza alcool: </strong>" . $request->input('freqAlcool') . "<br>";
        }

        $droghe = "";
        if($request->input('droghe') != null){
            $droghe= "<strong>Droghe: </strong>" . $request->input('droghe') . "<br><br>";
        }

        $freqDroghe = "";
        if($request->input('freqDroghe') != null){
            $freqDroghe= "<strong>Frequenza droghe: </strong>" . $request->input('freqDroghe') . "<br>";
        }

        $noteStileVita = "";
        if($request->input('noteStileVita') != null){
            $noteStileVita= "<strong>Note: </strong>" . $request->input('noteStileVita') . "<br>";
        }

        $professione = "";
        if($request->input('professione') != null){
            $professione= "<strong>Professione: </strong>" . $request->input('professione') . "<br>";
        }

        $noteAttLav = "";
        if($request->input('noteAttLav') != null){
            $noteAttLav= "<strong>Note: </strong>" . $request->input('noteAttLav') . "<br>";
        }

        $alvo = "";
        if($request->input('alvo') != null){
            $alvo= "<strong>Alvo: </strong>" . $request->input('alvo') . "<br>";
        }

        $minzione = "";
        if($request->input('minzione') != null){
            $minzione= "<strong>Minzione: </strong>" . $request->input('minzione') . "<br>";
        }

        $noteAlvoMinz = "";
        if($request->input('noteAlvoMinz') != null){
            $noteAlvoMinz= "<strong>Note: </strong>" . $request->input('noteAlvoMinz') . "<br>";
        }

        $cicloMesturale = "";

        if($user->paziente_sesso == "F" or $user->paziente_sesso == "female"){

            $etaMenarca = "";
            if($request->input('etaMenarca') != null){
                $etaMenarca= "<strong>Età menarca: </strong>" . $request->input('etaMenarca') . "<br>";
            }

            $ciclo = "";
            if($request->input('ciclo') != null){
                $ciclo= "<strong>Ciclo: </strong>" . $request->input('ciclo') . "<br>";
            }

            $etaMenopausa = "";
            if($request->input('etaMenopausa') != null){
                $etaMenopausa= "<strong>Età menopausa: </strong>" . $request->input('etaMenopausa') . "<br>";
            }

            $menopausa = "";
            if($request->input('menopausa') != null){
                $menopausa= "<strong>Menopausa: </strong>" . $request->input('menopausa') . "<br>";
            }

            $noteCiclo = "";
            if($request->input('noteCiclo') != null){
                $noteCiclo= "<strong>Note: </strong>" . $request->input('noteCiclo') . "<br>";
            }

            if($etaMenarca != null or $ciclo != null or $etaMenopausa != null or $menopausa != null or $noteCiclo)
                $cicloMesturale = "<br><h3>Ciclo mestruale</h3>" . $etaMenarca . $ciclo . $etaMenopausa . $menopausa . $noteCiclo;

            $Gravidanze = "";
            foreach ($gravidanza as $g){
                $Gravidanze = $Gravidanze . "<strong>Esito gravidanza: </strong>" . $request->input('esitoGrav'.$g->id_gravidanza) . "<br>
                                            <strong>Età gravidanza: </strong>" . $request->input('etaGrav'.$g->id_gravidanza) . "<br>
                                            <strong>Inizio gravidanza: </strong>" . $request->input('inizioGrav'.$g->id_gravidanza) . "<br>
                                            <strong>Fine gravidanza: </strong>" . $request->input('fineGrav'.$g->id_gravidanza) . "<br>
                                            <strong>Sesso bambino: </strong>" .$request->input('sessoBambinoGrav'.$g->id_gravidanza) . "<br>
                                            <strong>Note: </strong>" . $request->input('noteGrav'.$g->id_gravidanza) . "<br><br>";
            }

            if($Gravidanze != null)
                $Gravidanze = "<br><h3>Gravidanze</h3>" . $Gravidanze;
        }

        $infanzia = "";
        $scolarita = "";
        $stileVita = "";
        $attivitaLavorativa = "";
        $alvominzione = "";
        if($parto != null or $tipoParto != null or $allattamento != null or $sviluppoVegRel != null or $noteInfanzia)
            $infanzia = "<h3>Infanzia</h3>";

        if($livelloScol != null)
            $scolarita = "<br><h3>Scolarità</h3>";

        if($attivitaFisica != null or $abitudAlim != null or $fumo != null or $freqFumo != null or $alcool != null or $freqAlcool != null or $droghe != null or $freqDroghe != null or $noteStileVita)
            $stileVita = "<br><h3>Stile di vita</h3>";

        if($professione != null or $noteAttLav)
            $attivitaLavorativa = "<br><h3>Attività lavorativa</h3>";

        if($alvo != null or $minzione != null or $noteAlvoMinz)
            $alvominzione = "<br><h3>Alvo e minzione</h3>";



        $anamnesifisiologica = "<h2>Anamnesi fisiologica</h2><hr>" . $infanzia . $parto . $tipoParto . $allattamento . $sviluppoVegRel . $noteInfanzia .$scolarita . $livelloScol . $stileVita . $attivitaFisica . $abitudAlim . $fumo . $freqFumo . $alcool . $freqAlcool . $droghe . $freqDroghe . $noteStileVita . $attivitaLavorativa . $professione . $noteAttLav . $alvominzione . $alvo . $minzione . $noteAlvoMinz . $cicloMesturale . $Gravidanze;


        //PRINT ANAMNESI PAT. REMOTA
        $anamPatRemota_cont  = $request->input('anamPatRemota');
        if ($anamPatRemota_cont != null){
            $anamPatRemota_cont = "- " . $anamPatRemota_cont;
        }

        if($request->input('icd9PatRemota') != null)
            $anamPatRemota_icd9  = "<br><h4>Patologie remote raggruppate per Categorie Diagnostiche (MDC):</h4>". $request->input('icd9PatRemota');


        $anamnesipatologicaremota = "<h2>Anamnesi patologica remota</h2><hr>" . $anamPatRemota_cont . $anamPatRemota_icd9;


        //PRINT ANAMNESI PAT. PROSSIMA
        $anamPatProssima_cont  = $request->input('anamPatProssima');
        if ($anamPatProssima_cont != null){
            $anamPatProssima_cont = "- " . $anamPatProssima_cont;
        }

        if($request->input('icd9PatProssima') != null)
            $anamPatProssima_icd9  = "<br><br><h4>Patologie prossime raggruppate per Categorie Diagnostiche (MDC):</h4>". $request->input('icd9PatProssima');



        $anamnesipatologicaprossima = "<br><br><h2>Anamnesi patologica prossima</h2><hr>" . $anamPatProssima_cont . $anamPatProssima_icd9;

        $nomePaziente = "";
        if($user->paziente_sesso == "female" or $user->paziente_sesso == "F"){
            $nomePaziente = "<br><h1>Sig.ra $user->paziente_nome $user->paziente_cognome</h1>";
        }else{
            $nomePaziente = "<br><h1>Sig. $user->paziente_nome $user->paziente_cognome</h1>";
        }

        $print = "<img src=$pathLogo>" . $nomePaziente .  $anamnesifamiliare . $anamnesifisiologica . $anamnesipatologicaremota . $anamnesipatologicaprossima;

        $pdf = PDF::loadhtml($print);
        return $pdf->stream('result.pdf');
    }


}
