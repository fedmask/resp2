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

/**
 * Classe per la gestione delle operazioni di REST e per la creazione del file xml
 *
 * show => Visualizzazione di una risorsa
 * store => Memorizzazione di una nuova risorsa
 * update => Aggiornamento di una risorsa
 * delete => eliminazione di una risorsa
 */
class FHIRCondition
{

    /**
     * Funzione per la visualizzazione di una risorsa
     */
    public function show($id)
    {
        $diagnosi = Diagnosi::where('id_diagnosi', $id)->first();
        
        if (! $diagnosi) {
            throw new FHIR\IdNotFoundInDatabaseException("resource with the id provided doesn't exist in database");
        }
        
        $values_in_narrative = array(
            "Identifier" => "RESP-CONDITION" . "-" . $diagnosi->getId(),
            "ClinicalStatus" => $diagnosi->getClinicalStatus(),
            "VerificationStatus" => $diagnosi->getVerificationStatus(),
            "Severity" => $diagnosi->getSeverityDisplay(),
            "Code" => $diagnosi->getCodeDisplay(),
            "BodySite" => $diagnosi->getBodySiteDisplay(),
            "Stage" => $diagnosi->getStageDisplay(),
            "Evidence" => $diagnosi->getEvidenceDisplay(),
            "Subject" => $diagnosi->getPaziente(),
            "Note" => $diagnosi->getNote()
        );
        
        
        $narrative_extensions = array(
            "DataInizio" => $diagnosi->getDataInizio(),
            "DataFine" => $diagnosi->getDataFine(),
            "DataUltimoAggiornamento" => $diagnosi->getDataAggiornamento(),
            "Confidenzialita" => $diagnosi->getConfidenzialita()
        );
        
        $data_xml["extensions"] = $narrative_extensions;
        $data_xml["narrative"] = $values_in_narrative;
        $data_xml["diagnosi"] = $diagnosi;
        
        return view("pages.fhir.Condition.condition", [
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
        
        $diagnosi = Diagnosi::all();
        
        foreach ($diagnosi as $d) {
            if ($d->id_diagnosi == $id['identifier']) {
                throw new Exception("Diagnosi is already exists");
            }
        }
        
        $lettura = $xml->parse([
            'identifier' => [
                'uses' => 'identifier.value::value'
            ],
            'clinicalStatus' => [
                'uses' => 'clinicalStatus::value'
            ],
            'verificationStatus' => [
                'uses' => 'verificationStatus::value'
            ],
            'severity' => [
                'uses' => 'severity.coding.code::value'
            ],
            'severityDisplay' => [
                'uses' => 'severity.coding.display::value'
            ],
            'code' => [
                'uses' => 'code.coding.code::value'
            ],
            'codeDisplay' => [
                'uses' => 'code.coding.display::value'
            ],
            'bodySite' => [
                'uses' => 'bodySite.coding.code::value'
            ],
            'bodySiteDisplay' => [
                'uses' => 'bodySite.coding.display::value'
            ],
            'subject' => [
                'uses' => 'subject.reference::value'
            ],
            'stage' => [
                'uses' => 'stage.summary.coding.code::value'
            ],
            'stageDisplay' => [
                'uses' => 'stage.summary.coding.display::value'
            ],
            'evidence' => [
                'uses' => 'evidence.detail.reference::value'
            ],
            'evidenceDisplay' => [
                'uses' => 'evidence.detail.display::value'
            ],
            'note' => [
                'uses' => 'note.text::value'
            ]
        
        ]);
        
        $diagnosi = array(
            'id_diagnosi' => $lettura['identifier'],
            'id_paziente' => $id_paziente,
            'verificationStatus' => $lettura['verificationStatus'],
            'severity' => $lettura['severity'],
            'code' => $lettura['code'],
            'bodySite' => $lettura['bodySite'],
            'stageSummary' => $lettura['stage'],
            'evidenceCode' => $lettura['evidence'],
            'note' => $lettura['note'],
            'diagnosi_confidenzialita' => 3,
            'diagnosi_inserimento_data' => Carbon::now(new DateTimeZone('Europe/Rome')),
            'diagnosi_aggiornamento_data' => '',
            'diagnosi_patologia' => '',
            'diagnosi_stato' => $lettura['clinicalStatus'],
            'diagnosi_guarigione_data' => ''
        );
        
        $addDiagnosi = new Diagnosi();
        
        foreach ($diagnosi as $key => $value) {
            if (empty($value)) {
                continue;
            }
            $addDiagnosi->$key = $value;
        }
        $addDiagnosi->save();
        
        return response()->json($lettura['identifier'], 201);
    }

    public function update(Request $request, $id)
    {
        $file = $request->file('fileUpdate');
        $id_paziente = Input::get('patient_id');
        
        $xml = XmlParser::load($file->getRealPath());
        
        $id_diagnosi = $xml->parse([
            'identifier' => [
                'uses' => 'identifier.value::value'
            ]
        ]);
        
        if ($id != $id_diagnosi['identifier']) {
            throw new Exception("ERROR");
        }
        
        if (! Diagnosi::find($id_diagnosi['identifier'])) {
            throw new Exception("Condition does not exist in the database");
        }
        
        $lettura = $xml->parse([
            'identifier' => [
                'uses' => 'identifier.value::value'
            ],
            'clinicalStatus' => [
                'uses' => 'clinicalStatus::value'
            ],
            'verificationStatus' => [
                'uses' => 'verificationStatus::value'
            ],
            'severity' => [
                'uses' => 'severity.coding.code::value'
            ],
            'severityDisplay' => [
                'uses' => 'severity.coding.display::value'
            ],
            'code' => [
                'uses' => 'code.coding.code::value'
            ],
            'codeDisplay' => [
                'uses' => 'code.coding.display::value'
            ],
            'bodySite' => [
                'uses' => 'bodySite.coding.code::value'
            ],
            'bodySiteDisplay' => [
                'uses' => 'bodySite.coding.display::value'
            ],
            'subject' => [
                'uses' => 'subject.reference::value'
            ],
            'stage' => [
                'uses' => 'stage.summary.coding.code::value'
            ],
            'stageDisplay' => [
                'uses' => 'stage.summary.coding.display::value'
            ],
            'evidence' => [
                'uses' => 'evidence.detail.reference::value'
            ],
            'evidenceDisplay' => [
                'uses' => 'evidence.detail.display::value'
            ],
            'note' => [
                'uses' => 'note.text::value'
            ]
        
        ]);
        
        $diagnosi = array(
            'id_paziente' => $id_paziente,
            'verificationStatus' => $lettura['verificationStatus'],
            'severity' => $lettura['severity'],
            'code' => $lettura['code'],
            'bodySite' => $lettura['bodySite'],
            'stageSummary' => $lettura['stage'],
            'evidenceCode' => $lettura['evidence'],
            'note' => $lettura['note'],
            'diagnosi_confidenzialita' => 3,
            'diagnosi_inserimento_data' => Carbon::now(new DateTimeZone('Europe/Rome')),
            'diagnosi_aggiornamento_data' => '',
            'diagnosi_patologia' => '',
            'diagnosi_stato' => $lettura['clinicalStatus'],
            'diagnosi_guarigione_data' => ''
        );
        
        $updDiagnosi = Diagnosi::find($id_diagnosi['identifier']);
        
        foreach ($diagnosi as $key => $value) {
            if (empty($value)) {
                continue;
            }
            $updDiagnosi->$key = $value;
        }
        $updDiagnosi->save();
        
        return response()->json($id_diagnosi['identifier'], 200);
    }
    
    
    
    //inserisce l'indagine nella tabelle delle indagini eliminate in modo tale da non essere visualizzata
    //in quelle disponibili
    function destroy($id)
    {
        $id_paziente = Input::get('patient_id');
        $paziente = Pazienti::find($id_paziente);
        
        $id_utente = User::where('id_utente', $paziente->id_utente)->first()->id_utente;
        
        $diagnElim = array(
            'id_diagnosi' => $id,
            'id_utente' => $id_utente
        );
        
        $addDiagnElim = new DiagnosiEliminate();
        
        foreach ($diagnElim as $key => $value) {
            if (empty($value)) {
                continue;
            }
            $addDiagnElim->$key = $value;
        }
        
        $addDiagnElim->save();
        
        
        return response()->json(null, 204);
        
    }
    
    public static function getResource($id){
        
        $diagnosi = Diagnosi::where('id_diagnosi', $id)->first();
        
        $values_in_narrative = array(
            "Id" => $diagnosi->getId(),
            "Identifier" => "RESP-CONDITION" . "-" . $diagnosi->getId(),
            "ClinicalStatus" => $diagnosi->getClinicalStatus(),
            "VerificationStatus" => $diagnosi->getVerificationStatus(),
            "Severity" => $diagnosi->getSeverityDisplay(),
            "Code" => $diagnosi->getCodeDisplay(),
            "BodySite" => $diagnosi->getBodySiteDisplay(),
            "Stage" => $diagnosi->getStageDisplay(),
            "Evidence" => $diagnosi->getEvidenceDisplay(),
            "Subject" => $diagnosi->getPaziente(),
            "Note" => $diagnosi->getNote()
        );
        
        $narrative_extensions = array(
            "DataInizio" => $diagnosi->getDataInizio(),
            "DataFine" => $diagnosi->getDataFine(),
            "DataUltimoAggiornamento" => $diagnosi->getDataAggiornamento(),
            "Confidenzialita" => $diagnosi->getConfidenzialita()
        );
        
        $data_xml["extensions"] = $narrative_extensions;
        $data_xml["narrative"] = $values_in_narrative;
        $data_xml["diagnosi"] = $diagnosi;
        
        self::xml($data_xml);
    }
    
    
    public static function xml($data_xml){
        //Creazione di un oggetto dom con la codifica UTF-8
        $dom = new DOMDocument('1.0', 'utf-8');
        
        //Creazione del nodo Patient, cioè il nodo Root  della risorsa
        $cond = $dom->createElement('Condition');
        //Valorizzo il namespace della risorsa e del documento XML, in  questo caso la specifica FHIR
        $cond->setAttribute('xmlns', 'http://hl7.org/fhir');
        //Corrello l'elemento con il nodo superiore
        $cond = $dom->appendChild($cond);
        
        
        //Creazione del nodo ID sempre presente nelle risorse FHIR
        $id = $dom->createElement('id');
        //Il valore dell'ID è il valore dell'ID nella relativa tabella del DB
        $id->setAttribute('value', $data_xml["narrative"]["Id"]);
        $id = $cond->appendChild($id);
        
        //Creazione della parte narrativa in XHTML e composta da tag HTML visualizzabili se aperto il file XML in un Browser
        $narrative = $dom->createElement('text');
        //Corrello l'elemento con il nodo superiore
        $narrative = $cond->appendChild($narrative);
        
        
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
        //Data Inizio
        $extension1 = $dom->createElement('extension');
        $extension1->setAttribute('url', 'http://resp.local/resources/extensions/Condition/condition-data-inizio.xml');
        $extension1 = $cond->appendChild($extension1);
        
        $valueDate1 = $dom->createElement('valueDate');
        $valueDate1->setAttribute('value', $data_xml["extensions"]['DataInizio']);
        $valueDate1 = $extension1->appendChild($valueDate1);
        
        
        //Data Fine
        $extension2 = $dom->createElement('extension');
        $extension2->setAttribute('url', 'http://resp.local/resources/extensions/Condition/condition-data-fine.xml');
        $extension2 = $cond->appendChild($extension2);
        
        $valueDate2 = $dom->createElement('valueDate');
        $valueDate2->setAttribute('value', $data_xml["extensions"]['DataFine']);
        $valueDate2 = $extension2->appendChild($valueDate2);
        
        
        //Data Ultimo Aggiornamento
        $extension3 = $dom->createElement('extension');
        $extension3->setAttribute('url', 'http://resp.local/resources/extensions/Condition/condition-data-ultimo-aggiornameto.xml');
        $extension3 = $cond->appendChild($extension3);
        
        $valueDate3 = $dom->createElement('valueDate');
        $valueDate3->setAttribute('value', $data_xml["extensions"]['DataUltimoAggiornamento']);
        $valueDate3 = $extension3->appendChild($valueDate3);
        
        //Confidenzialita
        $extension4 = $dom->createElement('extension');
        $extension4->setAttribute('url', 'http://resp.local/resources/extensions/Condition/condition-confidenzialita.xml');
        $extension4 = $cond->appendChild($extension4);
        
        $valueInteger4 = $dom->createElement('valueInteger');
        $valueInteger4->setAttribute('value', $data_xml["extensions"]['Confidenzialita']);
        $valueInteger4 = $extension4->appendChild($valueInteger4);
        
        
        //END EXTENSIONS
        
        
        
        //Creazione del nodo identifier identificativo della risorsa Patient attraverso URI della risorsa
        $identifier = $dom->createElement('identifier');
        $identifier = $cond->appendChild($identifier);
        //Creazione del nodo value
        $value = $dom->createElement('value');
        //Do il valore all' URI della risorsa
        $value->setAttribute('value', $data_xml["narrative"]["Id"]);
        $value = $identifier->appendChild($value);
        
        
        
        
        //Creazione del nodo active settato a true in quanto la risorsa è attiva per il FSEM
        $clinicalStatus = $dom->createElement('clinicalStatus');
        $clinicalStatus->setAttribute('value', $data_xml["diagnosi"]->getClinicalStatus());
        $clinicalStatus = $cond->appendChild($clinicalStatus);
        
        
        
        //Creazione del nodo active settato a true in quanto la risorsa è attiva per il FSEM
        $verificationStatus = $dom->createElement('verificationStatus');
        $verificationStatus->setAttribute('value', $data_xml["diagnosi"]->getVerificationStatus());
        $verificationStatus = $cond->appendChild($verificationStatus);
        
        
        
        
        //creazione del nodo patient
        $severity = $dom->createElement('severity');
        $severity = $cond->appendChild($severity);
        
        $coding = $dom->createElement('coding');
        $coding = $severity->appendChild($coding);
        
        $system = $dom->createElement('system');
        $system->setAttribute('value', 'http://snomed.info/sct');
        $system = $coding->appendChild($system);
        
        $code = $dom->createElement('code');
        $code->setAttribute('value', $data_xml["diagnosi"]->getSeverity());
        $code = $coding->appendChild($code);
        
        $display = $dom->createElement('display');
        $display->setAttribute('value', $data_xml["diagnosi"]->getSeverityDisplay());
        $display = $coding->appendChild($display);
      
        
        
        //creazione del nodo patient
        $code = $dom->createElement('code');
        $code = $cond->appendChild($code);
        
        $coding = $dom->createElement('coding');
        $coding = $code->appendChild($coding);
        
        $system = $dom->createElement('system');
        $system->setAttribute('value', 'http://snomed.info/sct');
        $system = $coding->appendChild($system);
        
        $codeC = $dom->createElement('code');
        $codeC->setAttribute('value', $data_xml["diagnosi"]->getCode());
        $codeC = $coding->appendChild($codeC);
        
        $display = $dom->createElement('display');
        $display->setAttribute('value', $data_xml["diagnosi"]->getCodeDisplay());
        $display = $coding->appendChild($display);
        
        $text = $dom->createElement('text');
        $text->setAttribute('value', $data_xml["diagnosi"]->getCodeDisplay());
        $text = $code->appendChild($text);
        
        
        
        
        //creazione del nodo patient
        $bodySite = $dom->createElement('bodySite');
        $bodySite = $cond->appendChild($bodySite);
        
        $coding = $dom->createElement('coding');
        $coding = $bodySite->appendChild($coding);
        
        $system = $dom->createElement('system');
        $system->setAttribute('value', 'http://snomed.info/sct');
        $system = $coding->appendChild($system);
        
        $code = $dom->createElement('code');
        $code->setAttribute('value', $data_xml["diagnosi"]->getBodySite());
        $code = $coding->appendChild($code);
        
        $display = $dom->createElement('display');
        $display->setAttribute('value', $data_xml["diagnosi"]->getBodySiteDisplay());
        $display = $coding->appendChild($display);
        
        $text = $dom->createElement('text');
        $text->setAttribute('value', $data_xml["diagnosi"]->getBodySiteDisplay());
        $text = $bodySite->appendChild($text);
        
        
        
        
        //Creazione del nodo identifier identificativo della risorsa Patient attraverso URI della risorsa
        $subject = $dom->createElement('subject');
        $subject = $cond->appendChild($subject);
        
        $reference = $dom->createElement('reference');
        $reference->setAttribute('value', "RESP-PATIENT-".$data_xml["diagnosi"]->getPazienteId());
        $reference = $subject->appendChild($reference);
        
        
        
        
        
        //creazione del nodo patient
        $stage = $dom->createElement('stage');
        $stage = $cond->appendChild($stage);
        
        $summary = $dom->createElement('summary');
        $summary = $stage->appendChild($summary);
        
        $coding = $dom->createElement('coding');
        $coding = $summary->appendChild($coding);
        
        $system = $dom->createElement('system');
        $system->setAttribute('value', 'http://snomed.info/sct');
        $system = $coding->appendChild($system);
        
        $code = $dom->createElement('code');
        $code->setAttribute('value', $data_xml["diagnosi"]->getStage());
        $code = $coding->appendChild($code);
        
        $display = $dom->createElement('display');
        $display->setAttribute('value', $data_xml["diagnosi"]->getStageDisplay());
        $display = $coding->appendChild($display);
        
        
        
        //creazione del nodo patient
        $evidence = $dom->createElement('evidence');
        $evidence = $cond->appendChild($evidence);
        
        $detail = $dom->createElement('detail');
        $detail = $evidence->appendChild($detail);
        
        $reference = $dom->createElement('reference');
        $reference->setAttribute('value', $data_xml["diagnosi"]->getEvidence());
        $reference = $detail->appendChild($reference);
        
        $display = $dom->createElement('display');
        $display->setAttribute('value', $data_xml["diagnosi"]->getEvidenceDisplay());
        $display = $detail->appendChild($display);
        
        
        
        //Creazione del nodo identifier identificativo della risorsa Patient attraverso URI della risorsa
        $note = $dom->createElement('note');
        $note = $cond->appendChild($note);
        
        $text = $dom->createElement('text');
        $text->setAttribute('value', $data_xml["diagnosi"]->getNote());
        $text = $note->appendChild($text);
     
      
        
        //Elimino gli spazi bianchi superflui per la viasualizzazione grafica dell'XML
        $dom->preserveWhiteSpace = false;
        //Formatto il documento per l'output
        $dom->formatOutput = true;
        $path = getcwd()."\\resources\\Patient\\";
        //Salvo il documento XML nella cartella rsources dando come nome, l'id del paziente
        $dom->save($path."RESP-CONDITION-".$data_xml["narrative"]["Id"].".xml");
        
        return $dom->saveXML();
        
    }
}