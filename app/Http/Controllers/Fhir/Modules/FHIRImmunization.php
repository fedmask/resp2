<?php
namespace App\Http\Controllers\Fhir\Modules;

use App\Exceptions\FHIR as FHIR;
use App\Models\InvestigationCenter\CentriIndagini;
use App\Models\InvestigationCenter\Indagini;
use App\Models\Icd9\Icd9EsamiStrumentiCodici;
use Illuminate\Http\Request;
use View;
use Illuminate\Filesystem\Filesystem;
use File;
use Orchestra\Parser\Xml\Facade as XmlParser;
use Exception;
use DB;
use Redirect;
use Response;
use SimpleXMLElement;
use DOMDocument;
use Input;
use App\Models\CareProviders\CareProvider;
use DateTime;
use DateTimeZone;
use Date;
use Carbon\Carbon;
use App\Models\Vaccine\Vaccinazione;

class FHIRImmunization
{
    public function show($id)
    {
        $vaccinazione = Vaccinazione::where('id_vaccinazione', $id)->first();
        
        if (! $vaccinazione) {
            throw new FHIR\IdNotFoundInDatabaseException("resource with the id provided doesn't exist in database");
        }
        
        $values_in_narrative = array(
            "Identifier" => "RESP-IMMUNIZATION" . "-" . $vaccinazione->getId(),
            "Status" => $vaccinazione->getStato(),
            "VaccineCode" => $vaccinazione->getVaccineCodeDisplay(),
            "Patient" => $vaccinazione->getPaziente(),
            "Date" => $vaccinazione->getData(),
            "Route" => $vaccinazione->getRouteDisplay(),
            "DoseQuantity" => $vaccinazione->getQuantity()." mg",
            "Practitioner" => $vaccinazione->getCpp(),
            "Note" => $vaccinazione->getNote()
        );
        
        $data_xml["narrative"] = $values_in_narrative;
        $data_xml["vaccinazione"] = $vaccinazione;
        
        return view("pages.fhir.immunization", [
            "data_output" => $data_xml
        ]);
    }
}