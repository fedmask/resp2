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
use App\Models\Vaccine\Vaccinazione;
use App\Models\FHIR\EncounterParticipant;
use Input;
use Carbon\Carbon;

/**
 * Classe per la gestione delle operazioni di REST e per la creazione del file xml
 *
 * show => Visualizzazione di una risorsa
 * store => Memorizzazione di una nuova risorsa
 * update => Aggiornamento di una risorsa
 * delete => eliminazione di una risorsa
 */
class FHIREncounter
{

    /**
     * Funzione per la visualizzazione di una risorsa
     */
    public function show($id)
    {
        $visita = PazientiVisite::where('id_visita', $id)->first();
        
        if (! $visita) {
            throw new FHIR\IdNotFoundInDatabaseException("resource with the id provided doesn't exist in database");
        }
        
        $values_in_narrative = array(
            "Identifier" => "RESP-ENCOUNTER" . "-" . $visita->getId(),
            "Status" => $visita->getStatusDisplay(),
            "Class" => $visita->getClassDisplay(),
            "Start_Period" => $visita->getStartPeriod(),
            "End_Period" => $visita->getEndPeriod(),
            "Subject" => $visita->getPaziente(),
            "Reason" => $visita->getReasonDisplay()
        );
        
        // Encounter.Participant
        $participant = EncounterParticipant::where('id_visita', $id)->get();
        
        $narrative_participant = array();
        $i = 0;
        foreach ($participant as $p) {
            $i ++;
            $narrative_participant["Individual" . $i] = $p->getIndividual();
            $narrative_participant["Type" . $i] = $p->getTypeDisplay();
            $narrative_participant["Start_Period" . $i] = $p->getStartPeriod();
            $narrative_participant["End_Period" . $i] = $p->getEndPeriod();
        }
        
        
        $narrative_extensions = array(
            "AltraMotivazione" => $visita->getAltraMotivazione(),
            "Osservazioni" => $visita->getOsservazioni(),
            "Conclusioni" => $visita->getConclusioni()
        );
        
        $data_xml["extensions"] = $narrative_extensions;
        $data_xml["narrative"] = $values_in_narrative;
        $data_xml["narrative_participant"] = $narrative_participant;
        $data_xml["visita"] = $visita;
        $data_xml["participant"] = $participant;
        
        return view("pages.fhir.Encounter.encounter", [
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
        
        $visite = PazientiVisite::all();
        
        foreach ($visite as $v) {
            if ($v->id_visita == $id['identifier']) {
                throw new Exception("Visita is already exists");
            }
        }
        
        $lettura = $xml->parse([
            'identifier' => [
                'uses' => 'identifier.value::value'
            ],
            'status' => [
                'uses' => 'status::value'
            ],
            'classCode' => [
                'uses' => 'class.code::value'
            ],
            'classDisplay' => [
                'uses' => 'class.display::value'
            ],
            'subjectReference' => [
                'uses' => 'subject.reference::value'
            ],
            'subjectDisplay' => [
                'uses' => 'subject.display::value'
            ],
            'participantType' => [
                'uses' => 'participant[type.coding.code::value>attr]'
            ],
            'participantStartPeriod' => [
                'uses' => 'participant[period.start::value>attr]'
            ],
            'participantEndPeriod' => [
                'uses' => 'participant[period.end::value>attr]'
            ],
            'participantIndividualReference' => [
                'uses' => 'participant[individual.reference::value>attr]'
            ],
            'participantIndividualDisplay' => [
                'uses' => 'participant[individual.display::value>attr]'
            ],
            'periodStart' => [
                'uses' => 'period.start::value'
            ],
            'periodEnd' => [
                'uses' => 'period.end::value'
            ],
            'reasonCode' => [
                'uses' => 'reason.coding.code::value'
            ],
            'reasonDisplay' => [
                'uses' => 'reason.coding.display::value'
            ]
        
        ]);
        
        $dateStartPeriod = Carbon::parse($lettura['periodStart'])->toDateTimeString();
        
        $dateEndPeriod = Carbon::parse($lettura['periodEnd'])->toDateTimeString();
        
        $visita = array(
            'id_visita' => $lettura['identifier'],
            'id_cpp' => '1',
            'id_paziente' => $id_paziente,
            'status' => $lettura['status'],
            'class' => $lettura['classCode'],
            'start_period' => $dateStartPeriod,
            'end_period' => $dateEndPeriod,
            'reason' => $lettura['reasonCode'],
            'visita_data' => $dateStartPeriod,
            'visita_motivazione' => '',
            'visita_osservazioni' => '',
            'visita_conclusioni' => '',
            'stato_visita' => $lettura['status'],
            'codice_priorita' => '1',
            'tipo_richiesta' => '',
            'richiesta_visita_inizio' => $dateStartPeriod,
            'richiesta_visita_fine' => $dateEndPeriod
        );
        
        $addVisita = new PazientiVisite();
        
        foreach ($visita as $key => $value) {
            if (empty($value)) {
                continue;
            }
            $addVisita->$key = $value;
        }
        $addVisita->save();
        
        if (! is_null($lettura['participantType'])) {
            
            $partType = array();
            foreach ($lettura['participantType'] as $p) {
                array_push($partType, $p['attr']);
            }
            // estraggo gli id dei partecipanti
            $partId = array();
            foreach ($lettura['participantIndividualReference'] as $p) {
                $expl = explode("-", $p['attr']);
                array_push($partId, $expl[2]);
            }
            // controllo se i providers sono presenti nel sistema
            $cpp = CareProvider::all();
            foreach ($partId as $id) {
                if (! CareProvider::find($id)) {
                    throw new Exception("Providers not exists");
                }
            }
            
            $startPeriod = array();
            foreach ($lettura['participantStartPeriod'] as $s) {
                array_push($startPeriod, Carbon::parse($s['attr'])->toDateTimeString());
            }
            
            $endPeriod = array();
            foreach ($lettura['participantEndPeriod'] as $s) {
                array_push($endPeriod, Carbon::parse($s['attr'])->toDateTimeString());
            }
            
            $partStart = array();
            foreach ($startPeriod as $r) {
                array_push($partStart, $r);
            }
            
            $partEnd = array();
            foreach ($endPeriod as $r) {
                array_push($partEnd, $r);
            }
            
            $arrayPart = array();
            $i = 0;
            foreach ($partType as $p) {
                $visitaPart = array(
                    'id_visita' => $lettura['identifier'],
                    'individual' => $partId[$i], // id_cpp
                    'type' => $partType[$i],
                    'start_period' => $partStart[$i],
                    'end_period' => $partEnd[$i]
                );
                array_push($arrayPart, $visitaPart);
                $i ++;
            }
            
            $addVisitaPart = new EncounterParticipant();
            foreach ($arrayPart as $p) {
                $addVisitaPart = new EncounterParticipant();
                foreach ($p as $key => $value) {
                    if (empty($value)) {
                        continue;
                    }
                    $addVisitaPart->$key = $value;
                }
                $addVisitaPart->save();
            }
        }
        
        return response()->json($lettura['identifier'], 201);
    }

    public function update(Request $request, $id)
    {
        $file = $request->file('fileUpdate');
        $id_paziente = Input::get('patient_id');
        
        $xml = XmlParser::load($file->getRealPath());
        
        $id_visita = $xml->parse([
            'identifier' => [
                'uses' => 'identifier.value::value'
            ]
        ]);
        
        if ($id != $id_visita['identifier']) {
            throw new Exception("ERROR");
        }
        
        if (! PazientiVisite::find($id_visita['identifier'])) {
            throw new Exception("Observation does not exist in the database");
        }
        
        $lettura = $xml->parse([
            'identifier' => [
                'uses' => 'identifier.value::value'
            ],
            'status' => [
                'uses' => 'status::value'
            ],
            'classCode' => [
                'uses' => 'class.code::value'
            ],
            'classDisplay' => [
                'uses' => 'class.display::value'
            ],
            'subjectReference' => [
                'uses' => 'subject.reference::value'
            ],
            'subjectDisplay' => [
                'uses' => 'subject.display::value'
            ],
            'participantType' => [
                'uses' => 'participant[type.coding.code::value>attr]'
            ],
            'participantStartPeriod' => [
                'uses' => 'participant[period.start::value>attr]'
            ],
            'participantEndPeriod' => [
                'uses' => 'participant[period.end::value>attr]'
            ],
            'participantIndividualReference' => [
                'uses' => 'participant[individual.reference::value>attr]'
            ],
            'participantIndividualDisplay' => [
                'uses' => 'participant[individual.display::value>attr]'
            ],
            'periodStart' => [
                'uses' => 'period.start::value'
            ],
            'periodEnd' => [
                'uses' => 'period.end::value'
            ],
            'reasonCode' => [
                'uses' => 'reason.coding.code::value'
            ],
            'reasonDisplay' => [
                'uses' => 'reason.coding.display::value'
            ]
        
        ]);
        
        $dateStartPeriod = Carbon::parse($lettura['periodStart'])->toDateTimeString();
        
        $dateEndPeriod = Carbon::parse($lettura['periodEnd'])->toDateTimeString();
        
        $visita = array(
            'id_cpp' => '1',
            'id_paziente' => $id_paziente,
            'status' => $lettura['status'],
            'class' => $lettura['classCode'],
            'start_period' => $dateStartPeriod,
            'end_period' => $dateEndPeriod,
            'reason' => $lettura['reasonCode'],
            'visita_data' => $dateStartPeriod,
            'visita_motivazione' => '',
            'visita_osservazioni' => '',
            'visita_conclusioni' => '',
            'stato_visita' => $lettura['status'],
            'codice_priorita' => '1',
            'tipo_richiesta' => '',
            'richiesta_visita_inizio' => $dateStartPeriod,
            'richiesta_visita_fine' => $dateEndPeriod
        );
        
        $updVisita = PazientiVisite::find($id_visita['identifier']);
        
        foreach ($visita as $key => $value) {
            if (empty($value)) {
                continue;
            }
            $updVisita->$key = $value;
        }
        
         $updVisita->save();
        
        if (! is_null($lettura['participantType'])) {
            
            $partType = array();
            foreach ($lettura['participantType'] as $p) {
                array_push($partType, $p['attr']);
            }
            // estraggo gli id dei partecipanti
            $partId = array();
            foreach ($lettura['participantIndividualReference'] as $p) {
                $expl = explode("-", $p['attr']);
                array_push($partId, $expl[2]);
            }
            // controllo se i providers sono presenti nel sistema
            $cpp = CareProvider::all();
            foreach ($partId as $id) {
                if (! CareProvider::find($id)) {
                    throw new Exception("Providers not exists");
                }
            }
            
            $startPeriod = array();
            foreach ($lettura['participantStartPeriod'] as $s) {
                array_push($startPeriod, Carbon::parse($s['attr'])->toDateTimeString());
            }
            
            $endPeriod = array();
            foreach ($lettura['participantEndPeriod'] as $s) {
                array_push($endPeriod, Carbon::parse($s['attr'])->toDateTimeString());
            }
            
            $partStart = array();
            foreach ($startPeriod as $r) {
                array_push($partStart, $r);
            }
            
            $partEnd = array();
            foreach ($endPeriod as $r) {
                array_push($partEnd, $r);
            }
            
            $arrayPart = array();
            $i = 0;
            foreach ($partType as $p) {
                $visitaPart = array(
                    'id_visita' => $lettura['identifier'],
                    'individual' => $partId[$i], // id_cpp
                    'type' => $partType[$i],
                    'start_period' => $partStart[$i],
                    'end_period' => $partEnd[$i]
                );
                array_push($arrayPart, $visitaPart);
                $i ++;
            }
            
            EncounterParticipant::find($id_visita['identifier'])->delete();
            
            $addVisitaPart = new EncounterParticipant();
            foreach ($arrayPart as $p) {
                $addVisitaPart = new EncounterParticipant();
                foreach ($p as $key => $value) {
                    if (empty($value)) {
                        continue;
                    }
                    $addVisitaPart->$key = $value;
                }
                $addVisitaPart->save();
            }
        }
        
        return response()->json($id_visita['identifier'], 200);
    }
    
    function destroy($id)
    {
        
        EncounterParticipant::find($id)->delete();
        
        PazientiVisite::find($id)->delete();
        
        return response()->json(null, 204);
        
    }
    
    public static function getResource($id)
    {
        $visita = PazientiVisite::where('id_visita', $id)->first();
        
        if (! $visita) {
            throw new FHIR\IdNotFoundInDatabaseException("resource with the id provided doesn't exist in database");
        }
        
        $values_in_narrative = array(
            "Id" => $visita->getId(),
            "Identifier" => "RESP-ENCOUNTER" . "-" . $visita->getId(),
            "Status" => $visita->getStatusDisplay(),
            "Class" => $visita->getClassDisplay(),
            "Start_Period" => $visita->getStartPeriod(),
            "End_Period" => $visita->getEndPeriod(),
            "Subject" => $visita->getPaziente(),
            "Reason" => $visita->getReasonDisplay()
        );
        
        // Encounter.Participant
        $participant = EncounterParticipant::where('id_visita', $id)->get();
        
        $narrative_participant = array();
        $i = 0;
        foreach ($participant as $p) {
            $i ++;
            $narrative_participant["Individual" . $i] = $p->getIndividual();
            $narrative_participant["Type" . $i] = $p->getTypeDisplay();
            $narrative_participant["Start_Period" . $i] = $p->getStartPeriod();
            $narrative_participant["End_Period" . $i] = $p->getEndPeriod();
        }
        
        $narrative_extensions = array(
            "AltraMotivazione" => $visita->getAltraMotivazione(),
            "Osservazioni" => $visita->getOsservazioni(),
            "Conclusioni" => $visita->getConclusioni()
        );
        
        $data_xml["extensions"] = $narrative_extensions;
        $data_xml["narrative"] = $values_in_narrative;
        $data_xml["narrative_participant"] = $narrative_participant;
        $data_xml["visita"] = $visita;
        $data_xml["participant"] = $participant;
        
        self::xml($data_xml);
    }
    
    public static function xml($data_xml)
    {
        // Creazione di un oggetto dom con la codifica UTF-8
        $dom = new DOMDocument('1.0', 'utf-8');
        
        // Creazione del nodo Patient, cioè il nodo Root della risorsa
        $enc = $dom->createElement('Encounter');
        // Valorizzo il namespace della risorsa e del documento XML, in questo caso la specifica FHIR
        $enc->setAttribute('xmlns', 'http://hl7.org/fhir');
        // Corrello l'elemento con il nodo superiore
        $enc = $dom->appendChild($enc);
        
        // Creazione del nodo ID sempre presente nelle risorse FHIR
        $id = $dom->createElement('id');
        // Il valore dell'ID è il valore dell'ID nella relativa tabella del DB
        $id->setAttribute('value', $data_xml["narrative"]["Id"]);
        $id = $enc->appendChild($id);
        
        // Creazione della parte narrativa in XHTML e composta da tag HTML visualizzabili se aperto il file XML in un Browser
        $narrative = $dom->createElement('text');
        // Corrello l'elemento con il nodo superiore
        $narrative = $enc->appendChild($narrative);
        
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
        
        
        //Narrative.Participant
        foreach ($data_xml["narrative_participant"] as $key => $value) {
            $tr = $dom->createElement('tr');
            $tr = $tbody->appendChild($tr);
            
            // Creazione della colonna BirthDate
            $td = $dom->createElement('td', $key);
            $td = $tr->appendChild($td);
            
            // Creazione della colonna con il valore di nome e cognome del paziente
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
        //Altra Motivazione
        $extension1 = $dom->createElement('extension');
        $extension1->setAttribute('url', 'http://resp.local/resources/extensions/Encounter/encounter-altra-motivazione.xml');
        $extension1 = $enc->appendChild($extension1);
        
        $valueString1 = $dom->createElement('valueString');
        $valueString1->setAttribute('value', $data_xml["extensions"]['AltraMotivazione']);
        $valueString1 = $extension1->appendChild($valueString1);
        
        
        //Osservazioni
        $extension2 = $dom->createElement('extension');
        $extension2->setAttribute('url', 'http://resp.local/resources/extensions/Encounter/encounter-osservazioni.xml');
        $extension2 = $enc->appendChild($extension2);
        
        $valueString2 = $dom->createElement('valueString');
        $valueString2->setAttribute('value', $data_xml["extensions"]['Osservazioni']);
        $valueString2 = $extension2->appendChild($valueString2);
        
        
        //Conclusioni
        $extension3 = $dom->createElement('extension');
        $extension3->setAttribute('url', 'http://resp.local/resources/extensions/Encounter/encounter-conclusioni.xml');
        $extension3 = $enc->appendChild($extension3);
        
        $valueString3 = $dom->createElement('valueString');
        $valueString3->setAttribute('value', $data_xml["extensions"]['Conclusioni']);
        $valueString3 = $extension3->appendChild($valueString3);
        
        //END EXTENSIONS
        
        
        // Creazione del nodo identifier identificativo della risorsa Patient attraverso URI della risorsa
        $identifier = $dom->createElement('identifier');
        $identifier = $enc->appendChild($identifier);
        // Creazione del nodo use 
        $use = $dom->createElement('use');
        $use->setAttribute('value', 'official'); // RFC gestione URI
        $use = $identifier->appendChild($use);
        // Creazione del nodo system
        $system = $dom->createElement('system');
        $system->setAttribute('value', 'http://resp.local'); // RFC gestione URI
        $system = $identifier->appendChild($system);
        // Creazione del nodo value
        $value = $dom->createElement('value');
        // Do il valore all' URI della risorsa
        $value->setAttribute('value', $data_xml["narrative"]["Id"]);
        $value = $identifier->appendChild($value);
        
        $status = $dom->createElement('status');
        $status->setAttribute('value', $data_xml["visita"]->getStatus());
        $status = $enc->appendChild($status);
        
        // Creazione del nodo active settato a true in quanto la risorsa è attiva per il FSEM
        $class = $dom->createElement('class');
        $class = $enc->appendChild($class);
        
        $system = $dom->createElement('system');
        $system->setAttribute('value', 'http://hl7.org/fhir/v3/ActCode'); // RFC gestione URI
        $system = $class->appendChild($system);
        
        $code = $dom->createElement('code');
        $code->setAttribute('value', $data_xml["visita"]->getClass());
        $code = $class->appendChild($code);
        
        $display = $dom->createElement('display');
        $display->setAttribute('value', $data_xml["visita"]->getClassDisplay());
        $display = $class->appendChild($display);
        
        
        
        $subject = $dom->createElement('subject');
        $subject = $enc->appendChild($subject);
        
        $reference = $dom->createElement('reference');
        $reference->setAttribute('value', "RESP-PATIENT-" . $data_xml["visita"]->getIdPaziente());
        $reference = $subject->appendChild($reference);
        
        $display = $dom->createElement('display');
        $display->setAttribute('value', $data_xml["visita"]->getPaziente());
        $display = $subject->appendChild($display);
        
        
        
        foreach ($data_xml["participant"] as $p) {
            
            $participant = $dom->createElement('participant');
            $participant = $enc->appendChild($participant);
            
            $type = $dom->createElement('type');
            $type = $participant->appendChild($type);
            
            $coding = $dom->createElement('coding');
            $coding = $type->appendChild($coding);
            
            $system = $dom->createElement('system');
            $system->setAttribute('value', 'http://hl7.org/fhir/v3/ParticipationType');
            $system = $coding->appendChild($system);
            
            $code = $dom->createElement('code');
            $code->setAttribute('value', $p->getType());
            $code = $coding->appendChild($code);
            
            
            $period = $dom->createElement('period');
            $period = $participant->appendChild($period);
            
            $start = $dom->createElement('start');
            $start->setAttribute('value', $p->getStartPeriod());
            $start = $period->appendChild($start);
            
            $end = $dom->createElement('end');
            $end->setAttribute('value', $p->getEndPeriod());
            $end = $period->appendChild($end);
            
            
            
            $individual = $dom->createElement('individual');
            $individual = $participant->appendChild($individual);
            
            $reference = $dom->createElement('reference');
            $reference->setAttribute('value', "RESP-PRACTITIONER-" . $p->getIndividualId());
            $reference = $individual->appendChild($reference);
            
            $display = $dom->createElement('display');
            $display->setAttribute('value', $p->getIndividual());
            $display = $individual->appendChild($display);
            
        }
        
        
        $period = $dom->createElement('period');
        $period = $enc->appendChild($period);
        
        $start = $dom->createElement('start');
        $start->setAttribute('value', $data_xml["visita"]->getStartPeriod());
        $start = $period->appendChild($start);
        
        $end = $dom->createElement('end');
        $end->setAttribute('value', $data_xml["visita"]->getEndPeriod());
        $end = $period->appendChild($end);
       
        
        
        $reason = $dom->createElement('reason');
        $reason = $enc->appendChild($reason);
        
        $coding = $dom->createElement('coding');
        $coding = $reason->appendChild($coding);
        
        $system = $dom->createElement('system');
        $system->setAttribute('value', 'http://snomed.info/sct'); // RFC gestione URI
        $system = $coding->appendChild($system);
        
        $code = $dom->createElement('code');
        $code->setAttribute('value', $data_xml["visita"]->getReason());
        $code = $coding->appendChild($code);
        
        $display = $dom->createElement('display');
        $display->setAttribute('value', $data_xml["visita"]->getReasonDisplay());
        $display = $coding->appendChild($display);
       

        
        
        // Elimino gli spazi bianchi superflui per la viasualizzazione grafica dell'XML
        $dom->preserveWhiteSpace = false;
        // Formatto il documento per l'output
        $dom->formatOutput = true;
        $path = getcwd() . "\\resources\\Patient\\";
        // Salvo il documento XML nella cartella rsources dando come nome, l'id del paziente
        $dom->save($path . "RESP-ENCOUNTER-" . $data_xml["narrative"]["Id"] . ".xml");
        
        return $dom->saveXML();
    }
}