<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Exceptions\FHIR as FHIR;
use App\Models\Patiente\Pazienti;
use App\Models\Diagnosis\Diagnosi;
use App\Models\CareProviders\CareProvider;
use App\Models\ProcedureTerapeutiche;
use App\Models\ICD9_ICPT;
use App\Models\ProcedureStatus;
use App\Models\ProcedureCategory;
use App\Models\ProcedureOutCome;

use Illuminate\Http\Request;

class FHIRProcedureController extends Controller {
	/* Implementazione del Servizio REST: GET */
	public function show($id_Procedure_Terapeutiche) {
		$procedure = ProcedureTerapeutiche::find ( $id_Procedure_Terapeutiche );
		
		// Lancio dell'eccezione per verificare che la visita sia prensente nel sistema
		if (! $procedure->exists ()) {
			throw new FHIR\IdNotFoundInDatabaseException ( "resource with the id provided doesn't exist in database" );
		}
		
		// Acquisizione pazienti
		$paz = Pazienti::where ( 'id_paziente', $procedure->getPatientID () )->get ();
		// Acquisizione Caraprovider
		$cpp = CareProvider::where ( 'id_cpp', $procedure->getCppID () )->get ();
		// Acquisizione Diagnosi
		$dia = Diagnosi::where ( 'id_diagnosi', $procedure->getDiagnosisID () )->get ();
		// Acquisizione codici Icd9
		$icd = ICD9_ICPT::where ( 'Codice_ICD9', $procedure->getIcd9ID () )->get ();
		// Acquisizione status per risorsa fhir
		$status = ProcedureStatus::where ( 'codice', $procedure->getStatus () )->get ();
		// Acquisizione categoria per risorsa fhir
		$cat = ProcedureCategory::where ( 'codice', $procedure->getCategory () )->get ();
		// Acquisizione outcome per risorsa fhir
		$out = ProcedureOutCome::where ( 'codice', $procedure->getOutcome () )->get ();
		
		$value_in_narrative = array (
				"ID_Procedure" => $procedure->id_Procedure_Terapeutiche,
				"Descrizione" => $procedure->descrizione,
				"Data Esecuzione" => $procedure->Data_Esecuzione,
				"notDone" => $procedure->notDone,
				"Note" => $procedure->note 
		);
		
		$data_xml ["narrative"] = $value_in_narrative;
		$data_xml ["procedure"] = $procedure;
		$data_xml ["pazienti"] = $paz;
		$data_xml ["careprovider"] = $cpp;
		$data_xml ["diagnosi"] = $dia;
		$data_xml ["icd9"] = $icd;
		$data_xml ["status"] = $status;
		$data_xml ["categoria"] = $cat;
		$data_xml ["OutCome"] = $out;
		
		return view ( "fhir.procedure", [
		    "data_output" => $data_xml
		] );
	}
	
	/* Implementazione del Servizio REST: DELETE */
	public function destroy($id_visite) {
		$procedure = ProcedureTerapeutiche::find ( $id_Procedure_Terapeutiche );
		
		// Lancio dell'eccezione per verificare che la visita sia prensente nel sistema
		if (! $procedure->exists ()) {
			throw new FHIR\IdNotFoundInDatabaseException ( "resource with the id provided doesn't exist in database" );
		}
		
		$procedure->delete ();
	}
	public function store(Request $request) {
		$doc = new \SimpleXMLElement ( $request->getContent () );
		
		$procedure = ProcedureTerapeutiche::find ( $doc->id ["value"] );
		$procedure_id = $doc->id ["value"];
		$proc_desc = $doc->extension [0]->valueString ["value"];
		$proc_status = $doc->status->value ["value"];
		$proc_not = $doc->notDone ->value ["value"];
		$proc_cat = $doc->extension [1]->valueString ["value"];
		$proc_icd9 = $doc->code->coding->code ["value"];
		$proc_icd_des = $doc->code->coding->display ["value"];
		$proc_sub = substr ($doc->subject->reference ["value"], 8 );
		$proc_data = $doc->performedDateTime ["value"];
		$proc_dia = $doc->extension [2]->valueString ["value"];
		$proc_cpp_spec = $doc->performer->role->coding->system ["value"];
		$proc_cpp_id = $doc->performer->actor [0]->reference ["value"];
		$proc_cpp = $doc->performer->actor [0]->display ["value"];
		$proc_paz_id = $doc->performer->actor [1]->reference ["value"];
		$proc_paz = $doc->performer ->actor [1]->display ["value"];
		$proc_out = $doc->extension [3]->valueString ["value"];
		$proc_note = $doc->note->text ["value"];
		
		if ($visita_id) {
			throw new FHIR\IdNotFoundInDatabaseException ( "resource with the id provided exists in database !" );
		}
		
		if (empty ( $proc_status )) {
			throw new FHIR\InvalidResourceFieldException ( "Status cannot be empty !" );
		}
		
		if (empty ( $proc_icd9 )) {
			throw new FHIR\InvalidResourceFieldException ( "ICD9 code cannot be empty !" );
		}
		
		if (empty ( $proc_icd_des )) {
			throw new FHIR\InvalidResourceFieldException ( "IDC9 descrizione cannot be empty !" );
		}
		
		if (empty ( $proc_sub )) {
			throw new FHIR\InvalidResourceFieldException ( "Paziente id cannot be empty !" );
		}
		
		if (empty ( $proc_data )) {
			throw new FHIR\InvalidResourceFieldException ( "Data cannot be empty !" );
		}
		
		if (empty ( $proc_cpp_spec )) {
			throw new FHIR\InvalidResourceFieldException ( "Specializzazione Pratictioner cannot be empty !" );
		}
		
		if (empty ( $proc_cpp_id )) {
			throw new FHIR\InvalidResourceFieldException ( "Cpp id cannot be empty !" );
		}
		if (empty ( $proc_cpp )) {
			throw new FHIR\InvalidResourceFieldException ( "Cpp FullName cannot be empty !" );
		}
		
		if (empty ( $proc_paz_id )) {
			throw new FHIR\InvalidResourceFieldException ( "Paziente id cannot be empty !" );
		}
		if (empty ( $proc_paz )) {
			throw new FHIR\InvalidResourceFieldException ( "Paziente FullName cannot be empty !" );
		}
		
		/* VALIDAZIONE ANDATA A BUON FINE */
		
		$data_procedure = new ProcedureTerapeutiche ();
		
		$data_procedure->setData ( $proc_data );
		if (! empty ( $proc_desc )) {
			$data_procedure->setDesc ( $proc_desc );
		}
		
		$data_procedure->setPaziente ( $proc_paz_id );
		$data_procedure->setCpp ( $proc_cpp_id );
		
		if (! empty ( $proc_dia )) {
			$data_procedure->setDiagnosi ( $proc_dia );
		}
		$data_procedure->setICD9($proc_icd9);
		if (! empty ($proc_note)) {
			$data_procedure->setNote($proc_note);
		}
		if (! empty ($proc_not)) {
			$data_procedure->setNotDone($proc_not);
		}
		
		$data_procedure->save();
		return response ( '', 201 );
		
	}
	
	public function update(Request $request, $id) {
		
		$doc = new \SimpleXMLElement ( $request->getContent () );
		
		$procedure = ProcedureTerapeutiche::find ( $doc->id ["value"] );
		$procedure_id = $doc->id ["value"];
		$proc_desc = $doc->extension [0]->valueString ["value"];
		$proc_status = $doc->status->value ["value"];
		$proc_not = $doc->notDone ->value ["value"];
		$proc_cat = $doc->extension [1]->valueString ["value"];
		$proc_icd9 = $doc->code->coding->code ["value"];
		$proc_icd_des = $doc->code->coding->display ["value"];
		$proc_sub = substr ($doc->subject->reference ["value"], 8 );
		$proc_data = $doc->performedDateTime ["value"];
		$proc_dia = $doc->extension [2]->valueString ["value"];
		$proc_cpp_spec = $doc->performer->role->coding->system ["value"];
		$proc_cpp_id = $doc->performer->actor [0]->reference ["value"];
		$proc_cpp = $doc->performer->actor [0]->display ["value"];
		$proc_paz_id = $doc->performer->actor [1]->reference ["value"];
		$proc_paz = $doc->performer ->actor [1]->display ["value"];
		$proc_out = $doc->extension [3]->valueString ["value"];
		$proc_note = $doc->note->text ["value"];
		
		if ($visita_id) {
			throw new FHIR\IdNotFoundInDatabaseException ( "resource with the id provided exists in database !" );
		}
		
		if (empty ( $proc_status )) {
			throw new FHIR\InvalidResourceFieldException ( "Status cannot be empty !" );
		}
		
		if (empty ( $proc_icd9 )) {
			throw new FHIR\InvalidResourceFieldException ( "ICD9 code cannot be empty !" );
		}
		
		if (empty ( $proc_icd_des )) {
			throw new FHIR\InvalidResourceFieldException ( "IDC9 descrizione cannot be empty !" );
		}
		
		if (empty ( $proc_sub )) {
			throw new FHIR\InvalidResourceFieldException ( "Paziente id cannot be empty !" );
		}
		
		if (empty ( $proc_data )) {
			throw new FHIR\InvalidResourceFieldException ( "Data cannot be empty !" );
		}
		
		if (empty ( $proc_cpp_spec )) {
			throw new FHIR\InvalidResourceFieldException ( "Specializzazione Pratictioner cannot be empty !" );
		}
		
		if (empty ( $proc_cpp_id )) {
			throw new FHIR\InvalidResourceFieldException ( "Cpp id cannot be empty !" );
		}
		if (empty ( $proc_cpp )) {
			throw new FHIR\InvalidResourceFieldException ( "Cpp FullName cannot be empty !" );
		}
		
		if (empty ( $proc_paz_id )) {
			throw new FHIR\InvalidResourceFieldException ( "Paziente id cannot be empty !" );
		}
		if (empty ( $proc_paz )) {
			throw new FHIR\InvalidResourceFieldException ( "Paziente FullName cannot be empty !" );
		}
		
		/* VALIDAZIONE ANDATA A BUON FINE */
		
		$data_procedure = new ProcedureTerapeutiche ();
		
		$data_procedure->setData ( $proc_data );
		if (! empty ( $proc_desc )) {
			$data_procedure->setDesc ( $proc_desc );
		}
		
		$data_procedure->setPaziente ( $proc_paz_id );
		$data_procedure->setCpp ( $proc_cpp_id );
		
		if (! empty ( $proc_dia )) {
			$data_procedure->setDiagnosi ( $proc_dia );
		}
		$data_procedure->setICD9($proc_icd9);
		if (! empty ($proc_note)) {
			$data_procedure->setNote($proc_note);
		}
		if (! empty ($proc_not)) {
			$data_procedure->setNotDone($proc_not);
		}
		
		$data_procedure->save();
		
	}
	
}
