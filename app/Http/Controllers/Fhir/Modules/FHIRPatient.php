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
class FHIRPatient
{

    public function show($id)
    {
        // Recupero i dati del paziente
        $patient = Pazienti::where('id_paziente', $id)->first();
        
        if (! $patient) {
            throw new FHIR\IdNotFoundInDatabaseException("resource with the id provided doesn't exist in database");
        }
        
        // Recupero i contatti del paziente
        $patient_contacts = PatientContact::where('id_patient', $id)->get();
        
        // Recupero gli operatori sanitari del paziente
        // $careproviders = CppPaziente::where('id_paziente', $id)->get();
        
        // Sono i valori che verranno riportati nella parte descrittiva del documento
        $values_in_narrative = array(
            "Identifier" => "RESP-PATIENT" . "-" . $patient->getID_Paziente(),
            "Active" => $patient->isActive(),
            "Name" => $patient->getFullName(),
            "Telecom" => $patient->getTelecom(),
            "Gender" => $patient->getGender(),
            "BirthDate" => $patient->getBirth(),
            "Deceased" => $patient->getDeceased(),
            "Address" => $patient->getAddress(),
            "MaritalStatus" => $patient->getMaritalStatusDisplay(),
            "Language" => $patient->getLanguage()
        );
        
        // Patient.Contact
        $narrative_patient_contact = array();
        $count = 0;
        foreach ($patient->getContact() as $pc) {
            $count ++;
            $narrative_patient_contact["ContactName" . " " . $count] = $pc->getName() . " " . $pc->getSurname();
            $narrative_patient_contact["ContactRelationship" . " " . $count] = $pc->getRelationshipDisplay();
            $narrative_patient_contact["ContactTelecom" . " " . $count] = $pc->getTelephone() . " - " . $pc->getMail();
        }
        
        // prelevo i dati dell'utente da mostrare come estensione
        $custom_extensions = array(
            'codicefiscale' => $patient->paziente_codfiscale,
            'grupposanguigno' => $patient->paziente_gruppo . " " . $patient->paziente_rh,
            'donatoreorgani' => $patient->isDonatoreOrgani()
        );
        
        $data_xml["narrative"] = $values_in_narrative;
        $data_xml["narrative_patient_contact"] = $narrative_patient_contact;
        $data_xml["extensions"] = $custom_extensions;
        $data_xml["patient"] = $patient;
        // $data_xml["careproviders"] = $careproviders;
        $data_xml["patient_contacts"] = $patient_contacts;
        
        return view("pages.fhir.patient", [
            "data_output" => $data_xml
        ]);
    }

    public function store(Request $request)
    {
        $file = $request->file('file');
        
        $xml = XmlParser::load($file->getRealPath());
        
        $id = $xml->parse([
            'identifier' => [
                'uses' => 'identifier.value::value'
            ]
        ]);
        
        $pazienti = Pazienti::all();
        
        foreach ($pazienti as $p) {
            if ($p->id_paziente == $id['identifier']) {
                throw new Exception("Patient is already exists");
            }
        }
        
        $lettura = $xml->parse([
            'identifier' => [
                'uses' => 'identifier.value::value'
            ],
            'active' => [
                'uses' => 'active::value'
            ],
            'name' => [
                'uses' => 'name.given::value'
            ],
            'surname' => [
                'uses' => 'name.family::value'
            ],
            'telecom' => [
                'uses' => 'telecom[value::value>attr]'
            ],
            'gender' => [
                'uses' => 'gender::value'
            ],
            'birthDate' => [
                'uses' => 'birthDate::value'
            ],
            'deceasedBoolean' => [
                'uses' => 'deceasedBoolean::value'
            ],
            'line' => [
                'uses' => 'address.line::value'
            ],
            'city' => [
                'uses' => 'address.city::value'
            ],
            'state' => [
                'uses' => 'address.state::value'
            ],
            'postalCode' => [
                'uses' => 'address.postalCode::value'
            ],
            'maritalStatus' => [
                'uses' => 'maritalStatus.coding.code::value'
            ],
            'communication' => [
                'uses' => 'communication.language.coding.code::value'
            ],
            'extension' => [
                'uses' => 'extension.valueBoolean::value'
            ],
            'ContRelCode' => [
                'uses' => 'contact.relationship.coding.code::value'
            ],
            'ContSurname' => [
                'uses' => 'contact.name.family::value'
            ],
            'ContName' => [
                'uses' => 'contact.name.given::value'
            ],
            'ContTelecom' => [
                'uses' => 'contact.telecom[value::value>attr]'
            ]
            
        ]);
        
        //USER
        
        $telecom = array();
        
        foreach ($lettura['telecom'] as $p) {
            array_push($telecom, $p['attr']);
        }
        
        $user = array();
        
        if (! is_null($telecom[1])) {
            $user['utente_email'] = $telecom[1];
        }
        
        $user['utente_nome'] = $lettura['name'] . " " . $lettura['surname'];
        
        $user['id_tipologia'] = 'mos';
        $user['utente_password'] = bcrypt('test1234');
        $user['utente_stato'] = '1';
        $user['utente_scadenza'] = '2030-01-01';
        $user['utente_dati_condivisione'] = '1';
        
        $addUtente = new User;
        
        foreach ($user as $key => $value) {
            if (empty($value)) {
                continue;
            }
            $addUtente->$key = $value;

        }
        
        $addUtente->save();
        
        
        // CONTATTI
        
        $comune = Comuni::all()->where('comune_nominativo', $lettura['city'])->first();
        
        $utente = User::all()->last();
        
        
        $addContact = new Recapiti;
      
        $contact = array(
            'id_utente' => $utente->id_utente,
            'id_comune_residenza' => $comune->id_comune,
            'id_comune_nascita' => $comune->id_comune,
            'contatto_indirizzo' => $lettura['line']
        );
        
        if (! is_null($telecom[0])) {
            $contact['contatto_telefono'] = $telecom[0];
        }
        
        foreach ($contact as $key => $value) {
            if (empty($value)) {
                continue;
            }
            
            $addContact->$key = $value;
         }
        
        $addContact->save();

        
        // PATIENT
        
        $patient = array(
            'id_paziente' => $lettura['identifier'],
            'id_utente' => $utente->id_utente,
            'paziente_nome' => $lettura['name'],
            'paziente_cognome' => $lettura['surname'],
            'paziente_sesso' => $lettura['gender'],
            'paziente_nascita' => $lettura['birthDate'],
            'paziente_codfiscale' => '',
            'paziente_gruppo' => '',
            'paziente_rh' => '',
            'paziente_donatore_organi' => $lettura['extension'],
            'id_stato_matrimoniale' => $lettura['maritalStatus'],
            'paziente_lingua' => $lettura['communication']
        );
        
        $addPatient = new Pazienti;
        
        foreach ($patient as $key => $value) {
            if (empty($value)) {
                continue;
            }
            $addPatient->$key = $value;
        }
        
        $addPatient->save();
     
        // PATIENT.CONTACT
        
        $patientContact = array(
            'Id_Patient' => $lettura['identifier'],
            'Relationship' => $lettura['ContRelCode'],
            'Name' => $lettura['ContName'],
            'Surname' => $lettura['ContSurname']
        );
        
        $contTelecom = array();
        
        foreach ($lettura['ContTelecom'] as $c) {
            array_push($contTelecom, $c);
        }
        
        if (! is_null($contTelecom[0])) {
            $patientContact['Telephone'] = $telecom[0];
        }
        
        if (! is_null($contTelecom[1])) {
            $patientContact['Mail'] = $telecom[1];
        }
        
        $addPatientContact = new PatientContact;
        
        foreach ($patientContact as $key => $value) {
            if (empty($value)) {
                continue;
            }
            
            $addPatientContact->$key = $value;
        }
        
        $addPatientContact->save();
        
        
        return response()->json($lettura['identifier'], 201);
        
    }

    public function update(Request $request, $id)
    {
        $file = $request->file('fileUpdate');
        
        $xml = XmlParser::load($file->getRealPath());
        
        $id_paz = $xml->parse([
            'identifier' => [
                'uses' => 'identifier.value::value'
            ]
        ]);
        
        $pazienti = Pazienti::all();
        
        if ($id_paz['identifier'] != $id) {
            throw new Exception("Patient does not exist in the database");
        }
        
        $lettura = $xml->parse([
            'identifier' => [
                'uses' => 'identifier.value::value'
            ],
            'active' => [
                'uses' => 'active::value'
            ],
            'name' => [
                'uses' => 'name.given::value'
            ],
            'surname' => [
                'uses' => 'name.family::value'
            ],
            'telecom' => [
                'uses' => 'telecom[value::value>attr]'
            ],
            'gender' => [
                'uses' => 'gender::value'
            ],
            'birthDate' => [
                'uses' => 'birthDate::value'
            ],
            'deceasedBoolean' => [
                'uses' => 'deceasedBoolean::value'
            ],
            'line' => [
                'uses' => 'address.line::value'
            ],
            'city' => [
                'uses' => 'address.city::value'
            ],
            'state' => [
                'uses' => 'address.state::value'
            ],
            'postalCode' => [
                'uses' => 'address.postalCode::value'
            ],
            'maritalStatus' => [
                'uses' => 'maritalStatus.coding.code::value'
            ],
            'communication' => [
                'uses' => 'communication.language.coding.code::value'
            ],
            'extension' => [
                'uses' => 'extension.valueBoolean::value'
            ],
            'ContRelCode' => [
                'uses' => 'contact.relationship.coding.code::value'
            ],
            'ContSurname' => [
                'uses' => 'contact.name.family::value'
            ],
            'ContName' => [
                'uses' => 'contact.name.given::value'
            ],
            'ContTelecom' => [
                'uses' => 'contact.telecom[value::value>attr]'
            ]
        
        ]);
        
        // USER
        
        $patient_data = Pazienti::where('id_paziente', $id)->first();
        
        $updUser = User::find($patient_data->id_utente)->first();
        
        $telecom = array();
        
        foreach ($lettura['telecom'] as $p) {
            array_push($telecom, $p['attr']);
        }
        
        $user = array();
        
        if (! is_null($telecom[1])) {
            $user['utente_email'] = $telecom[1];
        }
        
        $user['utente_nome'] = $lettura['name'] . " " . $lettura['surname'];
        
        foreach ($user as $key => $value) {
            if (empty($value)) {
                continue;
            }
            
            $updUser->$key = $value;
        }
        
        $updUser->save();
        
        // CONTATTI
        
        $updContact = Recapiti::find($patient_data->id_utente)->first();
        
        $comune = Comuni::all()->where('comune_nominativo', $lettura['city'])->first();
        
        $contact = array(
            'id_comune_residenza' => $comune->id_comune,
            'id_comune_nascita' => $comune->id_comune,
            'contatto_indirizzo' => $lettura['line']
        );
        
        if (! is_null($telecom[0])) {
            $contact['contatto_telefono'] = $telecom[0];
        }
        
        foreach ($contact as $key => $value) {
            if (empty($value)) {
                continue;
            }
            $updContact->$key = $value;
        }
        
        $updContact->save();
        
        // PATIENT
        
        $updPatient = $patient_data;
        
        $patient = array(
            'paziente_nome' => $lettura['name'],
            'paziente_cognome' => $lettura['surname'],
            'paziente_sesso' => $lettura['gender'],
            'paziente_nascita' => $lettura['birthDate'],
            'paziente_donatore_organi' => $lettura['extension'],
            'id_stato_matrimoniale' => $lettura['maritalStatus'],
            'paziente_lingua' => $lettura['communication']
        );
        
        foreach ($patient as $key => $value) {
            if (empty($value)) {
                continue;
            }
            $updPatient->$key = $value;
        }
        
        $updPatient->save();
        
        // PATIENT.CONTACT
        
        $updPatientContact = PatientContact::where('Id_Patient', $patient_data->id_paziente)->first();
        
        $patientContact = array(
            'Relationship' => $lettura['ContRelCode'],
            'Name' => $lettura['ContName'],
            'Surname' => $lettura['ContSurname']
        );
        
        $contTelecom = array();
        
        foreach ($lettura['ContTelecom'] as $c) {
            array_push($contTelecom, $c);
        }
        
        if (! is_null($contTelecom[0])) {
            $patientContact['Telephone'] = $telecom[0];
        }
        
        if (! is_null($contTelecom[1])) {
            $patientContact['Mail'] = $telecom[1];
        }
        
        foreach ($patientContact as $key => $value) {
            if (empty($value)) {
                continue;
            }
            
            $updPatientContact->$key = $value;
        }
        
        $updPatientContact->save();
        
        return response()->json($id, 200);
    }

    function destroy($id)
    {
        $patient = Pazienti::find($id);
        
        if (! $patient->exists()) {
            throw new Exception("resource with the id provided doesn't exist in database");
        }
        
        Pazienti::find($id)->delete();
        
        $user = User::where('id_utente', $patient->id_utente)->first();
        
        User::find($user->id_utente)->delete();
        
        
        return response()->json(null, 204);
    }
}
?>
