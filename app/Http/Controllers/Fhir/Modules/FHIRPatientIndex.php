<?php
namespace App\Http\Controllers\Fhir\Modules;

use App\Http\Controllers\Fhir\Modules\FHIRResource;
use App\Models\Patient\Pazienti;
use App\Models\Patient\PazientiVisite;
use App\Models\Patient\ParametriVitali;
use App\Models\Patient\PazientiContatti;
use App\Models\CareProviders\CppPaziente;
use App\Exceptions\FHIR as FHIR;
use App\Models\CurrentUser\Recapiti;
use App\Models\CurrentUser\User;
use App\Models\Domicile\Comuni;
use Illuminate\Http\Request;
use App\Models\FHIR\PatientContact;
use App\Models\CodificheFHIR\ContactRelationship;
use App\Models\FHIR\PazienteCommunication;
use View;
use Illuminate\Filesystem\Filesystem;
use File;
use Orchestra\Parser\Xml\Facade as XmlParser;
use Exception;
use DB;
use Redirect;
use Response;
use SimpleXMLElement;
use App\Models\InvestigationCenter\Indagini;
use DOMDocument;

/*
 * N.B.
 * la risorsa Patient utilizza diverse estensioni tra cui blood-type.
 * Ci sono estensioni che servono per acquisire informazioni sull'utente presente
 * nel sistema che e' legato al paziente, queste estensioni sono user-id e user-fields.
 *
 * user-id: sara' utilizzata per aggiornare la risorsa quindi con user-id si
 * specifica semplicamente l'id dell'utente a cui corrisponde il paziente;
 * user-fields: e' invece una estensione che contiene tutti i campi della
 * tabella utenti presente nel database. Questa estensione sara' utilizzata in fase
 * di creazione e visualizzazione della risorsa in maniera tale da creare un
 * nuovo utente ogni qualvolta si crea un nuovo paziente nel sistema.
 */
class FHIRPatientIndex
{
    
    function Index($id){
        $patient = Pazienti::where('id_paziente', $id)->first();
        
        
        return view("pages.fhir.indexPatient", [
            "data_output" => $patient
        ]);
    }
    
}
?>
