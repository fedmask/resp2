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
    
    
    
    public function store(Request $request) {
        $doc = new \SimpleXMLElement ( $request->getContent () );
        
        $procedure = Procedure::find ( $doc->id ["value"] );
        $proc_desc = $doc->extension [1]->valueString ["value"];
        $proc_status = $doc->status [1]->value ["value"];
        $proc_not = $doc->notDone [1]->value ["value"];
        $proc_cat = $doc->extension [2]->valueString ["value"];
        $proc_icd = $doc->code [1]->coding [1]-> code ["value"];
        $proc_icd_des = $doc->code [1]->coding [1]-> display ["value"];
        $proc_sub =  $doc->subject [1]-> reference ["value"];
        $proc_data =  $doc->performedDateTime ["value"];
        $proc_dia = $doc->extension [2]->valueString ["value"];
        $proc_cpp_spec = $doc->performer [1]->role [1]->coding [1]->system ["value"];
        $proc_cpp_id = $doc->performer [1]->actor [1]->reference["value"];
        $proc_cpp = $doc->performer [1]->actor [1]->display["value"];
        $proc_paz_id = $doc->performer [1]->actor [2]->reference["value"];
        $proc_paz = $doc->performer [1]->actor [2]->display["value"];
        $proc_out = $doc->extension [3]->valueString ["value"];
        $proc_note = $doc->note [1]->text ["value"];
        
        
        
        if ($visita_id) {
            throw new FHIR\IdNotFoundInDatabaseException ( "resource with the id provided exists in database !" );
        }
        
        if (empty($visita_stato_visita)) {
            throw new FHIR\InvalidResourceFieldException( "Stato visita cannot be empty !" );
        }
        
        if (empty($visita_motivazione)) {
            throw new FHIR\InvalidResourceFieldException( "Motivazione cannot be empty !" );
        }
        
        if (empty($visita_cod_priorità)) {
            throw new FHIR\InvalidResourceFieldException( "Codice priorità cannot be empty !" );
        }
        
        if (empty($visita_data)) {
            throw new FHIR\InvalidResourceFieldException( "Visita data visita cannot be empty !" );
        }
        
        if (empty($paziente_id)) {
            throw new FHIR\InvalidResourceFieldException( "paziente id cannot be empty !" );
        }
        
        if (empty($visita_t_richiesta)) {
            throw new FHIR\InvalidResourceFieldException( "Tipo Richiesta cannot be empty !" );
        }
        
        if (empty($visita_status)) {
            throw new FHIR\InvalidResourceFieldException( "Status cannot be empty !" );
        }
        
        if (empty($cpp_id)) {
            throw new FHIR\InvalidResourceFieldException( "Cpp id cannot be empty !" );
        }
        
        /*VALIDAZIONE ANDATA A BUON FINE */
        
        $data_visita = new PazientiVisite ();
        
        $data_visita->setID ( $visita_id );
        $data_visita->setIdCpp ( $cpp_id );
        $data_visita->setIdPazienti ( $paziente_id );
        $data_visita->setVisitaData ( $visita_data );
        $data_visita->setVisitaMotivazione ( $visita_motivazione );
        $data_visita->setConclusioni ( $visita_conclusioni );
        $data_visita->setVisitaOsservazioni ( $visita_osservazioni );
        $data_visita->setStato ( $visita_stato_visita );
        $data_visita->setCodiceP ( $visita_cod_priorità );
        $data_visita->setTRichiesta ( $visita_t_richiesta );
        $data_visita->setStatus ( $visita_status );
        
        if ($visita_Inizio || $visita_Fine) {
            $data_visita->setRichiestaVI ( $visita_Inizio );
            $data_visita->setRichiestaVF ( $visita_Fine );
        }
        
        $data_visita->save ();
        
        return response ( '', 201 );
    }
    
    
}
