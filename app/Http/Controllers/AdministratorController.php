<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Input;
use DB;
use Illuminate\Support\Facades\Validator;
use Redirect;

class AdministratorController extends Controller {
	//
	
	/**
	 * Display a listing of the resource.
	 *
	 * - @return Response
	 */
	public function indexControlPanel() {
		$current_user_id = Auth::user ()->id_utente;
		$current_administrator = \App\Amministration::where ( 'id_utente', $current_user_id )->first ();
		$data = array ();
		$data ['current_administrator'] = $current_administrator;
		$data ['LogsArray'] = $this->getAuditLogs ();
		return view ( 'pages.Administration.ControlPanel_Administrator', $data );
	}
	
	/**
	 * 
	 * @return unknown
	 */
	public function indexCareProviders() {
		$current_user_id = Auth::user ()->id_utente;
		$current_administrator = \App\Amministration::where ( 'id_utente', $current_user_id )->first ();
		$data = array ();
		$data ['current_administrator'] = $current_administrator;
		$data ['CppArray'] = $this->getCareProviders ();
		return view ( 'pages.Administration.CareProviders_Administrator', $data );
	}
	
	/**
	 * 
	 * @return unknown
	 */
	public function indexAmministration() {
		$current_user_id = Auth::user ()->id_utente;
		$current_administrator = \App\Amministration::where ( 'id_utente', $current_user_id )->first ();
		$data ['Activitys'] = \App\AdminActivity::all ();
		$data ['current_administrator'] = $current_administrator;
		$data ['Admin'] = \App\Amministration::all ();
		return view ( 'pages.Administration.Administration_Administrator', $data );
	}
	
	/**
	 * 
	 * @return unknown
	 */
	public function indexTrattamenti() {
		$current_user_id = Auth::user ()->id_utente;
		$current_administrator = \App\Amministration::where ( 'id_utente', $current_user_id )->first ();
		
		$data = array ();
		
		$data ['current_administrator'] = $current_administrator;
		$data ['TrattamentiP'] = \App\TrattamentiPaziente::all ();
		$data ['TrattamentiCP'] = \App\TrattamentiCareProvider::all ();
		
		return view ( 'pages.Administration.TrattamentiAdmin', $data );
	}
	
	
	/**
	 * Metodo per l'aggiornamento deii Trattamenti dei Pazienti
	 * @param Request $request
	 * @return unknown
	 */
	public function updateTrattamentiP(Request $request) {
		$Trattamenti = \App\TrattamentiPaziente::all ();
		foreach ( $Trattamenti as $Tr ) {
			
			\App\TrattamentiPaziente::where ( "Id_Trattamento", Input::get ( "TrattamentoID" . $Tr->getId () ) )->update ( [ 
					'Nome_T' => Input::get ( "Nome_T" . $Tr->getId () ),
					
					'Finalita_T' => Input::get ( "Finalita_T" . $Tr->getId () ) 
			
			] );
			
			try {
				\App\TrattamentiPaziente::where ( "Id_Trattamento", Input::get ( "TrattamentoID" . $Tr->getId () ) )->update ( [ 
						'Informativa' => Input::get ("Informativa_T" . $Tr->getId () ) 
				] );
			} catch ( \Exception $e ) {
			}
			
			$Tr->save ();
		}
		
		return redirect ( '/administration/Trattamenti' )->with ( 'ok_message', 'Tutto aggiornato correttamente' );
		
	}
	
	
	/**
	 * Metodo per l'aggiornamento dei Trattamenti dei Care Provider
	 * @param Request $request
	 * @return unknown
	 */
	public function updateTrattamentiCP(Request $request) {
		$Trattamenti = \App\TrattamentiCareProvider::all ();
		foreach ( $Trattamenti as $Tr ) {
			
			\App\TrattamentiCareProvider::where ( "Id_Trattamento", Input::get ( "TrattamentoIDCP" . $Tr->getId () ) )->update ( [
					'Nome_T' => Input::get ( "Nome_TCP" . $Tr->getId () ),
					
					'Finalita_T' => Input::get ( "Finalita_TCP" . $Tr->getId () )
					
			] );
			
			try {
				\App\TrattamentiCareProvider::where ( "Id_Trattamento", Input::get ( "TrattamentoIDCP" . $Tr->getId () ) )->update ( [
						'Informativa' => Input::get ("Informativa_TCP" . $Tr->getId () )
				] );
			} catch ( \Exception $e ) {
			}
			
			$Tr->save ();
		}
		
		return redirect ( '/administration/Trattamenti' )->with ( 'ok_message', 'Tutto aggiornato correttamente' );
		
	}
	
	
	/**
	 * Metodo per l'aggiunta di una nuova operazione di Log
	 * @param Request $request
	 * @return unknown
	 */
	public function addAuditLog(Request $request) {
		$log = \App\Models\Log\AuditlogLog::create ( [ 
				'audit_nome' => Input::get ( 'Descrizione' ),
				'audit_ip' => $request->ip (),
				'id_visitato' => Input::get ( 'Utente' ),
				'id_visitante' => Auth::user ()->id_utente,
				'audit_data' => date ( 'Y-m-d', strtotime ( str_replace ( '/', '-', Input::get ( 'date' ) ) ) ) 
		] );
		$log->save ();
		
		return $this->indexAmministration ();
	}
	
	
	/**
	 * Metodo che restituisce i Care Providers
	 * @return NULL[][]
	 */
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
	
	
	/**
	 * Metodo per la creazione di un'attività di admin
	 * @param Request $request
	 * @return unknown
	 */
	public function createActivityAdmin(Request $request) {
		/*
		 * $validator = Validator::make ( Input::all (), [
		 * 'Tipologia_attivita' => 'required',
		 *
		 * 'Start_Period' => 'required|date',
		 * 'End_Period' => 'required|date'
		 *
		 * ] );
		 *
		 * if ($validator->fails ()) {
		 * return Redirect::back ()->withErrors ( $validator )->withInput ();
		 * }
		 */
		$Activity = \App\AdminActivity::create ( [ 
				'id_utente' => Auth::user ()->id_utente,
				'Start_Period' => date ( 'Y-m-d', strtotime ( str_replace ( '/', '-', Input::get ( 'dateStart' ) ) ) ),
				'End_Period' => date ( 'Y-m-d', strtotime ( str_replace ( '/', '-', Input::get ( 'DateEndD' ) ) ) ),
				'Tipologia_attivita' => Input::get ( 'Attivita' ),
				'Descrizione' => Input::get ( 'Descrizione' ),
				'Anomalie_riscontrate' => Input::get ( 'AnomalieR' ) 
		] );
		
		$Activity->save ();
		
		return redirect ( '/administration/Administrators' )->with ( 'ok_message', 'Tutto aggiornato correttamente' );
	}
	
	
	/**
	 * Metodo per l'aggiornamento dello Status di un Cpp
	 * @param Request $request
	 * @return unknown
	 */
	public function updateCppStatus(Request $request) {
		$CPs = \App\Models\CareProviders\CareProvider::all ();
		foreach ( $CPs as $CP ) {
			
			$this->buildLog ( 'Modifica dello status', $request->ip (), $CP->getIdCpp () );
			
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
	
	
	/**
	 * Metodo per la ricerca di un Care Provider
	 * @param unknown $nome
	 * @return NULL[]|NULL
	 */
	public function searchCP($nome) {
		try {
			$CPs = \App\Models\CareProviders\CareProvider::where ( 'cpp_nome', $nome )->get ();
			
			$temp = array ();
			
			foreach ( $CPs as $CP ) {
				
				$this->buildLog ( 'Accesso lettura Care Provider', $request->ip (), $CP->getIdCpp () );
				
				$temp ['Cp_nome'] = $CP->cpp_nome;
				$temp ['Qualifications'] = $CP->getQualifications (); // Restituisce un array bidimensionale
			}
			
			return $temp;
		} catch ( Exception $e ) {
			
			return null;
		}
	}
	
	/**
	 * Metodo per l'aggironamenot dello Status di un Paziente 
	 * @param Request $request
	 * @return unknown|NULL
	 */
	public function updatePStatus(Request $request) {
		$this->buildLog ( 'Modifica dello status', $request->ip (), Input::get ( 'Id_Paziente' ) );
		
		$Patient = \App\Models\Patient\Pazienti::where ( 'id_paziente', Input::get ( 'Id_Paziente' ) )->first ();
		
		if ($Patient != null) {
			
			$Patient->user ()->utente_stato = true;
			return redirect ( '/administration/PatientsList' )->with ( 'ok_message', 'Tutto aggiornato correttamente' );
		}
		return null;
	}
	
	/**
	 * Aggiunge un amministratore 
	 * @param Request $request
	 * @return unknown
	 */
	public function addAdmin(Request $request) {
		$validator = Validator::make ( Input::all (), [ 
				'username' => 'required|string|max:40|unique:tbl_utenti,utente_nome',
				'name' => 'required|string|max:40',
				'surname' => 'required|string|max:40',
				'gender' => 'required',
				'email' => 'required|string|email|max:50|unique:tbl_utenti,utente_email',
				'confirmEmail' => 'required|same:email',
				'password' => 'required|min:8|max:16',
				'confirmPassword' => 'required|same:password',
				'birthCity' => 'required|string|max:40',
				'birthDate' => 'required|date|before:-18 years',
				'livingCity' => 'required|string|max:40',
				'address' => 'required|string|max:90',
				'telephone' => 'required|numeric',
				'Ruolo' => 'required|string|max:90',
				'TypeData' => 'required|string|max:200' 
		
		] );
		
		if ($validator->fails ()) {
			return Redirect::back ()->withErrors ( $validator )->withInput ();
		}
		
		$user = \App\Models\CurrentUser\User::create ( [ 
				'utente_nome' => Input::get ( 'username' ),
				'utente_email' => Input::get ( 'email' ),
				'utente_scadenza' => '2030-01-01', // TODO: Definire meglio
				'id_tipologia' => 'amm',
				'utente_email' => Input::get ( 'email' ),
				'utente_password' => bcrypt ( Input::get ( 'password' ) ) 
		] );
		
		$user_contacts = \App\Models\CurrentUser\Recapiti::create ( [ 
				'id_utente' => $user->id_utente,
				'id_comune_residenza' => $this->getTown ( Input::get ( 'livingCity' ) ),
				'id_comune_nascita' => $this->getTown ( Input::get ( 'birthCity' ) ),
				'contatto_telefono' => Input::get ( 'telephone' ),
				'contatto_indirizzo' => Input::get ( 'address' ) 
		] );
		
		$admin = \App\Amministration::create ( [ 
				'id_utente' => $user->id_utente,
				'Comune_Nascita' => $this->getTown ( Input::get ( 'birthCity' ) ),
				'Comune_Residenza' => $this->getTown ( Input::get ( 'livingCity' ) ),
				'Cognome' => Input::get ( 'surname' ),
				'Nome' => Input::get ( 'name' ),
				'Data_Nascita' => date ( 'Y-m-d', strtotime ( Input::get ( 'birthDate' ) ) ),
				'Tipi_Dati_Trattati' => Input::get ( 'TypeData' ),
				'Sesso' => Input::get ( 'gender' ),
				'Indirizzo' => Input::get ( 'address' ),
				'Recapito_Telefonico' => Input::get ( 'telephone' ),
				'Ruolo' => Input::get ( 'Ruolo' ) 
		] );
		
		$user->save ();
		$user_contacts->save ();
		$admin->save ();
		
		return redirect ( '/administration/Administrators' );
	}
	
	/**
	 * Restituisce i Pazienti 
	 * @param Request $request
	 * @return unknown
	 */
	public function getPatients(Request $request) {
		$this->buildLog ( 'Patient summary', $request->ip (), $id_visiting = Auth::user ()->id_utente );
		$Patients = \App\Models\Patient\Pazienti::all ();
		$current_user_id = Auth::user ()->id_utente;
		$current_administrator = \App\Amministration::where ( 'id_utente', $current_user_id )->first ();
		$Patients18 = $this->getPatientUnder18 ();
		return view ( 'pages.Administration.Patients_Administrator', [ 
				'Patients' => $Patients,
				'current_administrator' => $current_administrator,
				'patients18' => $Patients18 
		] );
	}
	
	
	/**
	 * Ottiene i file per un paziente minore
	 * @param unknown $file_id
	 * @param unknown $paziente_id
	 * @param Request $request
	 * @return unknown
	 */
	public static function getFile($file_id, $paziente_id, Request $request) {
		$this->buildLog ( 'Files', $request->ip (), $paziente_id );
		
		$is_owner = File::where ( 'id_file', $file_id )->where ( 'id_paziente', $paziente_id )->first ();
		
		$img_name = $is_owner->file_nome;
		$path_file = "app/public/patient/" . $paziente_id . "/" . $img_name;
		
		return storage_path ( $path_file );
	}
	
	/**
	 * Ottiene i Pazienti con età inferiore ad 18
	 * @return array
	 */
	public function getPatientUnder18() {
		$Patients = \App\Models\Patient\Pazienti::all ();
		$Patients18 = array ();
		$i = 0;
		foreach ( $Patients as $Patient ) {
			$years = Auth::user ()->getAge ( date ( 'd-m-Y', strtotime ( str_replace ( '/', '-', $Patient->paziente_nascita ) ) ) );
			
			if ($years <= 18) {
				
				$Pateients18 [$i ++] = $Patient;
			}
		}
		return $Patients18;
	}
	
	/*
	 * Costruisce un nuovo record log per la pagina che si sta per visualizzare
	 */
	public function buildLog($actionName, $ip, $id_visiting) {
		$log = \App\Models\Log\AuditlogLog::create ( [ 
				'audit_nome' => $actionName,
				'audit_ip' => $ip,
				'id_visitato' => $id_visiting,
				'id_visitante' => Auth::user ()->id_utente,
				'audit_data' => date ( 'Y-m-d H:i:s' ) 
		] );
		$log->save ();
		return $log;
	}
	/**
	 * Method unused
	 *
	 * @param unknown $CP        	
	 * @return string
	 */
	
	/**
	 * 
	 * Metodo privato per l'ottenimento delle Specializzazioni di un CP
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
	
	
	/**
	 * Restituisce i dati di Log
	 * @return NULL[][]
	 */
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
	
	/**
	 * Identifica l'id di una città presente nel database
	 * a partire dal nome
	 */
	private function getTown($name) {
		return \App\Models\Domicile\Comuni::where ( 'comune_nominativo', $name )->first ()->id_comune;
	}
	
	/**
	 * - Remove the specified resource from storage.
	 *
	 * -
	 * - @return Response
	 */
	public function destroy() {
		if (\App\Amministration::find ( Input::get ( 'Id_Admin2' ) )) {
			
			$user = \App\Models\CurrentUser\User::where ( 'id_utente', Input::get ( 'Id_Admin2' ) )->first ();
			$contacts = $user->contacts ();
			foreach ( $contacts as $contact ) {
				
				$contact->delete ();
			}
			
			$admin = \App\Amministration::where ( 'id_utente', Input::get ( 'Id_Admin2' ) )->first ();
			
			$admin->delete ();
			Mail::to($user->utente_email)->send(new sendMail($user->utente_nome, 'Avviso di cancellazione Account', 'Gent.mo utente, la informaimo che il suo account è stato cancellato in data: '.now().'. Se non ha effettuato lei la cancellazione la preghiamo di riolgersi ai nostri operatori di Supporto alla mail "privacy@fsem.com" .'));
		}
		return redirect ( '/administration/Administrators' );
	}
}
