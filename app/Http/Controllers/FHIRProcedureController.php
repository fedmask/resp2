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
        
        $value_in_narrative = array (
            "ID_Procedure" => $procedure->id_Procedure_Terapeutiche,
            "Descrizione" => $procedure->descrizione,
            "Data Esecuzione" => $procedure->Data_Esecuzione,
            "Paziente" => $procedure->paziente->getID(),
            "Diagnosi" => $peocedure->diagnosi_getId()
        );
        
        $data_xml["narrative"] = $value_in_narrative;
        $data_xml["procedure"] = $procedure;
        
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
