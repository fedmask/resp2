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
        
        return view("pages.fhir.familyMemberHistory", [
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
}