<?php

namespace App\Http\Controllers;

use Illuminate\ Http\ Request;
use App\ Http\ Controllers\ Controller;
use Illuminate\Support\Facades\Validator;
use Hash;
use Input;
use Redirect;
use Auth;
use App\Models\Patient\Pazienti;
use App\Models\Patient\PazientiContatti;

class EmergencyController extends Controller
{

    /**
	* Mostra la pagina contenente la casella di ricerca Pazienti
	* all'utente Emergency attualmente loggato. Se ci sono parametri nell'url filtra i pazienti
	*/
	public function showPatientSearch(Request $request){
        //acquisizione dati GET dal form di ricerca paziente
	    $nome_paziente = $request->input('nome_paziente');
        $cognome_paziente = $request->input('cognome_paziente');
        $gender = $request->input('Gender');

        //querybuilder per il filtraggio dei pazienti
        $query = Pazienti::orderBY("paziente_cognome");

        if($nome_paziente != NULL){
            $query->like('paziente_nome', $nome_paziente);
        }

        if($cognome_paziente != NULL){
            $query->like('paziente_cognome', $cognome_paziente);
        }

        if($gender != NULL){
            $query->where('paziente_Sesso', "=", $gender);
        }

        $patients = $query->get();
        return view('pages.emergency.patientSearch')
            ->with('patients', $patients)
            ->with('nome_paziente', $nome_paziente)
            ->with('cognome_paziente', $cognome_paziente)
            ->with('gender', $gender);
	}

    /**
     * Mostra la pagina report del paziente
     * all'utente Emergency attualmente loggato.
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showPatientReport(Request $request){
        //recuper id_patient dall'url
        $id_patient = $request->input('id-patient');

        //querybuilder per la selezione del paziente
        $patient_info = Pazienti::where('id_paziente', $id_patient)->get();
        $contacts = PazientiContatti::where('id_paziente', $id_patient)->get();
        return view('pages.emergency.patientReport')
            ->with('contacts', $contacts)
            ->with('patient_info', $patient_info);
    }
}
