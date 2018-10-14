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
}