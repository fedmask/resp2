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
use DOMDocument;
use App\Http\Controllers\Fhir\Modules\FHIRPractitioner;
use App\Http\Controllers\Fhir\Modules\FHIRPatient;
use ZipArchive;
use App\Models\FHIR\Contatto;
use App\Models\Parente;
use App\Models\CodificheFHIR\RelationshipType;
use App\Models\Diagnosis\Diagnosi;

//Classe per la gestione della pagina fhir sul lato paziente
class FHIRPatientIndex
{
 
    function Index($id){
        $patient = Pazienti::where('id_paziente', $id)->first();
        
        
        return view("pages.fhir.indexPatient", [
            "data_output" => $patient
        ]);
    }
    
    function indexPractitioner($id){
        $patient = Pazienti::where('id_paziente', $id)->first();
        
        $cppPatient = CppPaziente::where('id_paziente', $patient->id_paziente)->get();
        
        $practitioner = array();
        
        foreach($cppPatient as $cpp){
            array_push($practitioner, CareProvider::where('id_cpp', $cpp->id_cpp)->first());
        }
        
        $data['practitioner'] = $practitioner;
        $data['patient'] = $patient;
        
        return view("pages.fhir.indexPractitioner", [
            "data_output" => $data
        ]);
    }
    
    function indexRelatedPerson($id){
        $patient = Pazienti::where('id_paziente', $id)->first();
        
        $contatti = Contatto::where('id_paziente', $patient->id_paziente)->get();
        
        
        $contatto = array();
        $contatto['emergency'] = $contatti;
        
        $pazFam = PazientiFamiliarita::where('id_paziente', $id)->get();
        
        $parenti = array();
        
        foreach($pazFam as $p){
            array_push($parenti, Parente::where('id_parente', $p->id_parente)->first());
        }
     
        $contatto['pazFam'] = $pazFam;
        $contatto['parenti'] = $parenti;
        $contatto['relazioni'] = RelationshipType::all();
        $contatto['patient'] = $patient;
        
        
        
        return view("pages.fhir.indexRelatedPerson", [
            "data_output" => $contatto
        ]);
    }
    
    function indexObservation($id){
        $patient = Pazienti::where('id_paziente', $id)->first();
        
        
        $ind = Indagini::where('id_paziente', $patient->id_paziente)->get();
        
        $diagnosi = Diagnosi::all();
        
        
        $data['indagini'] = $ind;
        $data['patient'] = $patient;
        $data['diagnosi'] = $diagnosi;
        
        return view("pages.fhir.indexObservation", [
            "data_output" => $data
        ]);
    }
    
    
    
    function exportResources($id, $list){
        $patient = Pazienti::where('id_paziente', $id)->first();
        
        $files = array();
        $resources = explode(",", $list);
      
        foreach($resources as $res){
            if($res == "Patient"){
                array_push($files, FHIRPatient::getResource($patient->id_paziente));
            }
            if($res == "Practitioner"){
                $cppPatient = CppPaziente::where('id_paziente', $patient->id_paziente)->get();
                
                foreach($cppPatient as $cpp){
                    array_push($files, FHIRPractitioner::getResource($cpp->id_cpp));
                }
            }
            if($res == "RelatedPerson"){
                $contatti = Contatto::where('id_paziente', $patient->id_paziente)->get();
                
                foreach($contatti as $cont){
                    array_push($files, FHIRRelatedPerson::getResource($cont->id_contatto.",Contatto"));
                }
                
                $pazFam = PazientiFamiliarita::where('id_paziente', $patient->id_paziente)->get();
                
                foreach($pazFam as $p){
                    array_push($files, FHIRRelatedPerson::getResource($p->id_parente.",Parente"));
                }
                
            }
            if($res == "Observation"){
                $indagini = Indagini::where('id_paziente', $patient->id_paziente)->get();
                
                foreach($indagini as $ind){
                    array_push($files, FHIRObservation::getResource($ind->id_indagine));
                }
            }
        }
        
        $path = getcwd()."\\resources\\Patient\\";
        
        $files = array();
        
        //carico tutti i file creati e salvati in public/resources/Paitent
        if ($handle = opendir($path)) {
            
            while (false !== ($entry = readdir($handle))) {
                
                if ($entry != "." && $entry != "..") {
                    
                    array_push($files, $entry);
                }
            }
            
            closedir($handle);
        }
        
        $filesXML = array();
        foreach($files as $file){
            array_push($filesXML, file_get_contents($path.$file));
        }
        
        
        $filename = "FHIR-RESOURCES.zip";
        $zip = new ZipArchive;
        $res = $zip->open($filename, ZipArchive::CREATE);
        
        $name = "file";
        $i = 0;
        foreach($filesXML as $file) {
            $zip->addFromString($files[$i], $file);
            $i++;
        }
            $zip->close();
            
            //elimino tutti i file creati e salvati in public/resources/Paitent
            if ($handle = opendir($path)) {
                
                while (false !== ($entry = readdir($handle))) {
                    
                    if ($entry != "." && $entry != "..") {
                        
                        unlink($path.$entry);
                    }
                }
                
                closedir($handle);
            }
            
            header('Content-type: application/zip');
            header('Content-Disposition: attachment; filename="'.$filename.'"');
            
            readfile($filename);
            
            //elimino lo zip salvato in locale dopo averlo fatto scaricare dall'utente
            unlink($filename);
                
    }
    
}
?>
