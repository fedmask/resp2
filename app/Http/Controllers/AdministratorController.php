<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Input;

class AdministratorController extends Controller {
	//
	
	/**
	 * Display a listing of the resource.
	 *
	 * - @return Response
	 */
	public function indexControlPanel() {
		$current_user_id = Auth::id ();
		$current_administrator = \App\Amministration::find ( $current_user_id )->first ();
		$data = array ();
		$data ['current_administrator'] = $current_administrator;
		$data ['LogsArray'] = $this->getAuditLogs ();
		return view ( 'pages.Administration.ControlPanel_Administrator', $data );
	}
	public function indexCareProviders() {
		$current_user_id = Auth::id ();
		$current_administrator = \App\Amministration::find ( $current_user_id )->first ();
		$data = array ();
		$data ['current_administrator'] = $current_administrator;
		$data ['CppArray'] = $this->getCareProviders ();
		return view ( 'pages.Administration.CareProviders_Administrator', $data );
	}
	public function create() {
	}
	public function getCareProviders() {
		$CPs = \App\Models\CareProviders\CareProvider::all ();
		$CppArray = array ();
		$i = 0;
		foreach ( $CPs as $CP ) {
			$temp = array (
					$CP->id_cpp,
					$CP->getFullName (),
					$CP->getMail (),
					date ( 'd-m-Y', strtotime ( str_replace ( '/', '-', $CP->cpp_nascita_data ) ) ),
					$CP->cpp_codfiscale,
					$CP->cpp_sesso,
					$CP->specializzation,
					$CP->getQualifications (), // Restituisce un array bidimensionale
					$CP->cpp_n_iscrizione,
					$CP->cpp_localita_iscrizione,
					$CP->getLanguage (),
					$CP->isActive () 
			);
			$CppArray [$i ++] = $temp;
		}
		
		return $CppArray;
	}
	public function updateCppStatus(Request $request) {
		$CPs = \App\Models\CareProviders\CareProvider::all ();
		foreach ( $CPs as $CP ) {
			if ((Input::get ( 'check' . $CP->id_cpp )) === 'Attivo') {
				
				$CP->active = true;
				$CP->save ();
			} else {
				$CP->active = false;
				$CP->save ();
			}
		}
		
		return redirect ( '/administration/CareProviders' )->with ( 'ok_message', 'Tutto aggiornato correttamente' );
	}
	public function searchCP($nome) {
		try {
			$CPs = \App\Models\CareProviders\CareProvider::where ( 'cpp_nome', $nome )->get ();
			
			$temp = array ();
			
			foreach ( $CPs as $CP ) {
				
				$temp ['Cp_nome'] = $CP->cpp_nome;
				$temp ['Qualifications'] = $CP->getQualifications (); // Restituisce un array bidimensionale
			}
			
			return $temp;
		} catch ( Exception $e ) {
			
			return null;
		}
	}
	
	
	public function getPatients(Request $request){
		
		$this->buildLog('Patient summary', $request->ip(), $id_visiting = Auth::user()->id_utente);
		$Patients = \App\Models\Patient\Pazienti::all();
		$current_user_id = Auth::id ();
		$current_administrator = \App\Amministration::find ( $current_user_id )->first ();
		return view ( 'pages.Administration.Patients_Administrator', ['Patients'=>$Patients, 'current_administrator'=>$current_administrator]);
	}
	
	
	
	/*
	 * Costruisce un nuovo record log per la pagina che si sta per visualizzare
	 */
	public function buildLog($actionName, $ip, $id_visiting){
		$log = \App\Models\Log\AuditlogLog::create([ 'audit_nome' => $actionName,
				'audit_ip' => $ip,
				'id_visitato' => $id_visiting,
				'id_visitante' => Auth::user()->id_utente,
				'audit_data' => date('Y-m-d H:i:s'),
		]);
		$log->save();
		return $log;
	}
	/**
	 * Method unused
	 *
	 * @param unknown $CP        	
	 * @return string
	 */
	private function getSpecializationsCPString($CP) {
		$specializzations = $CP->getQualifications ();
		
		if ($specializzations::count () == 0) {
			return "Informazione non disponibile";
		}
		$SpecializationString = "";
		foreach ( $specializations as $specialization ) {
			$SpecializationString = $SpecializationString . $specialization->tipologia_nome;
		}
		return $SpecializationString;
	}
	public function getAuditLogs() {
		$Logs = \App\Models\Log\AuditlogLog::all ();
		
		$LogsArray = array ();
		$i = 0;
		foreach ( $Logs as $Log ) {
			
			$temp = array (
					$Log->id_audit,
					$Log->audit_nome,
					$Log->audit_ip,
					$Log->id_visitante,
					\App\Models\CurrentUser\User::where ( 'id_utente', $Log->id_visitante )->first ()->utente_nome,
					$Log->audit_data 
			);
			$LogsArray [$i ++] = $temp;
		}
		
		return $LogsArray;
	}
	public function store(Request $request) {
	}
	public function show($id) {
		//
	}
	public function edit($id) {
		
		//
	}
	
	/**
	 * - Update the specified resource in storage.
	 *
	 * - @param Request $request
	 * - @param int $id
	 * - @return Response
	 */
	public function update(Request $request, $id) {
		//
	}
	
	/**
	 * - Remove the specified resource from storage.
	 *
	 * - @param int $id
	 * - @return Response
	 */
	public function destroy($id) {
		//
	}
}
