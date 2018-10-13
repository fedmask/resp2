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

/**
 * Classe per la gestione delle operazioni di REST e per la creazione del file xml
 *
 * show => Visualizzazione di una risorsa
 * store => Memorizzazione di una nuova risorsa
 * update => Aggiornamento di una risorsa
 * delete => eliminazione di una risorsa
 */
class FHIRPatient
{

    /**
     * Funzione per la visualizzazione di una risorsa
     */
    public function show($id)
    {
        // Recupero i dati del paziente loggato
        $patient = Pazienti::where('id_paziente', $id)->first();
        
        // Controllo se il paziente esiste
        if (! $patient) {
            throw new FHIR\IdNotFoundInDatabaseException("resource with the id provided doesn't exist in database");
        }
        
        // Recupero i contatti del paziente
        $patient_contacts = PatientContact::where('id_patient', $id)->get();
        
        /*
         * Salvo in un array i dati del paziente che verranno riportati nella parte
         * descrittiva del blade della risorsa
         */
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
        
        /*
         * Salvo in un array i dati dei contatti del paziente che verranno riportati
         * nella parte descrittiva del blade della risorsa
         */
        $narrative_patient_contact = array();
        $count = 0;
        foreach ($patient->getContact() as $pc) {
            $count ++;
            $narrative_patient_contact["ContactName" . " " . $count] = $pc->getName() . " " . $pc->getSurname();
            $narrative_patient_contact["ContactRelationship" . " " . $count] = $pc->getRelationshipDisplay();
            $narrative_patient_contact["ContactTelecom" . " " . $count] = $pc->getTelephone() . " - " . $pc->getMail();
        }
        
        // Prelevo i dati dell'utente da mostrare come estensione
        $custom_extensions = array(
            'codicefiscale' => $patient->paziente_codfiscale,
            'grupposanguigno' => $patient->paziente_gruppo . " " . $patient->paziente_rh,
            'donatoreorgani' => $patient->isDonatoreOrgani()
        );
        
        $data_xml["narrative"] = $values_in_narrative;
        $data_xml["narrative_patient_contact"] = $narrative_patient_contact;
        $data_xml["extensions"] = $custom_extensions;
        $data_xml["patient"] = $patient;
        $data_xml["patient_contacts"] = $patient_contacts;
        
        return view("pages.fhir.patient", [
            "data_output" => $data_xml
        ]);
    }

    /**
     * Funzione per la memorizzazione di una nuova risorsa
     */
    public function store(Request $request)
    {
        // Recupero il file caricato
        $file = $request->file('file');
        
        // Parsing del file xml caricato
        $xml = XmlParser::load($file->getRealPath());
        
        //Recupero l'id della risorsa
        $id = $xml->parse([
            'identifier' => [
                'uses' => 'identifier.value::value'
            ]
        ]);
        
        $pazienti = Pazienti::all();
        
        // Controllo se l'id del paziente loggato coincide con l'id della risorsa
        foreach ($pazienti as $p) {
            if ($p->id_paziente == $id['identifier']) {
                throw new Exception("Patient is already exists");
            }
        }
        
        // Memorizzo in un array i dati necessari presenti nel file caricato
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
                'uses' => 'contact[relationship.coding.code::value>attr]'
            ],
            'ContSurname' => [
                'uses' => 'contact[name.family::value>attr]'
            ],
            'ContName' => [
                'uses' => 'contact[name.given::value>attr]'
            ]
        
        ]);
        
        // USER
        
        $telecom = array();

        //Salvo in un array i recapiti della risorsa
        foreach ($lettura['telecom'] as $p) {
            array_push($telecom, $p['attr']);
        }
        
        $user = array();
        
        //Recupero e salvo in un array la mail della risorsa
        if (! is_null($telecom[1])) {
            $user['utente_email'] = $telecom[1];
        }
        
        //Salvo in un array i dati necessari a creare un nuovo utente 
        $user['utente_nome'] = $lettura['name'] . " " . $lettura['surname'];
        $user['id_tipologia'] = 'mos';
        $user['utente_password'] = bcrypt('test1234');
        $user['utente_stato'] = '1';
        $user['utente_scadenza'] = '2030-01-01';
        $user['utente_dati_condivisione'] = '1';
        
        $addUtente = new User();
        
        //Salvo il nuovo utente
        foreach ($user as $key => $value) {
            if (empty($value)) {
                continue;
            }
            $addUtente->$key = $value;
        }
        
        $addUtente->save();
        
        // CONTATTI
        
        $comune = Comuni::all()->where('comune_nominativo', $lettura['city'])->first();
        
        //Recupero le informazini dell'ultimo utente salvato
        $utente = User::all()->last();
        
        $addContact = new Recapiti();
        
        //Memorizzo in un array i dati dei contatti dell'utente
        $contact = array(
            'id_utente' => $utente->id_utente,
            'id_comune_residenza' => $comune->id_comune,
            'id_comune_nascita' => $comune->id_comune,
            'contatto_indirizzo' => $lettura['line']
        );
        
        //Memorizzo il contato telefonico dell'utente
        if (! is_null($telecom[0])) {
            $contact['contatto_telefono'] = $telecom[0];
        }
        
        //Salvo i recapiti associati all'utente
        foreach ($contact as $key => $value) {
            if (empty($value)) {
                continue;
            }
            
            $addContact->$key = $value;
        }
        
        $addContact->save();
        
        // PATIENT
        
        //Memorizzo in un array i dati del Paziente
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
        
        $addPatient = new Pazienti();
        
        //Salvo il nuovo paziente
        foreach ($patient as $key => $value) {
            if (empty($value)) {
                continue;
            }
            $addPatient->$key = $value;
        }
        
        $addPatient->save();
        
        // PATIENT.CONTACT
        $xmlfile = file_get_contents($file);
        $ob = simplexml_load_string($xmlfile);
        $json = json_encode($ob);
        $configData = json_decode($json, true);
        
        $contactTelecom = array();
        
        if (array_key_exists('telecom', $configData['contact'])) {
            foreach ($configData['contact']['telecom'] as $c) {
                foreach ($c["value"] as $t) {
                    array_push($contactTelecom, $t['value']);
                }
            }
        } else {
            $contactTelecom = array();
            foreach ($configData["contact"] as $c) {
                foreach ($c["telecom"] as $t) {
                    array_push($contactTelecom, $t["value"]["@attributes"]["value"]);
                }
            }
        }
        
        $count = 0;
        $contactPhone = array();
        while ($count < count($contactTelecom)) {
            array_push($contactPhone, $contactTelecom[$count]);
            $count = $count + 2;
        }
        
        $contactMail = array();
        $count = 1;
        while ($count < count($contactTelecom)) {
            array_push($contactMail, $contactTelecom[$count]);
            $count = $count + 2;
        }
        
        $patientContact = array();
        for ($i = 0; $i < count($lettura['ContName']); $i ++) {
            $pc = array(
                'Id_Patient' => $lettura['identifier'],
                'Relationship' => $lettura['ContRelCode'][$i]['attr'],
                'Name' => $lettura['ContName'][$i]['attr'],
                'Surname' => $lettura['ContSurname'][$i]['attr'],
                'Telephone' => $contactPhone[$i],
                'Mail' => $contactMail[$i]
            );
            array_push($patientContact, $pc);
        }
        
        $addPatientContact = new PatientContact();
        $add = array();
        $patCont = array();
        
        foreach ($patientContact as $pc) {
            foreach ($pc as $key => $value) {
                $add[$key] = $value;
            }
            array_push($patCont, $add);
        }
        
        foreach ($patCont as $p) {
            $addPatientContact = new PatientContact();
            foreach ($p as $key => $value) {
                $addPatientContact->$key = $value;
            }
            $addPatientContact->save();
        }
        
        return response()->json($lettura['identifier'], 201);
    }

    /**
     * Funzione per l'aggiornamento di una risorsa
     */
    public function update(Request $request, $id)
    {
        // Recupero il file caricato
        $file = $request->file('fileUpdate');
        
        // Parsing del file xml
        $xml = XmlParser::load($file->getRealPath());
        
        //Recupero l'id della risorsa
        $id_paz = $xml->parse([
            'identifier' => [
                'uses' => 'identifier.value::value'
            ]
        ]);
        
        $pazienti = Pazienti::all();
        
        // Controllo se il paziente da aggiornare è presente nel sistema
        if ($id_paz['identifier'] != $id) {
            throw new Exception("Patient does not exist in the database");
        }
        
        // Memorizzo in un array i dati necessari presenti nel file caricato
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
                'uses' => 'contact[relationship.coding.code::value>attr]'
            ],
            'ContSurname' => [
                'uses' => 'contact[name.family::value>attr]'
            ],
            'ContName' => [
                'uses' => 'contact[name.given::value>attr]'
            ]
        
        ]);
        
        // USER
        
        $patient_data = Pazienti::where('id_paziente', $id)->first();
        
        $updUser = User::where("id_utente", $patient_data->id_utente)->first();
        
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
        
        $updContact = Recapiti::where("id_utente", $patient_data->id_utente)->first();
        
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
        
        PatientContact::where('Id_Patient', $patient_data->id_paziente)->delete();
        
        $xmlfile = file_get_contents($file);
        $ob = simplexml_load_string($xmlfile);
        $json = json_encode($ob);
        $configData = json_decode($json, true);
        
        $contactTelecom = array();
        
        if (array_key_exists('telecom', $configData['contact'])) {
            foreach ($configData['contact']['telecom'] as $c) {
                foreach ($c["value"] as $t) {
                    array_push($contactTelecom, $t['value']);
                }
            }
        } else {
            $contactTelecom = array();
            foreach ($configData["contact"] as $c) {
                foreach ($c["telecom"] as $t) {
                    array_push($contactTelecom, $t["value"]["@attributes"]["value"]);
                }
            }
        }
        
        $count = 0;
        $contactPhone = array();
        while ($count < count($contactTelecom)) {
            array_push($contactPhone, $contactTelecom[$count]);
            $count = $count + 2;
        }
        
        $contactMail = array();
        $count = 1;
        while ($count < count($contactTelecom)) {
            array_push($contactMail, $contactTelecom[$count]);
            $count = $count + 2;
        }
        
        $patientContact = array();
        for ($i = 0; $i < count($lettura['ContName']); $i ++) {
            $pc = array(
                'Id_Patient' => $lettura['identifier'],
                'Relationship' => $lettura['ContRelCode'][$i]['attr'],
                'Name' => $lettura['ContName'][$i]['attr'],
                'Surname' => $lettura['ContSurname'][$i]['attr'],
                'Telephone' => $contactPhone[$i],
                'Mail' => $contactMail[$i]
            );
            array_push($patientContact, $pc);
        }
        
        $addPatientContact = new PatientContact();
        $add = array();
        $patCont = array();
        
        foreach ($patientContact as $pc) {
            foreach ($pc as $key => $value) {
                $add[$key] = $value;
            }
            array_push($patCont, $add);
        }
        
        foreach ($patCont as $p) {
            $addPatientContact = new PatientContact();
            foreach ($p as $key => $value) {
                $addPatientContact->$key = $value;
            }
            $addPatientContact->save();
        }
        
        return response()->json($id, 200);
    }
/*
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
*/
    /**
     * Funzione per il salvataggio di una risorsa
     */
    public static function getResource($id)
    {
        
        // Recupero i dati del paziente loggato
        $patient = Pazienti::where('id_paziente', $id)->first();
        
        // Controllo se il paziente esiste nel sistema
        if (! $patient) {
            throw new FHIR\IdNotFoundInDatabaseException("resource with the id provided doesn't exist in database");
        }
        
        // Recupero i contatti del paziente
        $patient_contacts = PatientContact::where('id_patient', $id)->get();
        
        /*
         * Salvo in un array i dati del paziente che verranno riportati nella parte
         * descrittiva della risorsa
         */
        $values_in_narrative = array(
            "Id" => $id,
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
        
        /*
         * Salvo in un array i dati dei contatti del paziente che verranno riportati
         * nella parte descrittiva della risorsa
         */
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
        $data_xml["patient_contacts"] = $patient_contacts;
        
        self::xml($data_xml);
    }

    public static function xml($data_xml)
    {
        // Creazione di un oggetto dom con la codifica UTF-8
        $dom = new DOMDocument('1.0', 'utf-8');
        
        // Creazione del nodo Patient, cioè il nodo Root della risorsa
        $patient = $dom->createElement('Patient');
        // Valorizzo il namespace della risorsa e del documento XML, in questo caso la specifica FHIR
        $patient->setAttribute('xmlns', 'http://hl7.org/fhir');
        // Corrello l'elemento con il nodo superiore
        $patient = $dom->appendChild($patient);
        
        // Creazione del nodo ID sempre presente nelle risorse FHIR
        $id = $dom->createElement('id');
        // Il valore dell'ID è il valore dell'ID nella relativa tabella del DB
        $id->setAttribute('value', $data_xml["narrative"]["Id"]);
        $id = $patient->appendChild($id);
        
        // Creazione della parte narrativa in XHTML e composta da tag HTML visualizzabili se aperto il file XML in un Browser
        $narrative = $dom->createElement('text');
        // Corrello l'elemento con il nodo superiore
        $narrative = $patient->appendChild($narrative);
        
        // Creazione del nodo status che indica lo stato della parte narrativa
        $status = $dom->createElement('status');
        // Il valore del nodo status è sempre generated, la parte narrativa è generato dal sistema
        $status->setAttribute('value', 'generated');
        $status = $narrative->appendChild($status);
        
        // Creazione del div che conterrà la tabella con i valori visualizzabili nella parte narrativa
        $div = $dom->createElement('div');
        // Link al value set della parte narrativa, cioè la codifica XHTML
        $div->setAttribute('xmlns', "http://www.w3.org/1999/xhtml");
        $div = $narrative->appendChild($div);
        
        // Creazione della tabella che conterrà i valori
        $table = $dom->createElement('table');
        $table->setAttribute('border', "2");
        $table = $div->appendChild($table);
        
        // Creazione del nodo tbody
        $tbody = $dom->createElement('tbody');
        $tbody = $table->appendChild($tbody);
        
        
        // Creazione di una riga
        $tr = $dom->createElement('tr');
        $tr = $tbody->appendChild($tr);
        // Identifier
        $td = $dom->createElement('td', "Identifier");
        $td = $tr->appendChild($td);
        $td = $dom->createElement('td', $data_xml["narrative"]["Identifier"]);
        $td = $tr->appendChild($td);
        
        
        // Creazione di una riga
        $tr = $dom->createElement('tr');
        $tr = $tbody->appendChild($tr);
        // Active
        $td = $dom->createElement('td', "Active");
        $td = $tr->appendChild($td);
        $td = $dom->createElement('td', $data_xml["narrative"]["Active"]);
        $td = $tr->appendChild($td);
        
        
        
        // Creazione di una riga
        $tr = $dom->createElement('tr');
        $tr = $tbody->appendChild($tr);
        // Name
        $td = $dom->createElement('td', "Name");
        $td = $tr->appendChild($td);
        $td = $dom->createElement('td', $data_xml["narrative"]["Name"]);
        $td = $tr->appendChild($td);
        
        
        
        
        // Creazione di una riga
        $tr = $dom->createElement('tr');
        $tr = $tbody->appendChild($tr);
        // Telecom
        $td = $dom->createElement('td', "Telecom");
        $td = $tr->appendChild($td);
        $td = $dom->createElement('td', $data_xml["narrative"]["Telecom"]);
        $td = $tr->appendChild($td);
       
        
        
        // Creazione di una riga
        $tr = $dom->createElement('tr');
        $tr = $tbody->appendChild($tr);
        // Gender
        $td = $dom->createElement('td', "Gender");
        $td = $tr->appendChild($td);
        $td = $dom->createElement('td', $data_xml["narrative"]["Gender"]);
        $td = $tr->appendChild($td);
        
        
        
        // Creazione di una riga
        $tr = $dom->createElement('tr');
        $tr = $tbody->appendChild($tr);
        // BirthDate
        $td = $dom->createElement('td', "BirthDate");
        $td = $tr->appendChild($td);
        $td = $dom->createElement('td', $data_xml["narrative"]["BirthDate"]);
        $td = $tr->appendChild($td);
       
        
        
        
        // Creazione di una riga
        $tr = $dom->createElement('tr');
        $tr = $tbody->appendChild($tr);
        // Deceased
        $td = $dom->createElement('td', "Deceased");
        $td = $tr->appendChild($td);
        $td = $dom->createElement('td', $data_xml["narrative"]["Deceased"]);
        $td = $tr->appendChild($td);
        
        
        
        // Creazione di una riga
        $tr = $dom->createElement('tr');
        $tr = $tbody->appendChild($tr);
        // Address
        $td = $dom->createElement('td', "Address");
        $td = $tr->appendChild($td);
        $td = $dom->createElement('td', $data_xml["narrative"]["Address"]);
        $td = $tr->appendChild($td);
       
        
        
        // Creazione di una riga
        $tr = $dom->createElement('tr');
        $tr = $tbody->appendChild($tr);
        // MaritalStatus
        $td = $dom->createElement('td', "MaritalStatus");
        $td = $tr->appendChild($td);
        $td = $dom->createElement('td', $data_xml["narrative"]["MaritalStatus"]);
        $td = $tr->appendChild($td);
        
        
        
        foreach ($data_xml["narrative_patient_contact"] as $key => $value) {
            // Creazione di una riga
            $tr = $dom->createElement('tr');
            $tr = $tbody->appendChild($tr);
            // Contact
            $td = $dom->createElement('td', $key);
            $td = $tr->appendChild($td);
            $td = $dom->createElement('td', $value);
            $td = $tr->appendChild($td);
        }
        
        
        
        // Creazione di una riga
        $tr = $dom->createElement('tr');
        $tr = $tbody->appendChild($tr);
        // Language
        $td = $dom->createElement('td', "Language");
        $td = $tr->appendChild($td);
        $td = $dom->createElement('td', $data_xml["narrative"]["Language"]);
        $td = $tr->appendChild($td);
        
        
        // Creazione del nodo identifier identificativo della risorsa Patient attraverso URI della risorsa
        $identifier = $dom->createElement('identifier');
        $identifier = $patient->appendChild($identifier);
        // Creazione del nodo use con valore fisso ad usual
        $use = $dom->createElement('use');
        $use->setAttribute('value', 'official');
        $use = $identifier->appendChild($use);
        // Creazione del nodo system che identifica il namespace degli URI per identificare la risorsa
        $system = $dom->createElement('system');
        $system->setAttribute('value', 'http://resp.local'); // RFC gestione URI
        $system = $identifier->appendChild($system);
        // Creazione del nodo value
        $value = $dom->createElement('value');
        
        // Do il valore all' URI della risorsa
        $value->setAttribute('value', $data_xml["narrative"]["Id"]);
        $value = $identifier->appendChild($value);
        
        
        // Creazione del nodo active 
        $active = $dom->createElement('active');
        $active->setAttribute('value', $data_xml["narrative"]["Active"]);
        $active = $patient->appendChild($active);
        
        
        // Creazione del nodo per il nominativo del paziente
        $name = $dom->createElement('name');
        $name = $patient->appendChild($name);
        // Creazione del nodo use settato sempre al valore usual
        $use = $dom->createElement('use');
        $use->setAttribute('value', 'usual');
        $use = $name->appendChild($use);
        // Creazione del nodo family 
        $family = $dom->createElement('family');
        $family->setAttribute('value', $data_xml["patient"]->paziente_cognome);
        $family = $name->appendChild($family);
        // Creazione del nodo given 
        $given = $dom->createElement('given');
        $given->setAttribute('value', $data_xml["patient"]->paziente_nome);
        $given = $name->appendChild($given);
       
        
        
        // Creazione del nodo telecom con il contatto telefonico del paziente
        $telecom = $dom->createElement('telecom');
        $telecom = $patient->appendChild($telecom);
        // Creazione del nodo system 
        $system = $dom->createElement('system');
        $system->setAttribute('value', 'phone');
        $system = $telecom->appendChild($system);
        // Creazione del nodo value 
        $value = $dom->createElement('value');
        $value->setAttribute('value', $data_xml["patient"]->getPhone());
        $value = $telecom->appendChild($value);
        // Creazione del nodo use che indica la tipologia di numero di telefono
        $use = $dom->createElement('use');
        $use->setAttribute('value', 'mobile');
        $use = $telecom->appendChild($use);
        
        // Creazione del nodo telecom con il contatto mail del paziente
        $telecom = $dom->createElement('telecom');
        $telecom = $patient->appendChild($telecom);
        // Creazione del nodo system 
        $system = $dom->createElement('system');
        $system->setAttribute('value', 'email');
        $system = $telecom->appendChild($system);
        // Creazione del nodo value 
        $value = $dom->createElement('value');
        $value->setAttribute('value', $data_xml["patient"]->getMail());
        $value = $telecom->appendChild($value);
        // Creazione del nodo use 
        $use = $dom->createElement('use');
        $use->setAttribute('value', 'home');
        $use = $telecom->appendChild($use);
       
        
        
        // Creazione del nodo gender 
        $gender = $dom->createElement('gender');
        $gender->setAttribute('value', $data_xml["patient"]->getGender());
        $gender = $patient->appendChild($gender);
        
        
        
        // Creazione del nodo birthdate 
        $birthDate = $dom->createElement('birthDate');
        $birthDate->setAttribute('value', $data_xml["patient"]->getBirth());
        $birthDate = $patient->appendChild($birthDate);
        
        
        
        // Creazione del nodo deceasedBoolean 
        $deceasedBoolean = $dom->createElement('deceasedBoolean');
        $deceasedBoolean->setAttribute('value', $data_xml["patient"]->getDeceased());
        $deceasedBoolean = $patient->appendChild($deceasedBoolean);
        
        
        
        // Creazione del nodo address 
        $address = $dom->createElement('address');
        $address = $patient->appendChild($address);
        // Creazione del nodo use 
        $use = $dom->createElement('use');
        $use->setAttribute('value', 'home');
        $use = $address->appendChild($use);
        // Creazione del nodo line 
        $line = $dom->createElement('line');
        $line->setAttribute('value', $data_xml["patient"]->getLine());
        $line = $address->appendChild($line);
        // Creazione del nodo city 
        $city = $dom->createElement('city');
        $city->setAttribute('value', $data_xml["patient"]->getCity());
        $city = $address->appendChild($city);
        // Creazione del nodo country 
        $country = $dom->createElement('state');
        $country->setAttribute('value', $data_xml["patient"]->getCountryName());
        $country = $address->appendChild($country);
        // Creazione del nodo postalCode 
        $postalCode = $dom->createElement('postalCode');
        $postalCode->setAttribute('value', $data_xml["patient"]->getPostalCode());
        $postalCode = $address->appendChild($postalCode);
        
        
        
        
        // Creazione del nodo maritalStatus 
        $maritalStatus = $dom->createElement('maritalStatus');
        $maritalStatus = $patient->appendChild($maritalStatus);
        // Creazione del nodo coding 
        $coding = $dom->createElement('coding');
        $coding = $maritalStatus->appendChild($coding);
        // Creazione del nodo system 
        $system = $dom->createElement('system');
        $system->setAttribute('value', "http://hl7.org/fhir/v3/MaritalStatus"); // value set HL7
        $system = $coding->appendChild($system);
        // Creazione del nodo code 
        $code = $dom->createElement('code');
        $code->setAttribute('value', $data_xml["patient"]->getMaritalStatusCode());
        $code = $coding->appendChild($code);
        // Creazione del nodo dysplay 
        $dysplay = $dom->createElement('display');
        // Do il valore all' attributo del tag
        $dysplay->setAttribute('value', $data_xml["patient"]->getMaritalStatusDisplay());
        $dysplay = $coding->appendChild($dysplay);
        
        // Patient.Contact
        foreach ($data_xml["patient_contacts"] as $pc) {
            // Creazione del nodo contact
            $contact = $dom->createElement('contact');
            $contact = $patient->appendChild($contact);
            // Creazione del nodo relationship
            $relationship = $dom->createElement('relationship');
            $relationship = $contact->appendChild($relationship);
            // Creazione del nodo coding
            $coding = $dom->createElement('coding');
            $coding = $relationship->appendChild($coding);
            // Creazione del nodo system
            $system = $dom->createElement('system');
            $system->setAttribute('value', 'http://hl7.org/fhir/v2/0131');
            $system = $coding->appendChild($system);
            // Creazione del nodo code
            $code = $dom->createElement('code');
            $code->setAttribute('value', $pc->getRelationship());
            $code = $coding->appendChild($code);
            // Creazione del nodo name
            $name = $dom->createElement('name');
            $name = $contact->appendChild($name);
            // Creazione del nodo use
            $use = $dom->createElement('use');
            $use->setAttribute('value', 'official');
            $use = $name->appendChild($use);
            // Creazione del nodo family
            $family = $dom->createElement('family');
            $family->setAttribute('value', $pc->getSurname());
            $family = $name->appendChild($family);
            // Creazione del nodo given
            $given = $dom->createElement('given');
            $given->setAttribute('value', $pc->getName());
            $given = $name->appendChild($given);
            // Creazione del nodo telecom
            $telecom = $dom->createElement('telecom');
            $telecom = $contact->appendChild($telecom);
            // Creazione del nodo system
            $system = $dom->createElement('system');
            $system->setAttribute('value', 'phone');
            $system = $telecom->appendChild($system);
            // Creazione del nodo value
            $value = $dom->createElement('value');
            $value->setAttribute('value', $pc->getTelephone());
            $value = $telecom->appendChild($value);
            // Creazione del nodo use
            $use = $dom->createElement('use');
            $use->setAttribute('value', 'home');
            $use = $telecom->appendChild($use);
            // Creazione del nodo rank
            $rank = $dom->createElement('rank');
            $rank->setAttribute('value', '1');
            $rank = $telecom->appendChild($rank);
            // Creazione del nodo telecom
            $telecom = $dom->createElement('telecom');
            $telecom = $contact->appendChild($telecom);
            // Creazione del nodo system
            $system = $dom->createElement('system');
            $system->setAttribute('value', 'email');
            $system = $telecom->appendChild($system);
            // Creazione del nodo value
            $value = $dom->createElement('value');
            $value->setAttribute('value', $pc->getMail());
            $value = $telecom->appendChild($value);
            // Creazione del nodo use
            $use = $dom->createElement('use');
            $use->setAttribute('value', 'home');
            $use = $telecom->appendChild($use);
        }
        
        // Creazione del nodo communication 
        $communication = $dom->createElement('communication');
        $communication = $patient->appendChild($communication);
        // Creazione del nodo language
        $language = $dom->createElement('language');
        $language = $communication->appendChild($language);
        // Creazione del nodo coding
        $coding = $dom->createElement('coding');
        $coding = $language->appendChild($coding);
        // Creazione del nodo system in cui si indica il value set dell' IETF
        $system = $dom->createElement('system');
        $system->setAttribute('value', 'urn:ietf:bcp:47');
        $system = $coding->appendChild($system);
        // Creazione del nodo code 
        $code = $dom->createElement('code');
        $code->setAttribute('value', $data_xml["patient"]->paziente_lingua);
        $code = $coding->appendChild($code);
        
        // Elimino gli spazi bianchi superflui per la viasualizzazione grafica dell'XML
        $dom->preserveWhiteSpace = false;
        // Formatto il documento per l'output
        $dom->formatOutput = true;
        $path = getcwd() . "\\resources\\Patient\\";
        // Salvo il documento XML nella cartella rsources dando come nome, l'id del paziente
        $dom->save($path . "RESP-PATIENT-" . $data_xml["narrative"]["Id"] . ".xml");
        return $dom->saveXML();
    }
}
?>
