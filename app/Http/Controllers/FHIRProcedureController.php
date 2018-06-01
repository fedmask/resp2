<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Exceptions\FHIR as FHIR;
use App\Models\Patiente\PazientiVisite;
use App\Models\Patiente\Pazienti;
use App\Models\CareProviders\CareProvider;
use App\Models\Diagnosis\Diagnosi;
use Illuminate\Http\Request;

class FHIRProcedureController extends Controller
{
    /* Implementazione del Servizio REST: GET */
    public function show($id_Procedure_Terapeutiche){
        
        $procedure = Procedure::find($id_Procedure_Terapeutiche);
        
        //Lancio dell'eccezione per verificare che la visita sia prensente nel sistema
        if (!$procedure->exists()) {
            throw new FHIR\IdNotFoundInDatabaseException("resource with the id provided doesn't exist in database");
        }
        
        // Acquisizione pazienti
        $paz = Pazienti::where('id_paziente', $procedure -> getPatientID())->get();
        // Acquisizione Caraprovider
        $cpp = CareProvider::where('id_cpp', $procedure -> getCppID())->get();
        // Acquisizione Diagnosi
        $dia = Diagnosi::where('id_diagnosi', $procedure ->getDiagnosisID())->get();
        // Acquisizione codici Icd9
        $icd = ICD9_ICPT::where('Codice_ICD9', $procedure ->getIcd9ID())->get();
        // Acquisizione status per risorsa fhir
        $status = ProcedureStatus::where('codice', $procedure ->getStatus())->get();
        // Acquisizione categoria per risorsa fhir
        $cat = ProcedureCategory::where('codice', $procedure ->getCategory())->get();
        // Acquisizione outcome per risorsa fhir
        $out = ProcedureOutCome::where('codice', $procedure ->getOutcome())->get();
        
        
        $value_in_narrative = array (
            "ID_Procedure" => $procedure->id_Procedure_Terapeutiche,
            "Descrizione" => $procedure->descrizione,
            "Data Esecuzione" => $procedure->Data_Esecuzione,
            "notDone" => $procedure->notDone,
            "Note" => $procedure->note
        );
        
        $data_xml["narrative"] = $value_in_narrative;
        $data_xml["procedure"] = $procedure;
        $data_xml["pazienti"] = $paz;
        $data_xml["careprovider"] = $cpp;
        $data_xml["diagnosi"] = $dia;
        $data_xml["icd9"] = $icd;
        $data_xml["status"] = $status;
        $data_xml["categoria"] = $cat;
        $data_xml["OutCome"] = $out;
        
        
    }
    
    
    /* Implementazione del Servizio REST: DELETE */
    public function destroy($id_visite){
        
        $procedure = Procedure::find($id_Procedure_Terapeutiche);
        
        //Lancio dell'eccezione per verificare che la visita sia prensente nel sistema
        if (!$procedure->exists()) {
            throw new FHIR\IdNotFoundInDatabaseException("resource with the id provided doesn't exist in database");
        }
        
        $procedure->delete();
    }
    
}
