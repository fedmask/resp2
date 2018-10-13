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
        
        $data_xml["narrative"] = $values_in_narrative;
        $data_xml["narrative_participant"] = $narrative_participant;
        $data_xml["visita"] = $visita;
        $data_xml["participant"] = $participant;
        
        return view("pages.fhir.encounter", [
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
            foreach($lettura['participantStartPeriod'] as $s){
                array_push($startPeriod, Carbon::parse($s['attr'])->toDateTimeString());
            }
            
            $endPeriod = array();
            foreach($lettura['participantEndPeriod'] as $s){
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
                    'individual' => $partId[$i], //id_cpp
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
    
}