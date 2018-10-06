<?php
namespace App\Http\Controllers\Fhir\Modules;

use App\Http\Controllers\Fhir\Modules\FHIRResource;
use App\Models\Patient\Pazienti;
use App\Models\Patient\PazientiVisite;
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
        
        return view("pages.fhir.indexPractitioner", [
            "data_output" => $practitioner
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
        
        
        $filename = "PATIENT.zip";
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
