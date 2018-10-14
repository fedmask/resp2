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
}