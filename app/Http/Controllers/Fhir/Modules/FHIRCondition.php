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
        $data_xml["diagnosi"] = $diagnosi;
        
        return view("pages.fhir.condition", [
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
}