<?php
namespace App\Http\Controllers\Fhir\Modules;

use App\Exceptions\FHIR as FHIR;
use App\Models\InvestigationCenter\CentriIndagini;
use App\Models\InvestigationCenter\Indagini;
use App\Models\Icd9\Icd9EsamiStrumentiCodici;
use Illuminate\Http\Request;
use View;
use Illuminate\Filesystem\Filesystem;
use File;
use Orchestra\Parser\Xml\Facade as XmlParser;
use Exception;
use DB;
use Redirect;
use Response;
use SimpleXMLElement;
use DOMDocument;
use Input;
use App\Models\CareProviders\CareProvider;
use DateTime;
use DateTimeZone;
use Date;
use Carbon\Carbon;
use App\Models\CurrentUser\User;
use App\Models\Patient\Pazienti;
use App\Models\InvestigationCenter\IndaginiEliminate;

class FHIRObservation
{

    public function show($id)
    {
        $indagine = Indagini::where('id_indagine', $id)->first();
        
        if (! $indagine) {
            throw new FHIR\IdNotFoundInDatabaseException("resource with the id provided doesn't exist in database");
        }
        
        $values_in_narrative = array(
            "Identifier" => "RESP-OBSERVATION" . "-" . $indagine->getId(),
            "Status" => $indagine->getStatusDisplay(),
            "Category" => $indagine->getCategoryDisplay(),
            "Code" => $indagine->getCodeDisplay(),
            "Subject" => "RESP-PATIENT-" . $indagine->getIdPaziente(),
            "EffectivePeriod" => $indagine->getDataFine(),
            "Issued" => $indagine->getIssued(),
            "Performer" => "RESP-PRACTITIONER-" . $indagine->getIdCpp(),
            "Interpretation" => $indagine->getInterpretationDisplay()
        );
        
        $narrative_extensions = array(
            "Reason" => $indagine->getReason(),
            "Type" => $indagine->getType()
        );
        
        $data_xml["narrative"] = $values_in_narrative;
        $data_xml["extensions"] = $narrative_extensions;
        $data_xml["indagine"] = $indagine;
        
        return view("pages.fhir.Observation.observation", [
            "data_output" => $data_xml
        ]);
    }

    public function store(Request $request)
    {
        $file = $request->file('file');
        $id_paziente = Input::get('patient_id');
        
        $xml = XmlParser::load($file->getRealPath());
        
        $id = $xml->parse([
            'identifier' => [
                'uses' => 'identifier.value::value'
            ]
        ]);
        
        $indagini = Indagini::all();
        
        foreach ($indagini as $i) {
            if ($i->id_indagine == $id['identifier']) {
                throw new Exception("Indagine is already exists");
            }
        }
        
        $lettura = $xml->parse([
            'identifier' => [
                'uses' => 'identifier.value::value'
            ],
            'status' => [
                'uses' => 'status::value'
            ],
            'category' => [
                'uses' => 'category.coding.code::value'
            ],
            'code' => [
                'uses' => 'code.coding.code::value'
            ],
            'subject' => $id_paziente, // subject = patient = paziente loggato che importa la risorsa
            
            'effectivePeriod' => [
                'uses' => 'effectivePeriod.start::value'
            ],
            'issued' => [
                'uses' => 'issued::value'
            ],
            'performer' => [
                'uses' => 'performer.display::value' // cpp
            ],
            'interpretation' => [
                'uses' => 'interpretation.coding.code::value'
            ]
        
        ]);
        
        $explode = explode(" ", $lettura['performer']);
        $cppName = $explode[0];
        $cppSurname = $explode[1];
        
        $id_cpp = CareProvider::where([
            [
                'cpp_nome',
                '=',
                $cppName
            ],
            [
                'cpp_cognome',
                '=',
                $cppSurname
            ]
        ])->first()->id_cpp;
        
       
        $carbon = new Carbon($lettura['issued']);
        $date = Carbon::parse($lettura['issued'])->toDateTimeString();
  
        
        $indagine = array(
            'id_indagine' => $lettura['identifier'],
            'id_paziente' => $lettura['subject'],
            'id_cpp' => $id_cpp,
            'careprovider' => $lettura['performer'],
            'indagine_data' => $lettura['effectivePeriod'],
            'indagine_data_fine' => $lettura['effectivePeriod'],
            'indagine_aggiornamento' => '2018-04-03',
            'indagine_stato' => $lettura['status'],
            'indagine_issued' => $date,
            'indagine_category' => $lettura['category'],
            'indagine_code' => $lettura['code'],
            'indagine_interpretation' => $lettura['interpretation'],
            
        );
        
        $addIndagine = new Indagini();
        
        foreach ($indagine as $key => $value) {
            if (empty($value)) {
                continue;
            }
            $addIndagine->$key = $value;
        }
        
        $addIndagine->save();
        
        return response()->json($lettura['identifier'], 201);
        
    }
    
    
    public function update(Request $request, $id)
    {
        $file = $request->file('fileUpdate');
        $id_paziente = Input::get('patient_id');
        
        $xml = XmlParser::load($file->getRealPath());
        
        $id_ind = $xml->parse([
            'identifier' => [
                'uses' => 'identifier.value::value'
            ]
        ]);
        
        
        if($id != $id_ind['identifier'] ){
            throw new Exception("ERROR");
        }
        
            if (!Indagini::find($id_ind['identifier'])) {
                throw new Exception("Observation does not exist in the database");
            }
        
        
        $lettura = $xml->parse([
            'identifier' => [
                'uses' => 'identifier.value::value'
            ],
            'status' => [
                'uses' => 'status::value'
            ],
            'category' => [
                'uses' => 'category.coding.code::value'
            ],
            'code' => [
                'uses' => 'code.coding.code::value'
            ],
            'subject' => $id_paziente, // subject = patient = paziente loggato che importa la risorsa
            
            'effectivePeriod' => [
                'uses' => 'effectivePeriod.start::value'
            ],
            'issued' => [
                'uses' => 'issued::value'
            ],
            'performer' => [
                'uses' => 'performer.display::value' // cpp
            ],
            'interpretation' => [
                'uses' => 'interpretation.coding.code::value'
            ]
            
        ]);
        
        $explode = explode(" ", $lettura['performer']);
        $cppName = $explode[0];
        $cppSurname = $explode[1];
        
        $id_cpp = CareProvider::where([
            [
                'cpp_nome',
                '=',
                $cppName
            ],
            [
                'cpp_cognome',
                '=',
                $cppSurname
            ]
        ])->first()->id_cpp;
        
        
        $carbon = new Carbon($lettura['issued']);
        $date = Carbon::parse($lettura['issued'])->toDateTimeString();
        
        
        $indagine = array(
            'id_indagine' => $lettura['identifier'],
            'id_paziente' => $lettura['subject'],
            'id_cpp' => $id_cpp,
            'careprovider' => $lettura['performer'],
            'indagine_data' => $lettura['effectivePeriod'],
            'indagine_data_fine' => $lettura['effectivePeriod'],
            'indagine_aggiornamento' => '2018-04-03',
            'indagine_stato' => $lettura['status'],
            'indagine_issued' => $date,
            'indagine_category' => $lettura['category'], 
            'indagine_code' => $lettura['code'],
            'indagine_interpretation' => $lettura['interpretation'],
            
        );
        
        $updInd = Indagini::find($id_ind['identifier']);
        
        
        foreach ($indagine as $key => $value) {
            if (empty($value)) {
                continue;
            }
            $updInd->$key = $value;
        }
        
        $updInd->save();
        
        return response()->json($id, 200);
    }
    
    //inserisce l'indagine nella tabelle delle indagini eliminate in modo tale da non essere visualizzata
    //in quelle disponibili
    function destroy($id)
    {
        $id_paziente = Input::get('patient_id');
        $paziente = Pazienti::find($id_paziente);
        
        $id_utente = User::where('id_utente', $paziente->id_utente)->first()->id_utente;
        
        $indElim = array(
            'id_indagine' => $id,
            'id_utente' => $id_utente
        );
        
        $addIndElim = new IndaginiEliminate();
        
        foreach ($indElim as $key => $value) {
            if (empty($value)) {
                continue;
            }
            $addIndElim->$key = $value;
        }
        
        $addIndElim->save();
        
            
        return response()->json(null, 204);
       
    }
    
    
    public static function getResource($id){
        
        $indagine = Indagini::where('id_indagine', $id)->first();
        
        $values_in_narrative = array(
            "Id" => $indagine->id_indagine,
            "Identifier" => "RESP-OBSERVATION" . "-" . $indagine->getId(),
            "Status" => $indagine->getStatusDisplay(),
            "Category" => $indagine->getCategoryDisplay(),
            "Code" => $indagine->getCodeDisplay(),
            "Subject" => "RESP-PATIENT-" . $indagine->getIdPaziente(),
            "EffectivePeriod" => $indagine->getDataFine(),
            "Issued" => $indagine->getIssued(),
            "Performer" => "RESP-PRACTITIONER-" . $indagine->getIdCpp(),
            "Interpretation" => $indagine->getInterpretationDisplay()
        );
        
        $narrative_extensions = array(
            "Reason" => $indagine->getReason(),
            "Type" => $indagine->getType()
        );
        
        $data_xml["extensions"] = $narrative_extensions;
        $data_xml["narrative"] = $values_in_narrative;
        $data_xml["indagine"] = $indagine;
        
        self::xml($data_xml);
    }
    
    public static function xml($data_xml){
        //Creazione di un oggetto dom con la codifica UTF-8
        $dom = new DOMDocument('1.0', 'utf-8');
        
        //Creazione del nodo Patient, cioè il nodo Root  della risorsa
        $obs = $dom->createElement('Observation');
        //Valorizzo il namespace della risorsa e del documento XML, in  questo caso la specifica FHIR
        $obs->setAttribute('xmlns', 'http://hl7.org/fhir');
        //Corrello l'elemento con il nodo superiore
        $obs = $dom->appendChild($obs);
        
        
        //Creazione del nodo ID sempre presente nelle risorse FHIR
        $id = $dom->createElement('id');
        //Il valore dell'ID è il valore dell'ID nella relativa tabella del DB
        $id->setAttribute('value', $data_xml["narrative"]["Id"]);
        $id = $obs->appendChild($id);
        
        //Creazione della parte narrativa in XHTML e composta da tag HTML visualizzabili se aperto il file XML in un Browser
        $narrative = $dom->createElement('text');
        //Corrello l'elemento con il nodo superiore
        $narrative = $obs->appendChild($narrative);
        
        
        //Creazione del nodo status che indica lo stato della parte narrativa
        $status = $dom->createElement('status');
        //Il valore del nodo status è sempre generated, la parte narrativa è generato dal sistema
        $status->setAttribute('value', 'generated');
        $status = $narrative->appendChild($status);
        
        
        //Creazione del div che conterrà la tabella con i valori visualizzabili nella parte narrativa
        $div = $dom->createElement('div');
        //Link al value set della parte narrativa, cioè la codifica XHTML
        $div->setAttribute('xmlns',"http://www.w3.org/1999/xhtml");
        $div = $narrative->appendChild($div);
        
        
        //Creazione della tabella che conterrà i valori
        $table = $dom->createElement('table');
        $table->setAttribute('border',"2");
        $table = $div->appendChild($table);
        
        
        //Creazione del nodo tbody
        $tbody = $dom->createElement('tbody');
        $tbody = $table->appendChild($tbody);
        
        
        //Narrative
        foreach($data_xml["narrative"] as $key => $value){
            //Creazione di una riga
            $tr = $dom->createElement('tr');
            $tr = $tbody->appendChild($tr);
            
            //Creazione della colonna Contact
            $td = $dom->createElement('td', $key);
            $td = $tr->appendChild($td);
            
            //Creazione della colonna con il valore di contact del practitioner
            $td = $dom->createElement('td', $value);
            $td = $tr->appendChild($td);
            
        }
        
        
        // EXTENSIONS IN NARRATIVE
        
        foreach ($data_xml["extensions"] as $key => $value) {
            // Creazione di una riga
            $tr = $dom->createElement('tr');
            $tr = $tbody->appendChild($tr);
            // Language
            $td = $dom->createElement('td', $key);
            $td = $tr->appendChild($td);
            $td = $dom->createElement('td', $value);
            $td = $tr->appendChild($td);
        }
        
        // END EXTENSIONS IN NARRATIVE
        
        
        //EXTENSIONS
        //Reason
        $extension1 = $dom->createElement('extension');
        $extension1->setAttribute('url', 'http://resp.local/resources/extensions/Observation/observation-reason.xml');
        $extension1 = $obs->appendChild($extension1);
        
        $valueString1 = $dom->createElement('valueString');
        $valueString1->setAttribute('value', $data_xml["extensions"]['Reason']);
        $valueString1 = $extension1->appendChild($valueString1);
        
        
        //Type
        $extension2 = $dom->createElement('extension');
        $extension2->setAttribute('url', 'http://resp.local/resources/extensions/Observation/observation-type.xml');
        $extension2 = $obs->appendChild($extension2);
        
        $valueString2 = $dom->createElement('valueString');
        $valueString2->setAttribute('value', $data_xml["extensions"]['Type']);
        $valueString2 = $extension2->appendChild($valueString2);
        
        //END EXTENSIONS
        
        
        //Creazione del nodo identifier identificativo della risorsa Patient attraverso URI della risorsa
        $identifier = $dom->createElement('identifier');
        $identifier = $obs->appendChild($identifier);
        //Creazione del nodo use con valore fisso ad usual
        $use = $dom->createElement('use');
        $use->setAttribute('value', 'official');
        $use = $identifier->appendChild($use);
        //Creazione del nodo system che identifica il namespace degli URI per identificare la risorsa
        $system = $dom->createElement('system');
        $system->setAttribute('value', 'http://resp.local');  //RFC gestione URI
        $system = $identifier->appendChild($system);
        //Creazione del nodo value
        $value = $dom->createElement('value');
        //Do il valore all' URI della risorsa
        $value->setAttribute('value', $data_xml["narrative"]["Id"]);
        $value = $identifier->appendChild($value);
        
        
        
        
        //Creazione del nodo active settato a true in quanto la risorsa è attiva per il FSEM
        $status = $dom->createElement('status');
        $status->setAttribute('value', $data_xml["indagine"]->getStatus());
        $status = $obs->appendChild($status);
        
        
        
        
        //creazione del nodo patient
        $category = $dom->createElement('category');
        $category = $obs->appendChild($category);
        
        $coding = $dom->createElement('coding');
        $coding = $category->appendChild($coding);
        
        $system = $dom->createElement('system');
        $system->setAttribute('value', 'http://hl7.org/fhir/observation-category');
        $system = $coding->appendChild($system);
        
        $code = $dom->createElement('code');
        $code->setAttribute('value', $data_xml["indagine"]->getCategory());
        $code = $coding->appendChild($code);
        
        $display = $dom->createElement('display');
        $display->setAttribute('value', $data_xml["indagine"]->getCategoryDisplay());
        $display = $coding->appendChild($display);
        
        $text = $dom->createElement('text');
        $text->setAttribute('value', $data_xml["indagine"]->getCategoryDisplay());
        $text = $category->appendChild($text);
        
        
        
        
        
        //creazione del nodo patient
        $code = $dom->createElement('code');
        $code = $obs->appendChild($code);
        
        $coding = $dom->createElement('coding');
        $coding = $code->appendChild($coding);
        
        $system = $dom->createElement('system');
        $system->setAttribute('value', 'http://loinc.org');
        $system = $coding->appendChild($system);
        
        $code = $dom->createElement('code');
        $code->setAttribute('value', $data_xml["indagine"]->getCode());
        $code = $coding->appendChild($code);
        
        $display = $dom->createElement('display');
        $display->setAttribute('value', $data_xml["indagine"]->getCodeDisplay());
        $display = $coding->appendChild($display);
        
        
        
        
        
        $subject = $dom->createElement('subject');
        $subject = $obs->appendChild($subject);
        
        $reference = $dom->createElement('reference');
        $reference->setAttribute('value', $data_xml["narrative"]["Subject"]);
        $reference = $subject->appendChild($reference);
        
        $display = $dom->createElement('display');
        $display->setAttribute('value', $data_xml["indagine"]->getPaziente());
        $display = $subject->appendChild($display);
        
        
        
        
        $effectivePeriod = $dom->createElement('effectivePeriod');
        $effectivePeriod = $obs->appendChild($effectivePeriod);
        
        $start = $dom->createElement('start');
        $start->setAttribute('value', $data_xml["narrative"]["EffectivePeriod"]);
        $start = $effectivePeriod->appendChild($start);
        
        
        
        
        $issued = $dom->createElement('issued');
        $issued->setAttribute('value', $data_xml["narrative"]["Issued"]);
        $issued = $obs->appendChild($issued);
        
        
        
        
        $performer = $dom->createElement('performer');
        $performer = $obs->appendChild($performer);
        
        $reference = $dom->createElement('reference');
        $reference->setAttribute('value', $data_xml["narrative"]["Performer"]);
        $reference = $performer->appendChild($reference);
        
        $display = $dom->createElement('display');
        $display->setAttribute('value', $data_xml["indagine"]->getCpp());
        $display = $performer->appendChild($display);
        
        
        
        
        $interpretation = $dom->createElement('interpretation');
        $interpretation = $obs->appendChild($interpretation);
        
        $coding = $dom->createElement('coding');
        $coding = $interpretation->appendChild($coding);
        
        $system = $dom->createElement('system');
        $system->setAttribute('value', 'http://hl7.org/fhir/v2/0078');
        $system = $coding->appendChild($system);
        
        $code = $dom->createElement('code');
        $code->setAttribute('value', $data_xml["indagine"]->getInterpretation());
        $code = $coding->appendChild($code);
        
        $display = $dom->createElement('display');
        $display->setAttribute('value', $data_xml["indagine"]->getInterpretationDisplay());
        $display = $coding->appendChild($display);
        
        
        
        //Elimino gli spazi bianchi superflui per la viasualizzazione grafica dell'XML
        $dom->preserveWhiteSpace = false;
        //Formatto il documento per l'output
        $dom->formatOutput = true;
        $path = getcwd()."\\resources\\Patient\\";
        //Salvo il documento XML nella cartella rsources dando come nome, l'id del paziente
        $dom->save($path."RESP-OBSERVATION-".$data_xml["narrative"]["Id"].".xml");
        
        return $dom->saveXML();
        
    }
}

?>