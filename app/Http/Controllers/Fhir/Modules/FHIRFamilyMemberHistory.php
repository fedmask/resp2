<?php
namespace App\Http\Controllers\Fhir\Modules;

use App\Http\Controllers\Fhir\Modules\FHIRResource;
use App\Models\Patient\Pazienti;
use App\Models\Patient\PazientiVisite;
use App\Models\Patient\PazientiFamiliarita;
use App\Models\Patient\ParametriVitali;
use App\Models\Patient\PazientiContatti;
use App\Models\CareProviders\CppPaziente;
use App\Models\CareProviders\CareProvider;
use App\Exceptions\FHIR as FHIR;
use App\Models\CurrentUser\Recapiti;
use App\Models\CurrentUser\User;
use App\Models\Domicile\Comuni;
use Illuminate\Http\Request;
use App\Models\FHIR\PatientContact;
use App\Models\CodificheFHIR\ContactRelationship;
use App\Models\FHIR\PazienteCommunication;
use View;
use Illuminate\Filesystem\Filesystem;
use File;
use Orchestra\Parser\Xml\Facade as XmlParser;
use Exception;
use DB;
use Redirect;
use Response;
use SimpleXMLElement;
use App\Models\InvestigationCenter\Indagini;
use App\Models\InvestigationCenter\IndaginiEliminate;
use DOMDocument;
use App\Http\Controllers\Fhir\Modules\FHIRPractitioner;
use App\Http\Controllers\Fhir\Modules\FHIRPatient;
use ZipArchive;
use App\Models\FHIR\Contatto;
use App\Models\Parente;
use App\Models\CodificheFHIR\RelationshipType;
use App\Models\Diagnosis\Diagnosi;
use App\Models\Diagnosis\DiagnosiEliminate;
use App\Models\Vaccine\Vaccinazione;
use App\Models\FHIR\EncounterParticipant;
use Input;
use Carbon\Carbon;
use DateTimeZone;
use App\Models\History\AnamnesiF;
use App\Models\FHIR\FamilyMemberHistoryCondition;

/**
 * Classe per la gestione delle operazioni di REST e per la creazione del file xml
 *
 * show => Visualizzazione di una risorsa
 * store => Memorizzazione di una nuova risorsa
 * update => Aggiornamento di una risorsa
 * delete => eliminazione di una risorsa
 */
class FHIRFamilyMemberHistory
{

    /**
     * Funzione per la visualizzazione di una risorsa
     */
    public function show($id)
    {
        $anamnesi = AnamnesiF::where('id_anamnesiF', $id)->first();
        
        if (! $anamnesi) {
            throw new FHIR\IdNotFoundInDatabaseException("resource with the id provided doesn't exist in database");
        }
        
        $condition = FamilyMemberHistoryCondition::where('id_anamnesiF', $id)->first();
        
        $values_in_narrative = array(
            "Identifier" => "RESP-FAMILYMEMBERHISTORY" . "-" . $anamnesi->getId(),
            "Status" => $anamnesi->getStatus(),
            "Patient" => $anamnesi->getPaziente(),
            "Name" => $anamnesi->getParente(),
            "Relationship" => $anamnesi->getRelationship(),
            "Gender" => $anamnesi->getGender(),
            "Born" => $anamnesi->getBorn(),
            "Deceased" => $anamnesi->isDeceased(),
            "ConditionCode" => $condition->getCodeDisplay(),
            "ConditionOutcome" => $condition->getOutComeDisplay(),
            "ConditionNote" => $condition->getNote()
            
        );
        
        
        $data_xml["narrative"] = $values_in_narrative;
        $data_xml["anamnesi"] = $anamnesi;
        $data_xml["condition"] = $condition;
        
        return view("pages.fhir.FamilyMemberHistory.familyMemberHistory", [
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
        
        $anamnesi = AnamnesiF::all();
        
        foreach ($anamnesi as $a) {
            if ($a->id_anamnesiF == $id['identifier']) {
                throw new Exception("Anamnesi is already exists");
            }
        }
        
        
        $lettura = $xml->parse([
            'identifier' => [
                'uses' => 'identifier.value::value'
            ],
            'status' => [
                'uses' => 'status::value'
            ],
            'patientReference' => [
                'uses' => 'patient.reference::value'
            ],
            'patientDisplay' => [
                'uses' => 'patient.display::value'
            ],
            'name' => [
                'uses' => 'name::value'
            ],
            'relationshipCode' => [
                'uses' => 'relationship.coding.code::value'
            ],
            'gender' => [
                'uses' => 'gender::value'
            ],
            'bornDate' => [
                'uses' => 'bornDate::value'
            ],
            'deceasedBoolean' => [
                'uses' => 'deceasedBoolean::value'
            ],
            'conditionCode' => [
                'uses' => 'condition.code.coding.code::value'
            ],
            'conditionOutcome' => [
                'uses' => 'condition.outcome.coding.code::value'
            ],
            'conditionNote' => [
                'uses' => 'condition.note.text::value'
            ]
            
        ]);
        
        $parente = PazientiFamiliarita::where([
            ['id_paziente', "=", $id_paziente],
            ['relazione', "=", $lettura['relationshipCode']]
        ])->get();
        
        $expl = explode(" ", $lettura['name']);
        $name = $expl[0];
        $surname = $expl[1];
        
        $id_parente;
        $pazFam = Parente::all();
        
        foreach($parente as $p){
            if(Parente::where([
                ['id_parente', "=", $p->id_parente],
                ['nome', "=", $name],
                ['cognome', "=", $surname],
                ['data_nascita', "=", $lettura['bornDate']]
            ])){
                $id_parente = $p->id_parente;
            }
        }
        
        $anamnesi = array(
            'id_anamnesiF' => $lettura['identifier'],
            'descrizione' => '',
            'id_paziente' => $id_paziente,
            'id_parente' => $id_parente,
            'status' => $lettura['status'],
            'notDoneReason' => '',
            'note' => '',
            'data' => Carbon::now(new DateTimeZone('Europe/Rome'))
        );
        
        
        $addAnamnesi = new AnamnesiF();
        
        foreach ($anamnesi as $key => $value) {
            if (empty($value)) {
                continue;
            }
            $addAnamnesi->$key = $value;
        }
        $addAnamnesi->save();
        
        $condition = array(
            'id_anamnesiF' => $lettura['identifier'],
            'code' => $lettura['conditionCode'],
            'outcome' => $lettura['conditionOutcome'],
            'note' => $lettura['conditionNote']
        );
        
        $addCondition = new FamilyMemberHistoryCondition();
        
        foreach ($condition as $key => $value) {
            if (empty($value)) {
                continue;
            }
            $addCondition->$key = $value;
        }
        $addCondition->save();
        
        return response()->json($lettura['identifier'], 201);
        
    }
    
    
    public function update(Request $request, $id)
    {
        $file = $request->file('fileUpdate');
        $id_paziente = Input::get('patient_id');
        
        $xml = XmlParser::load($file->getRealPath());
        
        $id_anamnesi = $xml->parse([
            'identifier' => [
                'uses' => 'identifier.value::value'
            ]
        ]);
        
        if ($id != $id_anamnesi['identifier']) {
            throw new Exception("ERROR");
        }
        
        if (! AnamnesiF::find($id_anamnesi['identifier'])) {
            throw new Exception("FamilyMemberHistory does not exist in the database");
        }

        $lettura = $xml->parse([
            'identifier' => [
                'uses' => 'identifier.value::value'
            ],
            'status' => [
                'uses' => 'status::value'
            ],
            'patientReference' => [
                'uses' => 'patient.reference::value'
            ],
            'patientDisplay' => [
                'uses' => 'patient.display::value'
            ],
            'name' => [
                'uses' => 'name::value'
            ],
            'relationshipCode' => [
                'uses' => 'relationship.coding.code::value'
            ],
            'gender' => [
                'uses' => 'gender::value'
            ],
            'bornDate' => [
                'uses' => 'bornDate::value'
            ],
            'deceasedBoolean' => [
                'uses' => 'deceasedBoolean::value'
            ],
            'conditionCode' => [
                'uses' => 'condition.code.coding.code::value'
            ],
            'conditionOutcome' => [
                'uses' => 'condition.outcome.coding.code::value'
            ],
            'conditionNote' => [
                'uses' => 'condition.note.text::value'
            ]
            
        ]);
        
        $parente = PazientiFamiliarita::where([
            ['id_paziente', "=", $id_paziente],
            ['relazione', "=", $lettura['relationshipCode']]
        ])->get();
        
        $expl = explode(" ", $lettura['name']);
        $name = $expl[0];
        $surname = $expl[1];
        
        $id_parente;
        $pazFam = Parente::all();
        
        foreach($parente as $p){
            if(Parente::where([
                ['id_parente', "=", $p->id_parente],
                ['nome', "=", $name],
                ['cognome', "=", $surname],
                ['data_nascita', "=", $lettura['bornDate']]
            ])){
                $id_parente = $p->id_parente;
            }
        }
        
        $anamnesi = array(
            'descrizione' => '',
            'id_paziente' => $id_paziente,
            'id_parente' => $id_parente,
            'status' => $lettura['status'],
            'notDoneReason' => '',
            'note' => '',
            'data' => Carbon::now(new DateTimeZone('Europe/Rome'))
        );
        
        
        $updAnamnesi = AnamnesiF::find($id_anamnesi)->first();
        
        foreach ($anamnesi as $key => $value) {
            if (empty($value)) {
                continue;
            }
            $updAnamnesi->$key = $value;
        }
        $updAnamnesi->save();
        
        $condition = array(
            'id_anamnesiF' => $lettura['identifier'],
            'code' => $lettura['conditionCode'],
            'outcome' => $lettura['conditionOutcome'],
            'note' => $lettura['conditionNote']
        );
        
        
        FamilyMemberHistoryCondition::where('id_anamnesiF', $id_anamnesi)->delete();
        $updCondition = new FamilyMemberHistoryCondition();
        
        foreach ($condition as $key => $value) {
            if (empty($value)) {
                continue;
            }
            $updCondition->$key = $value;
        }
        $updCondition->save();
       
        return response()->json($id_anamnesi['identifier'], 200);
        
    }
    
    
    function destroy($id)
    {
        FamilyMemberHistoryCondition::find($id)->delete();
        
        AnamnesiF::find($id)->delete();
        
        return response()->json(null, 204);
        
    }
    
    
    public static function getResource($id)
    {
        $anamnesi = AnamnesiF::where('id_anamnesiF', $id)->first();
        
        if (! $anamnesi) {
            throw new FHIR\IdNotFoundInDatabaseException("resource with the id provided doesn't exist in database");
        }
        
        $condition = FamilyMemberHistoryCondition::where('id_anamnesiF', $id)->first();
        
        $values_in_narrative = array(
            "Id" => $anamnesi->getId(),
            "Identifier" => "RESP-FAMILYMEMBERHISTORY" . "-" . $anamnesi->getId(),
            "Status" => $anamnesi->getStatus(),
            "Patient" => $anamnesi->getPaziente(),
            "Name" => $anamnesi->getParente(),
            "Relationship" => $anamnesi->getRelationship(),
            "Gender" => $anamnesi->getGender(),
            "Born" => $anamnesi->getBorn(),
            "Deceased" => $anamnesi->isDeceased(),
            "ConditionCode" => $condition->getCodeDisplay(),
            "ConditionOutcome" => $condition->getOutComeDisplay(),
            "ConditionNote" => $condition->getNote()
            
        );
        
        
        $data_xml["narrative"] = $values_in_narrative;
        $data_xml["anamnesi"] = $anamnesi;
        $data_xml["condition"] = $condition;
        
        self::xml($data_xml);
    }
    
    
    public static function xml($data_xml)
    {
        // Creazione di un oggetto dom con la codifica UTF-8
        $dom = new DOMDocument('1.0', 'utf-8');
        
        // Creazione del nodo Patient, cioè il nodo Root della risorsa
        $fam = $dom->createElement('FamilyMemberHistory');
        // Valorizzo il namespace della risorsa e del documento XML, in questo caso la specifica FHIR
        $fam->setAttribute('xmlns', 'http://hl7.org/fhir');
        // Corrello l'elemento con il nodo superiore
        $fam = $dom->appendChild($fam);
        
        // Creazione del nodo ID sempre presente nelle risorse FHIR
        $id = $dom->createElement('id');
        // Il valore dell'ID è il valore dell'ID nella relativa tabella del DB
        $id->setAttribute('value', $data_xml["narrative"]["Id"]);
        $id = $fam->appendChild($id);
        
        // Creazione della parte narrativa in XHTML e composta da tag HTML visualizzabili se aperto il file XML in un Browser
        $narrative = $dom->createElement('text');
        // Corrello l'elemento con il nodo superiore
        $narrative = $fam->appendChild($narrative);
        
        // Creazione del nodo status che indica lo stato della parte narrativa
        $status = $dom->createElement('status');
        // Il valore del nodo status è sempre generated, la parte narrativa è generato dal sistema
        $status->setAttribute('value', 'generated');
        $status = $narrative->appendChild($status);
        
        // Creazione del div che conterrà la tabella con i valori visualizzabili nella parte narrativa
        $div = $dom->createElement('div');
        // Link al value set della parte narrativa, cioè la codifica XHTML
        $div->setAttribute('xmlns', "http://www.w3.org/1999/xhtml");
        $div = $narrative->appendChild($div);
        
        // Creazione della tabella che conterrà i valori
        $table = $dom->createElement('table');
        $table->setAttribute('border', "2");
        $table = $div->appendChild($table);
        
        // Creazione del nodo tbody
        $tbody = $dom->createElement('tbody');
        $tbody = $table->appendChild($tbody);
        
        // Creazione di una riga
        $tr = $dom->createElement('tr');
        $tr = $tbody->appendChild($tr);
        
        // Creazione della colonna Identifier
        $td = $dom->createElement('td', "Identifier");
        $td = $tr->appendChild($td);
        
        // Creazione della colonna con il valore di nome e cognome del related person
        $td = $dom->createElement('td', $data_xml["narrative"]["Identifier"]);
        $td = $tr->appendChild($td);
        
        // Creazione di una riga
        $tr = $dom->createElement('tr');
        $tr = $tbody->appendChild($tr);
        
        // Creazione della colonna Active
        $td = $dom->createElement('td', "Status");
        $td = $tr->appendChild($td);
        
        // Creazione della colonna con il valore di nome e cognome del related person
        $td = $dom->createElement('td', $data_xml["narrative"]["Status"]);
        $td = $tr->appendChild($td);
        
        // Creazione di una riga
        $tr = $dom->createElement('tr');
        $tr = $tbody->appendChild($tr);
        
        // Creazione della colonna Patient
        $td = $dom->createElement('td', "Patient");
        $td = $tr->appendChild($td);
        
        // Creazione della colonna con il valore di nome e cognome del paziente
        $td = $dom->createElement('td', $data_xml["narrative"]["Patient"]);
        $td = $tr->appendChild($td);
        
        
        // Creazione di una riga
        $tr = $dom->createElement('tr');
        $tr = $tbody->appendChild($tr);
        
        // Creazione della colonna Name
        $td = $dom->createElement('td', "Name");
        $td = $tr->appendChild($td);
        
        // Creazione della colonna con il valore di nome e cognome del paziente
        $td = $dom->createElement('td', $data_xml["narrative"]["Name"]);
        $td = $tr->appendChild($td);
        
        // Creazione di una riga
        $tr = $dom->createElement('tr');
        $tr = $tbody->appendChild($tr);
        
        // Creazione della colonna Telecom
        $td = $dom->createElement('td', "Relationship");
        $td = $tr->appendChild($td);
        
        // Creazione della colonna con il valore di nome e cognome del paziente
        $td = $dom->createElement('td', $data_xml["narrative"]["Relationship"]);
        $td = $tr->appendChild($td);
        
        // Creazione di una riga
        $tr = $dom->createElement('tr');
        $tr = $tbody->appendChild($tr);
        
        // Creazione della colonna Gender
        $td = $dom->createElement('td', "Gender");
        $td = $tr->appendChild($td);
        
        // Creazione della colonna con il valore di nome e cognome del paziente
        $td = $dom->createElement('td', $data_xml["narrative"]["Gender"]);
        $td = $tr->appendChild($td);
        
        
        // Creazione di una riga
        $tr = $dom->createElement('tr');
        $tr = $tbody->appendChild($tr);
        
        // Creazione della colonna Gender
        $td = $dom->createElement('td', "Born");
        $td = $tr->appendChild($td);
        
        // Creazione della colonna con il valore di nome e cognome del paziente
        $td = $dom->createElement('td', $data_xml["narrative"]["Born"]);
        $td = $tr->appendChild($td);
        
        
        // Creazione di una riga
        $tr = $dom->createElement('tr');
        $tr = $tbody->appendChild($tr);
        
        // Creazione della colonna Gender
        $td = $dom->createElement('td', "Deceased");
        $td = $tr->appendChild($td);
        
        // Creazione della colonna con il valore di nome e cognome del paziente
        $td = $dom->createElement('td', $data_xml["narrative"]["Deceased"]);
        $td = $tr->appendChild($td);
        
        
        // Creazione di una riga
        $tr = $dom->createElement('tr');
        $tr = $tbody->appendChild($tr);
        
        // Creazione della colonna Gender
        $td = $dom->createElement('td', "ConditionCode");
        $td = $tr->appendChild($td);
        
        // Creazione della colonna con il valore di nome e cognome del paziente
        $td = $dom->createElement('td', $data_xml["narrative"]["ConditionCode"]);
        $td = $tr->appendChild($td);
        
        // Creazione di una riga
        $tr = $dom->createElement('tr');
        $tr = $tbody->appendChild($tr);
        
        // Creazione della colonna Gender
        $td = $dom->createElement('td', "ConditionOutcome");
        $td = $tr->appendChild($td);
        
        // Creazione della colonna con il valore di nome e cognome del paziente
        $td = $dom->createElement('td', $data_xml["narrative"]["ConditionOutcome"]);
        $td = $tr->appendChild($td);
        
        
        // Creazione di una riga
        $tr = $dom->createElement('tr');
        $tr = $tbody->appendChild($tr);
        
        // Creazione della colonna Gender
        $td = $dom->createElement('td', "ConditionNote");
        $td = $tr->appendChild($td);
        
        // Creazione della colonna con il valore di nome e cognome del paziente
        $td = $dom->createElement('td', $data_xml["narrative"]["ConditionNote"]);
        $td = $tr->appendChild($td);
        
        
        // Creazione del nodo identifier identificativo della risorsa Patient attraverso URI della risorsa
        $identifier = $dom->createElement('identifier');
        $identifier = $fam->appendChild($identifier);
        // Creazione del nodo value
        $value = $dom->createElement('value');
        // Do il valore all' URI della risorsa
        $value->setAttribute('value', $data_xml["narrative"]["Id"]);
        $value = $identifier->appendChild($value);
        
        $status = $dom->createElement('status');
        $status->setAttribute('value', $data_xml["anamnesi"]->getStatus());
        $status = $fam->appendChild($status);
        
        
        
        $patient = $dom->createElement('patient');
        $patient = $fam->appendChild($patient);
        
        $reference = $dom->createElement('reference');
        $reference->setAttribute('value', "RESP-PATIENT-" . $data_xml["anamnesi"]->getPazienteId());
        $reference = $patient->appendChild($reference);
        
        $display = $dom->createElement('display');
        $display->setAttribute('value', $data_xml["anamnesi"]->getPaziente());
        $display = $patient->appendChild($display);
        
        
        
        $name = $dom->createElement('name');
        $name->setAttribute('value', $data_xml["anamnesi"]->getParente());
        $name = $fam->appendChild($name);
        
        
         
        // Creazione del nodo active settato a true in quanto la risorsa è attiva per il FSEM
        $relationship = $dom->createElement('relationship');
        $relationship = $fam->appendChild($relationship);
        
        $coding = $dom->createElement('coding');
        $coding = $relationship->appendChild($coding);
        
        $system = $dom->createElement('system');
        $system->setAttribute('value', 'http://hl7.org/fhir/v3/RoleCode'); // RFC gestione URI
        $system = $coding->appendChild($system);
        
        $code = $dom->createElement('code');
        $code->setAttribute('value', $data_xml["anamnesi"]->getRelationshipCode());
        $code = $coding->appendChild($code);
        
        $display = $dom->createElement('display');
        $display->setAttribute('value', $data_xml["anamnesi"]->getRelationship());
        $display = $coding->appendChild($display);
        
        
        
        
        $gender = $dom->createElement('gender');
        $gender->setAttribute('value', $data_xml["anamnesi"]->getGender());
        $gender = $fam->appendChild($gender);
        
        
        
        
        $bornDate = $dom->createElement('bornDate');
        $bornDate->setAttribute('value', $data_xml["anamnesi"]->getBorn());
        $bornDate = $fam->appendChild($bornDate);
        
        
        
        $deceasedBoolean = $dom->createElement('deceasedBoolean');
        $deceasedBoolean->setAttribute('value', $data_xml["anamnesi"]->isDeceased());
        $deceasedBoolean = $fam->appendChild($deceasedBoolean);
        
        
        
        
        // Creazione del nodo active settato a true in quanto la risorsa è attiva per il FSEM
        $condition = $dom->createElement('condition');
        $condition = $fam->appendChild($condition);
        
        $code = $dom->createElement('code');
        $code = $condition->appendChild($code);
        
        $coding = $dom->createElement('coding');
        $coding = $code->appendChild($coding);
        
        $system = $dom->createElement('system');
        $system->setAttribute('value', 'http://snomed.info/sct'); // RFC gestione URI
        $system = $coding->appendChild($system);
        
        $code1 = $dom->createElement('code');
        $code1->setAttribute('value', $data_xml["condition"]->getCode());
        $code1 = $coding->appendChild($code1);
        
        $display = $dom->createElement('display');
        $display->setAttribute('value', $data_xml["condition"]->getCodeDisplay());
        $display = $coding->appendChild($display);
        
        $text = $dom->createElement('text');
        $text->setAttribute('value', $data_xml["condition"]->getCodeDisplay());
        $text = $code->appendChild($text);
        
        
        
        
        
        $outcome = $dom->createElement('outcome');
        $outcome = $condition->appendChild($outcome);
        
        $coding = $dom->createElement('coding');
        $coding = $outcome->appendChild($coding);
        
        $system = $dom->createElement('system');
        $system->setAttribute('value', 'http://snomed.info/sct'); // RFC gestione URI
        $system = $coding->appendChild($system);
        
        $code1 = $dom->createElement('code');
        $code1->setAttribute('value', $data_xml["condition"]->getOutcome());
        $code1 = $coding->appendChild($code1);
        
        $display = $dom->createElement('display');
        $display->setAttribute('value', $data_xml["condition"]->getOutcomeDisplay());
        $display = $coding->appendChild($display);
        
        $text = $dom->createElement('text');
        $text->setAttribute('value', $data_xml["condition"]->getOutcomeDisplay());
        $text = $outcome->appendChild($text);
        
        
        
        $note = $dom->createElement('note');
        $note = $condition->appendChild($note);
        // Creazione del nodo value
        $text = $dom->createElement('text');
        // Do il valore all' URI della risorsa
        $text->setAttribute('value', $data_xml["condition"]->getNote());
        $text = $note->appendChild($text);
       
        
        
        // Elimino gli spazi bianchi superflui per la viasualizzazione grafica dell'XML
        $dom->preserveWhiteSpace = false;
        // Formatto il documento per l'output
        $dom->formatOutput = true;
        $path = getcwd() . "\\resources\\Patient\\";
        // Salvo il documento XML nella cartella rsources dando come nome, l'id del paziente
        $dom->save($path . "RESP-FAMILYMEMBERHISTORY-" . $data_xml["narrative"]["Id"] . ".xml");
        
        return $dom->saveXML();
    }
}