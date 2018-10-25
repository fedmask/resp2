<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

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
					$CP->cpp_n_iscrizione,
					$CP->cpp_localita_iscrizione,
					$CP->getLanguage (),
					$CP->active 
			);
			$CppArray [$i ++] = $temp;
		}
		
		return $CppArray;
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
