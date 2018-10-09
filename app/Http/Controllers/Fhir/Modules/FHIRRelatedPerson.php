<?php
namespace App\Http\Controllers\Fhir\Modules;

use App\Http\Controllers\Fhir\Modules\FHIRResource;
use App\Models\Patient\Pazienti;
use App\Models\Patient\PazientiVisite;
use App\Models\Patient\ParametriVitali;
use App\Models\Patient\PazientiContatti;
use App\Models\CareProviders\CppPaziente;
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
use App\Models\FHIR\Contatto;
use App\Models\Parente;
use App\Models\CodificheFHIR\RelationshipType;
use App\Models\Patient\PazientiFamiliarita;


class FHIRRelatedPerson
{
    
    public function show($id)
    {
        $id = explode(",", $id);
        $tipo = $id[1];
        $id = $id[0];
        
        $relPers;
        $values_in_narrative;
        
        if($tipo == "Contatto"){
            $relPers = new Contatto();
            $relPers = Contatto::where('id_contatto', $id)->first();
            
            if (!$relPers  ) {
                throw new FHIR\IdNotFoundInDatabaseException("resource with the id provided doesn't exist in database");
            }
            
            $values_in_narrative = array(
                "Identifier" => "RESP-RELATEDPERSON-EM" . "-" . $relPers->getId(),
                "Active" => $relPers->isActive(),
                "Patient" => "FHIR-PATIENT-".$relPers->getIdPaziente(),
                "Relationship" => $relPers->getRelazione(),
                "Name" => $relPers->getFullName(),
                "Telecom" => $relPers->getTelecom(),
                "Gender" => $relPers->getSesso(),
                "BirthDate" => $relPers->getDataNascita()
            );
        
        
        }else{
            $relPers = new Parente();
            $relPers = Parente::where('id_parente', $id)->first();
            
            if (!$relPers  ) {
                throw new FHIR\IdNotFoundInDatabaseException("resource with the id provided doesn't exist in database");
            }
            
            $values_in_narrative = array(
                "Identifier" => "RESP-RELATEDPERSON-REL" . "-" . $relPers->getId(),
                "Active" => $relPers->isActive(),
                "Patient" => "FHIR-PATIENT-".$relPers->getIdPaziente(),
                "Relationship" => $relPers->getRelazione(),
                "Name" => $relPers->getFullName(),
                "Telecom" => $relPers->getTelecom(),
                "Gender" => $relPers->getSesso(),
                "BirthDate" => $relPers->getDataNascita()
            );
        }
        
                
        $data_xml["narrative"] = $values_in_narrative;
        $data_xml["relPers"] = $relPers;
        
        return view("pages.fhir.relatedPerson", [
            "data_output" => $data_xml
        ]);
        
        
    }
}