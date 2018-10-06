<?php
namespace App\Http\Controllers\Fhir\Modules;

use App\Http\Controllers\Fhir\Modules\FHIRResource;
use App\Models\CareProviders\CareProvider;
use Illuminate\Http\Request;
use App;
use App\Models\FHIR\CppQualification;
use View;
use Illuminate\Filesystem\Filesystem;
use File;
use Orchestra\Parser\Xml\Facade as XmlParser;
use Exception;
use DB;
use Redirect;
use Response;
use SimpleXMLElement;
use App\Models\CurrentUser\Recapiti;
use App\Models\CurrentUser\User;
use App\Models\Domicile\Comuni;
use DOMDocument;

class FHIRPractitioner
{
    
    public function show($id)
    {
        // Recupero i dati del paziente
        $practictioner = CareProvider::where('id_cpp', $id)->first();
        
        if (! $practictioner) {
            throw new FHIR\IdNotFoundInDatabaseException("resource with the id provided doesn't exist in database");
        }
        
        // Recupero le qualifiche del practictioner
        $practictioner_qualifiations = CppQualification::where('id_cpp', $id)->get();
        
        // Recupero gli operatori sanitari del paziente
        // $careproviders = CppPaziente::where('id_paziente', $id)->get();
        
        // Sono i valori che verranno riportati nella parte descrittiva del documento
        $values_in_narrative = array(
            "Identifier" => "RESP-PRACTICTIONER" . "-" . $practictioner->getIdCpp(),
            "Active" => $practictioner->isActive(),
            "Name" => $practictioner->getFullName(),
            "Telecom" => $practictioner->getTelecom(),
            "Gender" => $practictioner->getGender(),
            "BirthDate" => $practictioner->getBirth(),
            "Address" => $practictioner->getAddress(),
            "Language" => $practictioner->getLanguage()
            
        );
        
        // Practictioner.Qualification
        $narrative_practictioner_qualifications = array();
        $count = 0;
        foreach ($practictioner->getQualifications() as $pq) {
            $count ++;
            $narrative_practictioner_qualifications["QualificationName" . " " . $count] = $pq->getQualificationDisplay();
            $narrative_practictioner_qualifications["QualificationStartPeriod" . " " . $count] = $pq->getStartPeriod();
            $narrative_practictioner_qualifications["QualificationEndPeriod" . " " . $count] = $pq->getEndPeriod();
            $narrative_practictioner_qualifications["QualificationIssuer" . " " . $count] = $pq->getIssuer();
        }
        
        // prelevo i dati dell'utente da mostrare come estensione
        $custom_extensions = array(
            'Comune' => $practictioner->getComune(),
            'Id_Utente' => $practictioner->getIdUtente()
        );
        
        $data_xml["narrative"] = $values_in_narrative;
        $data_xml["narrative_practictioner_qualifications"] = $narrative_practictioner_qualifications;
        $data_xml["extensions"] = $custom_extensions;
        $data_xml["practictioner"] = $practictioner;
        // $data_xml["careproviders"] = $careproviders;
        $data_xml["practictioner_qualifiations"] = $practictioner_qualifiations;
        
        return view("pages.fhir.practictioner", [
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
        
        $cpp = CareProvider::all();
        
        foreach ($cpp as $p) {
            if ($p->id_cpp == $id['identifier']) {
                throw new Exception("Practictioner is already exists");
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
            'communication' => [
                'uses' => 'communication.coding.code::value'
            ],
            'qualificationCode' => [
                'uses' => 'qualification[code.coding.code::value>attr]'
            ],
            'qualificationPeriodStart' => [
                'uses' => 'qualification[period.start::value>attr]'
            ],
            'qualificationPeriodEnd' => [
                'uses' => 'qualification[period.end::value>attr]'
            ],
            'qualificationIssuer' => [
                'uses' => 'qualification[issuer.display::value>attr]'
            ]
            
        ]);
        
        // USER
        
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
        
        $addUtente = new User();
        
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
        
        $addContact = new Recapiti();
        
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
        
        // PRACTICTIONER
        
        $practictioner = array(
            'id_cpp' => $lettura['identifier'],
            'id_utente' => $utente->id_utente,
            'cpp_nome' => $lettura['name'],
            'cpp_cognome' => $lettura['surname'],
            'cpp_sesso' => $lettura['gender'],
            'cpp_nascita_data' => $lettura['birthDate'],
            'cpp_codfiscale' => '',
            'active' => $lettura['active'],
            'cpp_lingua' => $lettura['communication']
        );
        
        $addPractictioner = new CareProvider();
        
        foreach ($practictioner as $key => $value) {
            if (empty($value)) {
                continue;
            }
            $addPractictioner->$key = $value;
        }
        
        $addPractictioner->save();
        
        // PRACTICTIONER.QUALIFICATION
        
        $practQual = array();
        $cpp = CareProvider::all()->last();
        
        for ($i = 0; $i < count($lettura['qualificationCode']); $i ++) {
            $practictionerQual = array(
                'id_cpp' => $cpp->id_cpp,
                'Code' => $lettura['qualificationCode'][$i]['attr'],
                'Start_Period' => $lettura['qualificationPeriodStart'][$i]['attr'],
                'End_Period' => $lettura['qualificationPeriodEnd'][$i]['attr'],
                'Issuer' => $lettura['qualificationIssuer'][$i]['attr']
            );
            array_push($practQual, $practictionerQual);
        }
        
        $addPractictionerQual = new CppQualification();
        $add = array();
        $praQual = array();
        
        foreach ($practQual as $pq) {
            foreach ($pq as $key => $value) {
                $add[$key] = $value;
            }
            array_push($praQual, $add);
        }
        
        foreach ($praQual as $a) {
            $addPractictionerQual = new CppQualification();
            foreach ($a as $key => $value) {
                $addPractictionerQual->$key = $value;
            }
            $addPractictionerQual->save();
        }
        
        return response()->json($lettura['identifier'], 201);
    }
    
    public function update(Request $request, $id)
    {
        $file = $request->file('fileUpdate');
        
        $xml = XmlParser::load($file->getRealPath());
        
        $id_cpp = $xml->parse([
            'identifier' => [
                'uses' => 'identifier.value::value'
            ]
        ]);
        
        $cpp = CareProvider::all();
        
        if (! CareProvider::find($id)) {
            throw new Exception("Practitioner does not exist in the database");
        }
        
        if ($id != $id_cpp['identifier']) {
            throw new Exception("Error");
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
            'communication' => [
                'uses' => 'communication.coding.code::value'
            ],
            'qualificationCode' => [
                'uses' => 'qualification[code.coding.code::value>attr]'
            ],
            'qualificationPeriodStart' => [
                'uses' => 'qualification[period.start::value>attr]'
            ],
            'qualificationPeriodEnd' => [
                'uses' => 'qualification[period.end::value>attr]'
            ],
            'qualificationIssuer' => [
                'uses' => 'qualification[issuer.display::value>attr]'
            ]
            
        ]);
        
        // USER
        
        $practitioner_data = CareProvider::where('id_cpp', $id)->first();
        $user_data = User::where("id_utente", $practitioner_data->id_utente)->first();
        
        $updUser = $user_data;
        
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
        
        $comune = Comuni::all()->where('comune_nominativo', $lettura['city'])->first();
        
        $updContact = Recapiti::where("id_utente", $user_data->id_utente)->first();
        
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
        
        // PRACTICTIONER
        
        $updPractitioner = $practitioner_data;
        
        $practitioner = array(
            'cpp_nome' => $lettura['name'],
            'cpp_cognome' => $lettura['surname'],
            'cpp_sesso' => $lettura['gender'],
            'cpp_nascita_data' => $lettura['birthDate'],
            'cpp_codfiscale' => '',
            'active' => $lettura['active'],
            'cpp_lingua' => $lettura['communication']
        );
        
        foreach ($practitioner as $key => $value) {
            if (empty($value)) {
                continue;
            }
            $updPractitioner->$key = $value;
        }
        
        $updPractitioner->save();
        
        // PRACTITIONER.QUALIFICATION
        
        $practQual = array();
        
        $cpp = $practitioner_data;
        
        CppQualification::where("id_cpp", $cpp->id_cpp)->delete();
        
        for ($i = 0; $i < count($lettura['qualificationCode']); $i ++) {
            $practitionerQual = array(
                'id_cpp' => $cpp->id_cpp,
                'Code' => $lettura['qualificationCode'][$i]['attr'],
                'Start_Period' => $lettura['qualificationPeriodStart'][$i]['attr'],
                'End_Period' => $lettura['qualificationPeriodEnd'][$i]['attr'],
                'Issuer' => $lettura['qualificationIssuer'][$i]['attr']
            );
            array_push($practQual, $practitionerQual);
        }
        
        $updPractitionerQual = new CppQualification();
        $add = array();
        $praQual = array();
        
        foreach ($practQual as $pq) {
            foreach ($pq as $key => $value) {
                $add[$key] = $value;
            }
            array_push($praQual, $add);
        }
        
        foreach ($praQual as $a) {
            $updPractitionerQual = new CppQualification();
            foreach ($a as $key => $value) {
                $updPractitionerQual->$key = $value;
            }
            $updPractitionerQual->save();
        }
        
        return response()->json($id, 200);
    }
    
    function destroy($id)
    {
        $practitioner = CareProvider::find($id);
        
        if (! $practitioner->exists()) {
            throw new Exception("resource with the id provided doesn't exist in database");
        }
        
        CareProvider::find($id)->delete();
        
        $user = User::where('id_utente', $practitioner->id_utente)->first();
        
        User::find($user->id_utente)->delete();
        
        return response()->json(null, 204);
    }
    
    
   public static function getResource($id){
        
        // Recupero i dati del paziente
        $practitioner = CareProvider::where('id_cpp', $id)->first();
        
        if (! $practitioner) {
            throw new FHIR\IdNotFoundInDatabaseException("resource with the id provided doesn't exist in database");
        }
        
        // Recupero le qualifiche del practictioner
        $practitioner_qualifiations = CppQualification::where('id_cpp', $id)->get();
        
        // Recupero gli operatori sanitari del paziente
        // $careproviders = CppPaziente::where('id_paziente', $id)->get();
        
        // Sono i valori che verranno riportati nella parte descrittiva del documento
        $values_in_narrative = array(
            "Id" => $practitioner->getIdCpp(),
            "Identifier" => "RESP-PRACTICTIONER" . "-" . $practitioner->getIdCpp(),
            "Active" => $practitioner->isActive(),
            "Name" => $practitioner->getFullName(),
            "Telecom" => $practitioner->getTelecom(),
            "Gender" => $practitioner->getGender(),
            "BirthDate" => $practitioner->getBirth(),
            "Address" => $practitioner->getAddress(),
            "Language" => $practitioner->getLanguage()
            
        );
        
        // Practictioner.Qualification
        $narrative_practitioner_qualifications = array();
        $count = 0;
        foreach ($practitioner->getQualifications() as $pq) {
            $count ++;
            $narrative_practitioner_qualifications["QualificationName" . " " . $count] = $pq->getQualificationDisplay();
            $narrative_practitioner_qualifications["QualificationStartPeriod" . " " . $count] = $pq->getStartPeriod();
            $narrative_practitioner_qualifications["QualificationEndPeriod" . " " . $count] = $pq->getEndPeriod();
            $narrative_practitioner_qualifications["QualificationIssuer" . " " . $count] = $pq->getIssuer();
        }
        
        // prelevo i dati dell'utente da mostrare come estensione
        $custom_extensions = array(
            'Comune' => $practitioner->getComune(),
            'Id_Utente' => $practitioner->getIdUtente()
        );
        
        $data_xml["narrative"] = $values_in_narrative;
        $data_xml["narrative_practitioner_qualifications"] = $narrative_practitioner_qualifications;
        $data_xml["extensions"] = $custom_extensions;
        $data_xml["practitioner"] = $practitioner;
        // $data_xml["careproviders"] = $careproviders;
        $data_xml["practitioner_qualifiations"] = $practitioner_qualifiations;
        
        self::xml($data_xml);
        
    }
    
    
    public static function xml($data_xml){
        //Creazione di un oggetto dom con la codifica UTF-8
        $dom = new DOMDocument('1.0', 'utf-8');
        
        //Creazione del nodo Patient, cioè il nodo Root  della risorsa
        $practitioner = $dom->createElement('Practitioner');
        //Valorizzo il namespace della risorsa e del documento XML, in  questo caso la specifica FHIR
        $practitioner->setAttribute('xmlns', 'http://hl7.org/fhir');
        //Corrello l'elemento con il nodo superiore
        $practitioner = $dom->appendChild($practitioner);
        
        
        //Creazione del nodo ID sempre presente nelle risorse FHIR
        $id = $dom->createElement('id');
        //Il valore dell'ID è il valore dell'ID nella relativa tabella del DB
        $id->setAttribute('value', $data_xml["narrative"]["Id"]);
        $id = $practitioner->appendChild($id);
        
        //Creazione della parte narrativa in XHTML e composta da tag HTML visualizzabili se aperto il file XML in un Browser
        $narrative = $dom->createElement('text');
        //Corrello l'elemento con il nodo superiore
        $narrative = $practitioner->appendChild($narrative);
        
        
        //Creazione del nodo status che indica lo stato della parte narrativa
        $status = $dom->createElement('status');
        //Il valore del nodo status è sempre generated, la parte narrativa è generato dal sistema
        $status->setAttribute('value', 'generated');
        $status = $narrative->appendChild($status);
        
        
        //Creazione del div che conterrà la tabella con i valori visualizzabili nella parte narrativa
        $div = $dom->createElement('div');
        //Link al value set della parte narrativa, cioè la codifica XHTML
        $div->setAttribute('xmlns',"http://www.w3.org/1999/xhtml");
        $div = $narrative->appendChild($div);
        
        
        //Creazione della tabella che conterrà i valori
        $table = $dom->createElement('table');
        $table->setAttribute('border',"2");
        $table = $div->appendChild($table);
        
        
        //Creazione del nodo tbody
        $tbody = $dom->createElement('tbody');
        $tbody = $table->appendChild($tbody);
        
        
        //Creazione di una riga
        $tr = $dom->createElement('tr');
        $tr = $tbody->appendChild($tr);
        
        //Creazione della colonna Identifier
        $td = $dom->createElement('td',"Identifier");
        $td = $tr->appendChild($td);
        
        //Creazione della colonna con il valore di nome e cognome del practitioner
        $td = $dom->createElement('td', $data_xml["narrative"]["Identifier"]);
        $td = $tr->appendChild($td);
        
             
        
        //Creazione di una riga
        $tr = $dom->createElement('tr');
        $tr = $tbody->appendChild($tr);
        
        //Creazione della colonna Active
        $td = $dom->createElement('td',"Active");
        $td = $tr->appendChild($td);
        
        //Creazione della colonna con il valore di nome e cognome del practitioner
        $td = $dom->createElement('td', $data_xml["narrative"]["Active"]);
        $td = $tr->appendChild($td);
        
        
        
        
        //Creazione di una riga
        $tr = $dom->createElement('tr');
        $tr = $tbody->appendChild($tr);
        
        //Creazione della colonna Name
        $td = $dom->createElement('td',"Name");
        $td = $tr->appendChild($td);
        
        //Creazione della colonna con il valore di nome e cognome del practitioner
        $td = $dom->createElement('td', $data_xml["narrative"]["Name"]);
        $td = $tr->appendChild($td);
        
        
        
        
        //Creazione di una riga
        $tr = $dom->createElement('tr');
        $tr = $tbody->appendChild($tr);
        
        //Creazione della colonna Telecom
        $td = $dom->createElement('td',"Telecom");
        $td = $tr->appendChild($td);
        
        //Creazione della colonna con il valore di nome e cognome del practitioner
        $td = $dom->createElement('td', $data_xml["narrative"]["Telecom"]);
        $td = $tr->appendChild($td);
        
        
        
        
        //Creazione di una riga
        $tr = $dom->createElement('tr');
        $tr = $tbody->appendChild($tr);
        
        //Creazione della colonna Gender
        $td = $dom->createElement('td',"Gender");
        $td = $tr->appendChild($td);
        
        //Creazione della colonna con il valore di nome e cognome del practitioner
        $td = $dom->createElement('td', $data_xml["narrative"]["Gender"]);
        $td = $tr->appendChild($td);
        
        
        
        
        //Creazione di una riga
        $tr = $dom->createElement('tr');
        $tr = $tbody->appendChild($tr);
        
        //Creazione della colonna BirthDate
        $td = $dom->createElement('td',"BirthDate");
        $td = $tr->appendChild($td);
        
        //Creazione della colonna con il valore di nome e cognome del practitioner
        $td = $dom->createElement('td', $data_xml["narrative"]["BirthDate"]);
        $td = $tr->appendChild($td);
        
        
        
        //Creazione di una riga
        $tr = $dom->createElement('tr');
        $tr = $tbody->appendChild($tr);
        
        //Creazione della colonna Address
        $td = $dom->createElement('td',"Address");
        $td = $tr->appendChild($td);
        
        //Creazione della colonna con il valore di nome e cognome del practitioner
        $td = $dom->createElement('td', $data_xml["narrative"]["Address"]);
        $td = $tr->appendChild($td);
        

             
        foreach($data_xml["narrative_practitioner_qualifications"] as $key => $value){
            //Creazione di una riga
            $tr = $dom->createElement('tr');
            $tr = $tbody->appendChild($tr);
            
            //Creazione della colonna Contact
            $td = $dom->createElement('td', $key);
            $td = $tr->appendChild($td);
            
            //Creazione della colonna con il valore di contact del practitioner
            $td = $dom->createElement('td', $value);
            $td = $tr->appendChild($td);
            
            
        }
        
        
        //Creazione di una riga
        $tr = $dom->createElement('tr');
        $tr = $tbody->appendChild($tr);
        
        //Creazione della colonna Language
        $td = $dom->createElement('td',"Language");
        $td = $tr->appendChild($td);
        
        //Creazione della colonna con il valore di nome e cognome del paziente
        $td = $dom->createElement('td', $data_xml["narrative"]["Language"]);
        $td = $tr->appendChild($td);
        
        
        
        //Creazione del nodo identifier identificativo della risorsa Patient attraverso URI della risorsa
        $identifier = $dom->createElement('identifier');
        $identifier = $practitioner->appendChild($identifier);
        //Creazione del nodo use con valore fisso ad usual
        $use = $dom->createElement('use');
        $use->setAttribute('value', 'official');
        $use = $identifier->appendChild($use);
        //Creazione del nodo system che identifica il namespace degli URI per identificare la risorsa
        $system = $dom->createElement('system');
        $system->setAttribute('value', 'http://resp.local');  //RFC gestione URI
        $system = $identifier->appendChild($system);
        //Creazione del nodo value
        $value = $dom->createElement('value');
        //Do il valore all' URI della risorsa
        $value->setAttribute('value', $data_xml["narrative"]["Id"]);
        $value = $identifier->appendChild($value);
        
        
        //Creazione del nodo active settato a true in quanto la risorsa è attiva per il FSEM
        $active = $dom->createElement('active');
        $active->setAttribute('value', $data_xml["narrative"]["Active"]);
        $active = $practitioner->appendChild($active);
        
        
        //Creazione del nodo per il nominativo del practitioner
        $name = $dom->createElement('name');
        $name = $practitioner->appendChild($name);
        //Creazione del nodo family che indica il nome dalla famiglia di provenienza, quindi il cognome del practitioner
        $family = $dom->createElement('family');
        $family->setAttribute('value', $data_xml["practitioner"]->getSurname());
        $family = $name->appendChild($family);
        //Creazione del nodo given che indica il nome di battesimo dato al practitioner
        $given = $dom->createElement('given');
        $given->setAttribute('value', $data_xml["practitioner"]->getName());
        $given = $name->appendChild($given);
        //Creazione del nodo prefix settato sempre al valore Dr
        $prefix = $dom->createElement('prefix');
        $prefix->setAttribute('value', 'Dr');
        $prefix = $name->appendChild($prefix);
        
        
        //Creazione del nodo telecom con il contatto telefonico del practitioner
        $telecom = $dom->createElement('telecom');
        $telecom = $practitioner->appendChild($telecom);
        //Creazione del nodo system che indica che il contatto è un valore telefonico
        $system = $dom->createElement('system');
        $system->setAttribute('value', 'phone');
        $system = $telecom->appendChild($system);
        //Creazione del nodo value che contiene il valore del numero di telefono del practitioner
        $value = $dom->createElement('value');
        $value->setAttribute('value', $data_xml["practitioner"]->getPhone());
        $value = $telecom->appendChild($value);
        //Creazione del nodo use che indica la tipologia di numero di telefono
        $use = $dom->createElement('use');
        $use->setAttribute('value', 'mobile');
        $use = $telecom->appendChild($use);
        
        
        //Creazione del nodo telecom con il contatto mail del practitioner
        $telecom = $dom->createElement('telecom');
        $telecom = $practitioner->appendChild($telecom);
        //Creazione del nodo system che indica che il contatto è un valore telefonico
        $system = $dom->createElement('system');
        $system->setAttribute('value', 'email');
        $system = $telecom->appendChild($system);
        //Creazione del nodo value che contiene il valore del numero di telefono del practitioner
        $value = $dom->createElement('value');
        $value->setAttribute('value', $data_xml["practitioner"]->getMail());
        $value = $telecom->appendChild($value);
        //Creazione del nodo use che indica la tipologia di numero di telefono
        $use = $dom->createElement('use');
        $use->setAttribute('value', 'home');
        $use = $telecom->appendChild($use);
        
        
        
        //Creazione del nodo address per i dati relativi al recapito del paziente
        $address = $dom->createElement('address');
        $address = $practitioner->appendChild($address);
        //Creazione del nodo use che indica che il recapito è relativo alla casa di residenza
        $use = $dom->createElement('use');
        $use->setAttribute('value', 'home');
        $use = $address->appendChild($use);
        //Creazione del nodo line che indica l'indirizzo di residenza
        $line = $dom->createElement('line');
        $line->setAttribute('value', $data_xml["practitioner"]->getLine());
        $line = $address->appendChild($line);
        //Creazione del nodo city che indica la città di residenza
        $city = $dom->createElement('city');
        $city->setAttribute('value', $data_xml["practitioner"]->getCity());
        $city = $address->appendChild($city);
        //Creazione del nodo country che indica lo stato di residenza
        $country = $dom->createElement('state');
        $country->setAttribute('value', $data_xml["practitioner"]->getCountryName());
        $country = $address->appendChild($country);
        //Creazione del nodo postalCode che indica il codice postale di residenza
        $postalCode = $dom->createElement('postalCode');
        $postalCode->setAttribute('value', $data_xml["practitioner"]->getPostalCode());
        $postalCode = $address->appendChild($postalCode);
        

        
        //Creazione del nodo gender per il sesso del practitioner
        $gender = $dom->createElement('gender');
        $gender->setAttribute('value', $data_xml["practitioner"]->getGender());
        $gender = $practitioner->appendChild($gender);
        
        //Creazione del nodo birthdate con la data di nascita del practitioner
        $birthDate = $dom->createElement('birthDate');
        $birthDate->setAttribute('value', $data_xml["practitioner"]->getBirth());
        $birthDate = $practitioner->appendChild($birthDate);
        
        
        //Practitioner.Qualifications
        foreach($data_xml["practitioner_qualifiations"] as $pq){
            //Creazione del nodo qualification
            $qualification = $dom->createElement('qualification');
            $qualification = $practitioner->appendChild($qualification);
            //Creazione del nodo code
            $codeQ = $dom->createElement('code');
            $codeQ = $qualification->appendChild($codeQ);
            //Creazione del nodo coding
            $coding = $dom->createElement('coding');
            $coding = $codeQ->appendChild($coding);
            //Creazione del nodo system
            $system = $dom->createElement('system');
            $system->setAttribute('value', 'http://hl7.org/fhir/v2/0360/2.7');
            $system = $coding->appendChild($system);
            //Creazione del nodo code
            $code = $dom->createElement('code');
            $code->setAttribute('value', $pq->getCode());
            $code = $coding->appendChild($code);
            //Creazione del nodo display
            $display = $dom->createElement('display');
            $display->setAttribute('value', $pq->getQualificationDisplay());
            $display = $coding->appendChild($display);
            //Creazione del nodo text
            $text = $dom->createElement('text');
            $text->setAttribute('value', $pq->getQualificationDisplay());
            $text = $codeQ->appendChild($text);
            //Creazione del nodo period
            $period = $dom->createElement('period');
            $period = $qualification->appendChild($period);
            //Creazione del nodo start
            $start = $dom->createElement('start');
            $start->setAttribute('value', $pq->getStartPeriod());
            $start = $period->appendChild($start);
            //Creazione del nodo end
            $end = $dom->createElement('end');
            $end->setAttribute('value', $pq->getEndPeriod());
            $end = $period->appendChild($end);
            //Creazione del nodo issuer
            $issuer = $dom->createElement('issuer');
            $issuer = $qualification->appendChild($issuer);
            //Creazione del nodo display
            $display = $dom->createElement('display');
            $display->setAttribute('value', $pq->getIssuer());
            $display = $issuer->appendChild($display);
        }
        
        
        //Creazione del nodo communication per indicare la lingua di comunicazione del practitioner
        $communication = $dom->createElement('communication');
        $communication = $practitioner->appendChild($communication);
        //Creazione del nodo coding
        $coding = $dom->createElement('coding');
        $coding = $communication->appendChild($coding);
        //Creazione del nodo system in cui si indica il value set dell' IETF
        $system = $dom->createElement('system');
        $system->setAttribute('value', 'urn:ietf:bcp:47');
        $system = $coding->appendChild($system);
        //Creazione del nodo code che indica il codice della lingua parlata, in questo caso l'italiano perche tutti i pazienti del FSEM usano l'italiano
        $code = $dom->createElement('code');
        $code->setAttribute('value', $data_xml["practitioner"]->getCodeLanguage());
        $code = $coding->appendChild($code);
        //Creazione del nodo code che indica il display
        $display = $dom->createElement('display');
        $display->setAttribute('value', $data_xml["practitioner"]->getLanguage());
        $display = $coding->appendChild($display);
        
        
        //Elimino gli spazi bianchi superflui per la viasualizzazione grafica dell'XML
        $dom->preserveWhiteSpace = false;
        //Formatto il documento per l'output
        $dom->formatOutput = true;
        $path = getcwd()."\\resources\\Patient\\";
        //Salvo il documento XML nella cartella rsources dando come nome, l'id del paziente
        $dom->save($path."RESP-PRACTITIONER-".$data_xml["narrative"]["Id"].".xml");
        return $dom->saveXML();
        
    }
}

?>