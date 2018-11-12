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
use App\Models\History\AnamnesiF;

/**
 * Classe per la gestione della pagina FHIR sul lato paziente
 */
class FHIRPatientIndex
{

    /**
     * Funzione per il reindirizzamento alla sezione Patient
     */
    function Index($id)
    {
        $patient = Pazienti::where('id_paziente', $id)->first();
        
        return view("pages.fhir.Patient.indexPatient", [
            "data_output" => $patient
        ]);
    }

    /**
     * Funzione per il reindirizzamento alla sezione Practitioner
     * Visulizza solo i CareProvider associati al Paziente loggato
     */
    function indexPractitioner($id)
    {
        $patient = Pazienti::where('id_paziente', $id)->first();

        $practitioner = CareProvider::all();
        
        $data['practitioner'] = $practitioner;
        $data['patient'] = $patient;
        
        return view("pages.fhir.Practitioner.indexPractitioner", [
            "data_output" => $data
        ]);
    }

    /**
     * Funzione per il reindirizzamento alla sezione RelatedPerson
     * Visualizza solo i Contatti di Emergenza e i Parenti associati al Paziente loggato
     */
    function indexRelatedPerson($id)
    {
        $patient = Pazienti::where('id_paziente', $id)->first();
        
        $contatti = Contatto::where('id_paziente', $patient->id_paziente)->get();
        
        $contatto = array();
        $contatto['emergency'] = $contatti;
        
        $pazFam = PazientiFamiliarita::where('id_paziente', $id)->get();
        
        $parenti = array();
        
        foreach ($pazFam as $p) {
            array_push($parenti, Parente::where('id_parente', $p->id_parente)->first());
        }
        
        $contatto['pazFam'] = $pazFam;
        $contatto['parenti'] = $parenti;
        $contatto['relazioni'] = RelationshipType::all();
        $contatto['patient'] = $patient;
        
        return view("pages.fhir.RelatedPerson.indexRelatedPerson", [
            "data_output" => $contatto
        ]);
    }

    /**
     * Funzione per il reindirizzamento alla sezione Observation
     * Visualizza solo le Indagini del Paziente loggato che non sono state eliminate
     */
    function indexObservation($id)
    {
        $patient = Pazienti::where('id_paziente', $id)->first();
        
        $ind = Indagini::where('id_paziente', $patient->id_paziente)->get();
        
        $indElim = IndaginiEliminate::all();
        
        // controllo che restituisce tutte le indagini del paz loggato che non sono state eliminate
        $indagini = array();
        foreach ($ind as $i) {
            if (! IndaginiEliminate::find($i->id_indagine)) {
                array_push($indagini, $i);
            }
        }
        
        $diagnosi = Diagnosi::all();
        
        $data['indagini'] = $indagini;
        $data['patient'] = $patient;
        $data['diagnosi'] = $diagnosi;
        
        return view("pages.fhir.Observation.indexObservation", [
            "data_output" => $data
        ]);
    }

    /**
     * Funzione per il reindirizzamento alla sezione Immunization
     * Visualizza le Vaccinazioni del Paziente loggato
     */
    function indexImmunization($id)
    {
        $patient = Pazienti::where('id_paziente', $id)->first();
        
        $vaccinazioni = Vaccinazione::where('id_paziente', $patient->id_paziente)->get();
        
        $data['vaccinazioni'] = $vaccinazioni;
        $data['patient'] = $patient;
        
        return view("pages.fhir.Immunization.indexImmunization", [
            "data_output" => $data
        ]);
    }
    
    /**
     * Funzione per il reindirizzamento alla sezione Encounter
     * Visualizza le Visite del Paziente loggato
     */
    function indexEncounter($id)
    {
        $patient = Pazienti::where('id_paziente', $id)->first();
        
        $visite = PazientiVisite::where('id_paziente', $patient->id_paziente)->get();
        
        $data['visite'] = $visite;
        $data['patient'] = $patient;
        
        return view("pages.fhir.Encounter.indexEncounter", [
            "data_output" => $data
        ]);
    }
    
    
    /**
     * Funzione per il reindirizzamento alla sezione Condition
     * Visualizza le Diagnosi del Paziente loggato
     */
    function indexCondition($id)
    {
        $patient = Pazienti::where('id_paziente', $id)->first();
        
        $dia = Diagnosi::where('id_paziente', $patient->id_paziente)->get();
        
        $diaElim = DiagnosiEliminate::all();
        
        // controllo che restituisce tutte le indagini del paz loggato che non sono state eliminate
        $diagnosi = array();
        foreach ($dia as $d) {
            if (! DiagnosiEliminate::find($d->id_diagnosi)) {
                array_push($diagnosi, $d);
            }
        }
        
        
        $data['diagnosi'] = $diagnosi;
        $data['patient'] = $patient;
        
        return view("pages.fhir.Condition.indexCondition", [
            "data_output" => $data
        ]);
    }
    
    
    /**
     * Funzione per il reindirizzamento alla sezione FamilyMemberHistory
     * Visualizza le Anamnesi Familiari di un parente del Paziente loggato
     */
    function indexFamilyMemberHistory($id)
    {
        $patient = Pazienti::where('id_paziente', $id)->first();
        
        $anamnesi = AnamnesiF::where('id_paziente', $patient->id_paziente)->get();
        
        $data['anamnesi'] = $anamnesi;
        $data['patient'] = $patient;
        
        return view("pages.fhir.FamilyMemberHistory.indexFamilyMemberHistory", [
            "data_output" => $data
        ]);
    }

    /**
     * Funzione che gestisce l'export multiplo delle risorse in tutte le sezioni
     */
    function exportResources($id, $list)
    {
        $patient = Pazienti::where('id_paziente', $id)->first();
        
        $files = array();
        $resources = explode(",", $list);
        
        // controllo le risorse che sono state selezionate e creo i file xml per ciascuna di esse
        foreach ($resources as $res) {
            if ($res == "Patient") {
                array_push($files, FHIRPatient::getResource($patient->id_paziente));
            }
            if ($res == "Practitioner") {
                $cppPatient = CppPaziente::where('id_paziente', $patient->id_paziente)->get();
                
                foreach ($cppPatient as $cpp) {
                    array_push($files, FHIRPractitioner::getResource($cpp->id_cpp));
                }
            }
            if ($res == "RelatedPerson") {
                $contatti = Contatto::where('id_paziente', $patient->id_paziente)->get();
                
                foreach ($contatti as $cont) {
                    array_push($files, FHIRRelatedPerson::getResource($cont->id_contatto . ",Contatto"));
                }
                
                $pazFam = PazientiFamiliarita::where('id_paziente', $patient->id_paziente)->get();
                
                foreach ($pazFam as $p) {
                    array_push($files, FHIRRelatedPerson::getResource($p->id_parente . ",Parente"));
                }
            }
            if ($res == "Observation") {
                $indagini = Indagini::where('id_paziente', $patient->id_paziente)->get();
                
                foreach ($indagini as $ind) {
                    array_push($files, FHIRObservation::getResource($ind->id_indagine));
                }
            }
            
            if ($res == "Immunization") {
                $vaccinazioni = Vaccinazione::where('id_paziente', $patient->id_paziente)->get();
                
                foreach ($vaccinazioni as $vacc) {
                    array_push($files, FHIRImmunization::getResource($vacc->id_vaccinazione));
                }
            }
            
            if ($res == "Encounter") {
                $visite = PazientiVisite::where('id_paziente', $patient->id_paziente)->get();
                
                foreach ($visite as $vis) {
                    array_push($files, FHIREncounter::getResource($vis->id_visita));
                }
            }
            
            if ($res == "Condition") {
                $diagnosi = Diagnosi::where('id_paziente', $patient->id_paziente)->get();
                
                foreach ($diagnosi as $diagn) {
                    array_push($files, FHIRCondition::getResource($diagn->id_diagnosi));
                }
            }
            
            if ($res == "FamilyMemberHistory") {
                $anamnesi = AnamnesiF::where('id_paziente', $patient->id_paziente)->get();
                
                foreach ($anamnesi as $anam) {
                    array_push($files, FHIRFamilyMemberHistory::getResource($anam->id_anamnesiF));
                }
            }
        }
        
        $path = getcwd() . "\\resources\\Patient\\";
        
        $files = array();
        
        // carico tutti i file creati e salvati in public/resources/Patient
        if ($handle = opendir($path)) {
            
            while (false !== ($entry = readdir($handle))) {
                
                if ($entry != "." && $entry != "..") {
                    
                    array_push($files, $entry);
                }
            }
            
            closedir($handle);
        }
        
        $filesXML = array();
        foreach ($files as $file) {
            array_push($filesXML, file_get_contents($path . $file));
        }
        
        $filename = "FHIR-RESOURCES.zip";
        $zip = new ZipArchive();
        $res = $zip->open($filename, ZipArchive::CREATE);
        
        $name = "file";
        $i = 0;
        foreach ($filesXML as $file) {
            $zip->addFromString($files[$i], $file);
            $i ++;
        }
        $zip->close();
        
        // elimino tutti i file creati e salvati in public/resources/Paitent
        if ($handle = opendir($path)) {
            
            while (false !== ($entry = readdir($handle))) {
                
                if ($entry != "." && $entry != "..") {
                    
                    unlink($path . $entry);
                }
            }
            
            closedir($handle);
        }
        
        header('Content-type: application/zip');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        readfile($filename);
        
        // elimino lo zip salvato in locale dopo averlo fatto scaricare dall'utente
        unlink($filename);
    }
}
?>
