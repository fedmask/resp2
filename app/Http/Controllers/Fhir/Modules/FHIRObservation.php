<?php
namespace App\Http\Controllers\Fhir\Modules;

use App\Exceptions\FHIR as FHIR;
use App\Models\InvestigationCenter\CentriIndagini;
use App\Models\InvestigationCenter\Indagini;
use App\Models\Icd9\Icd9EsamiStrumentiCodici;
use Illuminate\Http\Request;


class FHIRObservation
{

    public function show($id)
    {
        $indagine = Indagini::where('id_indagine', $id)->first();
        
        if (! $indagine) {
            throw new FHIR\IdNotFoundInDatabaseException("resource with the id provided doesn't exist in database");
        }
        
        $values_in_narrative = array(
            "Identifier" => "RESP-OBSERVATION" . "-" . $indagine->getId(),
            "Status" => $indagine->getStatusDisplay(),
            "Category" => $indagine->getCategoryDisplay(),
            "Code" => $indagine->getCodeDisplay(),
            "Subject" => "FHIR-PATIENT-" . $indagine->getIdPaziente(),
            "EffectivePeriod" => $indagine->getDataFine(),
            "Issued" => $indagine->getIssued(),
            "Performer" => "FHIR-PRACTITIONER-".$indagine->getIdCpp(),
            "Interpretation" => $indagine->getInterpretationDisplay()
        );
        
        $data_xml["narrative"] = $values_in_narrative;
        $data_xml["indagine"] = $indagine;
        
        return view("pages.fhir.observation", [
            "data_output" => $data_xml
        ]);
    }
}

?>