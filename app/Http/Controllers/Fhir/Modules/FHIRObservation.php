<?php

namespace App\Http\Controllers\Fhir\Modules;

use App\Exceptions\FHIR as FHIR;
use App\Models\InvestigationCenter\CentriIndagini;
use App\Models\InvestigationCenter\Indagini;
use App\Models\Icd9\Icd9EsamiStrumentiCodici;
use Illuminate\Http\Request;

class FHIRObservation {

    function delete($id_observation) {
        
        if (!Indagini::where($id_observation)->exists()) {
            throw new FHIR\IdNotFoundInDatabaseException("resource with the id provided doesn't exist in database");
        }

        CentriIndagini::find($id_observation)->delete();
    }

    function update(Request $request, $id_observation) {
        
        $doc = new \SimpleXMLElement($request->getContent());
        
        $datafrom_patient_id         = explode("/", $doc->subject->reference["value"]);
        $datafrom_patient_id         = end($datafrom_patient_id);
        
        $datafrom_observation_id     = explode("/", $doc->identifier->value["value"]);
        $datafrom_observation_id     = end($datafrom_observation_id);
        
        $datafrom_cpp_id     = explode("/", $doc->performer->reference["value"]);
        $datafrom_cpp_id     = end($datafrom_cpp_id);
        
        $datafrom_observation_data   = $doc->effectiveDateTime["value"];
        $datafrom_observation_status = $doc->status["value"];
        
        $datafrom_observation_type   = $doc->extension[0]->valueString["value"];
        $datafrom_observation_reason = $doc->extension[1]->valueString["value"];
        
        $datafrom_observation_loinc  = $doc->code->coding->code["value"];
        $datafrom_observation_icd9   = $doc->code->coding->display["value"];
        
        /** VERIFICO LA PRESENZA DI ALCUNI DATI NECESSARI PER LA REGISTRAZIONE **/
        
        if (empty($datafrom_patient_id)) {
            throw new FHIR\InvalidResourceFieldException("observation patient id cannot be empty !");
        }
        
        if (empty($datafrom_observation_id)) {
            throw new FHIR\InvalidResourceFieldException("observation id cannot be empty !");
        }
        
        if (empty($datafrom_observation_data)) {
            throw new FHIR\InvalidResourceFieldException("observation data cannot be empty !");
        }
        
        if (empty($datafrom_observation_status)) {
            throw new FHIR\InvalidResourceFieldException("observation status cannot be empty !");
        }
        
        if (empty($datafrom_observation_type)) {
            throw new FHIR\InvalidResourceFieldException("observation type cannot be empty !");
        }
        
        if (empty($datafrom_observation_reason)) {
            throw new FHIR\InvalidResourceFieldException("observation reason cannot be empty !");
        }
        
        if (empty($datafrom_observation_loinc)) {
            throw new FHIR\InvalidResourceFieldException("observation loinc cannot be empty !");
        }
        
        /** VALIDAZIONE ANDATA A BUON FINE - CREO IL PAZIENTE E L'UTENTE ASSOCIATO **/
        
        $observation = Indagini::find($id_observation);
        
        $observation->id_diagnosi           = $datafrom_observation_id;
        $observation->id_paziente           = $datafrom_patient_id;
        $observation->id_cpp                = $datafrom_cpp_id;
        $observation->indagine_codice_loinc = $datafrom_observation_loinc;
        $observation->indagine_data         = $datafrom_observation_data;
        $observation->indagine_stato        = $observation->getStatusFromFHIR($datafrom_observation_status);
        $observation->indagine_tipologia    = $datafrom_observation_type;
        $observation->indagine_motivo       = $datafrom_observation_reason;
        
        $observation->save();
    }

    function store(Request $request) {

        $doc = new \SimpleXMLElement($request->getContent());
        
        $datafrom_patient_id         = explode("/", $doc->subject->reference["value"]);
        $datafrom_patient_id         = end($datafrom_patient_id);
        
        $datafrom_observation_id     = explode("/", $doc->identifier->value["value"]);
        $datafrom_observation_id     = end($datafrom_observation_id);

        $datafrom_cpp_id     = explode("/", $doc->performer->reference["value"]);
        $datafrom_cpp_id     = end($datafrom_cpp_id);
        
        $datafrom_observation_data   = $doc->effectiveDateTime["value"];
        $datafrom_observation_status = $doc->status["value"];
        
        $datafrom_observation_type   = $doc->extension[0]->valueString["value"];
        $datafrom_observation_reason = $doc->extension[1]->valueString["value"];
        
        $datafrom_observation_loinc  = $doc->code->coding->code["value"];
        $datafrom_observation_icd9   = $doc->code->coding->display["value"];
        
        /** VERIFICO LA PRESENZA DI ALCUNI DATI NECESSARI PER LA REGISTRAZIONE **/
        
        if (empty($datafrom_patient_id)) {
            throw new FHIR\InvalidResourceFieldException("observation patient id cannot be empty !");
        }
        
        if (empty($datafrom_observation_id)) {
            throw new FHIR\InvalidResourceFieldException("observation id cannot be empty !");
        }
        
        if (empty($datafrom_observation_data)) {
            throw new FHIR\InvalidResourceFieldException("observation data cannot be empty !");
        }
        
        if (empty($datafrom_observation_status)) {
            throw new FHIR\InvalidResourceFieldException("observation status cannot be empty !");
        }
        
        if (empty($datafrom_observation_type)) {
            throw new FHIR\InvalidResourceFieldException("observation type cannot be empty !");
        }
        
        if (empty($datafrom_observation_reason)) {
            throw new FHIR\InvalidResourceFieldException("observation reason cannot be empty !");
        }
        
        if (empty($datafrom_observation_loinc)) {
            throw new FHIR\InvalidResourceFieldException("observation loinc cannot be empty !");
        }
        
        /** VALIDAZIONE ANDATA A BUON FINE - CREO IL PAZIENTE E L'UTENTE ASSOCIATO **/

        $observation = new Indagini();

        $observation->id_diagnosi           = $datafrom_observation_id;
        $observation->id_paziente           = $datafrom_patient_id;
        $observation->id_cpp                = $datafrom_cpp_id;
        $observation->indagine_codice_loinc = $datafrom_observation_loinc;
        $observation->indagine_data         = $datafrom_observation_data;
        $observation->indagine_stato        = $observation->getStatusFromFHIR($datafrom_observation_status);
        $observation->indagine_tipologia    = $datafrom_observation_type;
        $observation->indagine_motivo       = $datafrom_observation_reason;

        $observation->save();
    }
    
    function show($id_observation)
    {
        $dati_indagine = Indagini::find($id_observation);
        
        if (!$dati_indagine->exists()) {
            throw new FHIR\IdNotFoundInDatabaseException("resource with the id provided doesn't exist in database");
        }
        
        //Sono i valori che verranno riportati nella parte descrittiva del documento
        //Indicare CHIAVE e VALORE di ogni riga (es: Nome => "Antonio Rossi")
        $values_in_narrative = array(
            "Date"     => $dati_indagine->indagine_data,
            "State"    => $dati_indagine->getStatus(),
            "Type"     => $dati_indagine->indagine_tipologia,
            "Reason"   => $dati_indagine->indagine_motivo,
        );
           
        $data_xml["narrative"]     = $values_in_narrative;
        $data_xml["observation"]   = $dati_indagine;
        
        return view("fhir.observation", ["data_output" => $data_xml]);
    }
}

?>