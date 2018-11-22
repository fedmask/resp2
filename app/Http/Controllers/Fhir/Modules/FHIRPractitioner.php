<?php
namespace App\Http\Controllers\Fhir\Modules;

use App\Http\Controllers\Fhir\Modules\FHIRResource;
use App\Models\CareProviders\CareProvider;
use App\Models\CareProviders\CppPaziente;
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
use App\Models\Patient\Pazienti;
use Auth;
use Input;
use App\Exceptions\FHIRExceptions\ExtensionException;
use App\Exceptions\FHIRExceptions\NameException;
use App\Exceptions\FHIRExceptions\IdFoundException;
use App\Exceptions\FHIRExceptions\IdNotFoundException;
use App\Exceptions\FHIRExceptions\IdNotEqualsException;
use App\Exceptions\FHIRExceptions\ValidateException;
use App\Exceptions\FHIRExceptions\AttributeException;
use App\Http\Controllers\Fhir\OperationOutcome;
use App\Exceptions\FHIRExceptions\ResourceExistException;
use Storage;
use App\Exceptions\FHIRExceptions\ResourceNotExistException;
// Costanti per il controllo di un file caricato
define("EXTENSION", "xml");
define("NAME", "Practitioner");

// Fine
class FHIRPractitioner
{

    /**
     * Funzione che permette di visualizzare i dettagli della risorsa e di esportarla
     */
    public function show($id)
    {
        try {
            // Recupero i dati del paziente
            $practictioner = CareProvider::where('id_cpp', $id)->first();
            
            if (! $practictioner) {
                throw new IdNotFoundException("resource with the id provided doesn't exist in database");
            }
            
            // Recupero le qualifiche del practictioner
            $practictioner_qualifiations = CppQualification::where('id_cpp', $id)->get();
            
            // Sono i valori che verranno riportati nella parte descrittiva del documento
            $values_in_narrative = array(
                "Identifier" => "RESP-PRACTICTIONER" . "-" . $practictioner->getIdCpp(),
                "Active" => $practictioner->isActive(),
                "Name" => $practictioner->getName(),
                "Surname" => $practictioner->getSurname(),
                "Telephone" => $practictioner->getPhone(),
                "Mail" => $practictioner->getMail(),
                "Gender" => $practictioner->getGender(),
                "BirthDate" => $practictioner->getBirth(),
                "Address" => $practictioner->getAddress(),
                "Language" => $practictioner->getLanguage()
            
            );
            
            // Practictioner.Qualification
            $narrative_practictioner_qualifications = array();
            $count = 0;
            foreach ($practictioner->getFHIRQualifications() as $pq) {
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
            
            $array = array();
            $array = $values_in_narrative;
            $values_in_narrative = array();
            
            foreach ($array as $key => $value) {
                if (empty($value)) {
                    continue;
                }
                $values_in_narrative[$key] = $value;
            }
            
            $array = $narrative_practictioner_qualifications;
            $narrative_practictioner_qualifications = array();
            
            foreach ($array as $key => $value) {
                if (empty($value)) {
                    continue;
                }
                $narrative_practictioner_qualifications[$key] = $value;
            }
            
            $array = $custom_extensions;
            $custom_extensions = array();
            
            foreach ($array as $key => $value) {
                if (empty($value)) {
                    continue;
                }
                $custom_extensions[$key] = $value;
            }
            
            $data_xml["narrative"] = $values_in_narrative;
            $data_xml["narrative_practictioner_qualifications"] = $narrative_practictioner_qualifications;
            $data_xml["extensions"] = $custom_extensions;
            $data_xml["practictioner"] = $practictioner;
            $data_xml["practictioner_qualifiations"] = $practictioner_qualifiations;
            
            return view("pages.fhir.Practitioner.practictioner", [
                "data_output" => $data_xml
            ]);
        } catch (IdNotFoundException $e) {
            OperationOutcome::display_raw(OperationOutcome::getXML($e->getMessage()));
        }
    }

    public function pathGen($storage)
    {
        $path = public_path($storage);
        $ret = str_replace("/", "\\", $path);
        return $ret;
    }

    public function FHIRValidator($pathJar, $pathFile, $pathZip, $pathOutput)
    {
        $jar = $this->pathGen($pathJar);
        $file = $this->pathGen($pathFile);
        $zip = $this->pathGen($pathZip);
        $output = $this->pathGen($pathOutput);
        
        $command = "java -jar " . $jar . " " . $file . " -defn " . $zip . " -output " . $output;
        shell_exec($command);
        // print_r($command);
    }

    /**
     * Funzione per l'inserimento di una nuova risorsa nel sistema
     */
    public function store(Request $request)
    {
        $file = $request->file('file');
        $id_paziente = Input::get('patient_id');
        
        $xml = XmlParser::load($file->getRealPath());
        
        $id = $xml->parse([
            'identifier' => [
                'uses' => 'identifier.value::value'
            ]
        ]);
        
        // Salvo il file caricato dal paziente
        $request->file('file')->storeAs('Administrator', "AddPractitioner" . $id['identifier'] . ".xml", 'public_uploads');
        
        $filename = $this->pathGen('uploads/Administrator/AddPractitioner' . $id['identifier'] . ".xml");
        
        try {
            // ottengo il nome del file compreso di espansione (file.xml)
            $name = $_FILES['file']['name'];
            $explode = explode(".", $name);
            $extension = $explode[1];
            
            // controllo se il file è .xml
            if ($extension != EXTENSION) {
                unlink($filename);
                throw new ExtensionException("ERROR");
            }
            
            // ottengo il nome del nodo principale (Practitioner)
            $xmlfile = file_get_contents($file);
            $sxe = new SimpleXMLElement($xmlfile);
            $name = $sxe->getName();
            
            // controllo se il file contiente una risorsa Practitioner
            if ($name != NAME) {
                unlink($filename);
                throw new NameException("ERROR");
            }
            
            // Recupero gli elementi necessari a creare il comando da passare alla shell
            $pathJar = 'FHIR-VALIDATOR/validator.jar';
            $pathFile = 'uploads/Administrator/AddPractitioner' . $id['identifier'] . ".xml";
            $pathZip = 'FHIR-VALIDATOR/definitions.xml.zip';
            $pathOutput = 'FHIR-VALIDATOR/validation.xml';
            
            // passo il comando alla shell per eseguire la validazione
            $this->FHIRValidator($pathJar, $pathFile, $pathZip, $pathOutput);
            
            $f = public_path('FHIR-VALIDATOR/validation.xml');
            $f = str_replace("/", "\\", $f);
            
            $xmlfile = file_get_contents($f);
            $ob = simplexml_load_string($xmlfile);
            $json = json_encode($ob);
            $configData = json_decode($json, true);
            
            $s = $configData['text']['div'];
            
            if (! array_key_exists('p', $s)) {
                unlink($filename);
                throw new ValidateException("Error: validation failed");
            }
            
            $xml = XmlParser::load($file->getRealPath());
            
            $id = $xml->parse([
                'identifier' => [
                    'uses' => 'identifier.value::value'
                ]
            ]);
            
            // controllo se è presente l'id all'interno del file
            if (empty($id['identifier'])) {
                unlink($filename);
                throw new IdNotFoundException("Error: Practitioner.identifier.value cannot be null");
            }
            
            // Controllo se il cpp è presente nel sistema. Se non è presente controllo che il file
            // contenga tutti i dati minimi e necessari all'inserimento di un nuovo cpp nel sistema
            // e lo inserisce
            if (! CareProvider::where('id_cpp', $id['identifier'])->first()) {
                
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
                        'uses' => 'telecom[system::value>sys,value::value>val]'
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
                
                // se la mail esiste nel file controllo che sia unica all'interno del database
                $telecom = array();
                foreach ($lettura['telecom'] as $tel) {
                    if ($tel['sys'] == 'phone') {
                        $telecom['phone'] = $tel['val'];
                    }
                    if ($tel['sys'] == 'email') {
                        $telecom['email'] = $tel['val'];
                    }
                }
                
                // Controllo gli attributi necessari per tbl_utenti
                if (array_key_exists('email', $telecom)) {
                    if (User::where('utente_email', $telecom['email'])->first()) {
                        throw new AttributeException("Error: duplicate mail");
                    }
                }
                
                // Controllo gli attributi necessari per tbl_recapiti
                if (empty($lettura['city'])) {
                    throw new AttributeException("Error: Practitioner.address.city cannot be null");
                }
                
                // Controllo gli attributi necessari per tbl_care_provider
                if (empty($lettura['name'])) {
                    throw new AttributeException("Error: Practitioner.name.given cannot be null");
                }
                if (empty($lettura['surname'])) {
                    throw new AttributeException("Error: Practitioner.name.family cannot be null");
                }
                if (empty($lettura['birthDate'])) {
                    throw new AttributeException("Error: Practitioner.birthDate cannot be null");
                }
                if (empty($lettura['gender'])) {
                    throw new AttributeException("Error: Practitioner.gender cannot be null");
                }
                if (empty($lettura['communication'])) {
                    throw new AttributeException("Error: Practitioner.communication.code cannot be null");
                }
                
                // Controllo gli attributi necessari per CppQualification
                foreach ($lettura['qualificationCode'] as $q) {
                    if (empty($q['attr'])) {
                        throw new AttributeException("Error: Practitioner.qualificatiom.code.coding.code cannot be null");
                    }
                }
                
                // USER
                
                $user = array();
                
                if (array_key_exists('email', $telecom)) {
                    $user['utente_email'] = $telecom['email'];
                } else {
                    $user['utente_email'] = "";
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
                
                if (array_key_exists('phone', $telecom)) {
                    $contact['contatto_telefono'] = $telecom['phone'];
                } else {
                    $contact['contatto_telefono'] = "";
                }
                
                foreach ($contact as $key => $value) {
                    if (empty($value)) {
                        continue;
                    }
                    
                    $addContact->$key = $value;
                }
                
                $addContact->save();
                
                // PRACTICTIONER
                
                $practitioner = array(
                    'id_cpp' => $id['identifier'],
                    'id_utente' => $utente->id_utente,
                    'cpp_nome' => $lettura['name'],
                    'cpp_cognome' => $lettura['surname'],
                    'cpp_sesso' => $lettura['gender'],
                    'cpp_nascita_data' => $lettura['birthDate'],
                    'active' => $lettura['active'],
                    'cpp_lingua' => $lettura['communication']
                );
                
                $addPractitioner = new CareProvider();
                
                foreach ($practitioner as $key => $value) {
                    if (empty($value)) {
                        continue;
                    }
                    $addPractitioner->$key = $value;
                }
                
                $addPractitioner->save();
                
                // PRACTICTIONER.QUALIFICATION
                
                $practQual = array();
                $cpp = CareProvider::all()->last();
                
                for ($i = 0; $i < count($lettura['qualificationCode']); $i ++) {
                    $practitionerQual = array(
                        'id_cpp' => $id['identifier'],
                        'Code' => $lettura['qualificationCode'][$i]['attr'],
                        'Start_Period' => $lettura['qualificationPeriodStart'][$i]['attr'],
                        'End_Period' => $lettura['qualificationPeriodEnd'][$i]['attr'],
                        'Issuer' => $lettura['qualificationIssuer'][$i]['attr']
                    );
                    array_push($practQual, $practitionerQual);
                }
                
                $addPractitionerQual = new CppQualification();
                $add = array();
                $praQual = array();
                
                foreach ($practQual as $pq) {
                    foreach ($pq as $key => $value) {
                        $add[$key] = $value;
                    }
                    array_push($praQual, $add);
                }
                
                foreach ($praQual as $a) {
                    $addPractitionerQual = new CppQualification();
                    foreach ($a as $key => $value) {
                        if (empty($value)) {
                            continue;
                        }
                        $addPractitionerQual->$key = $value;
                    }
                    $addPractitionerQual->save();
                }
                
                $cppPaz = array(
                    'id_cpp' => $id['identifier'],
                    'id_paziente' => $id_paziente,
                    'assegnazione_confidenzialita' => '1'
                );
                
                $addCppPaz = new CppPaziente();
                
                foreach ($cppPaz as $key => $value) {
                    if (empty($value)) {
                        continue;
                    }
                    $addCppPaz->$key = $value;
                }
                
                $addCppPaz->save();
                
                return response()->json($lettura['identifier'], 201);
            } else {
                // Se non è presente controllo se è stato già associato
                throw new ResourceExistException("Practitioner already exist and he is already associated");
            }
        } catch (ExtensionException $e) {
            OperationOutcome::display_raw(OperationOutcome::getXML($e->getMessage()));
        } catch (NameException $e) {
            OperationOutcome::display_raw(OperationOutcome::getXML($e->getMessage()));
        } catch (ValidateException $e) {
            return response()->download($f);
        } catch (IdNotFoundException $e) {
            OperationOutcome::display_raw(OperationOutcome::getXML($e->getMessage()));
        } catch (ResourceExistException $e) {
            OperationOutcome::display_raw(OperationOutcome::getXML($e->getMessage()));
        } catch (AttributeException $e) {
            OperationOutcome::display_raw(OperationOutcome::getXML($e->getMessage()));
        }
    }

    /**
     * Funzione per l'aggiornamento dei dati di una risorsa
     */
    public function update(Request $request, $id)
    {
        $file = $request->file('fileUpdate');
        $id_paziente = Input::get('patient_id');
        
        // Salvo il file caricato dal paziente
        $request->file('fileUpdate')->storeAs('Administrator', "UpdPractitioner" . $id . ".xml", 'public_uploads');
        
        $filename = $this->pathGen('uploads/Administrator/UpdPractitioner' . $id . ".xml");
        
        try {
            // ottengo il nome del file compreso di espansione (file.xml)
            $name = $_FILES['fileUpdate']['name'];
            $explode = explode(".", $name);
            $extension = $explode[1];
            
            // controllo se il file è .xml
            if ($extension != EXTENSION) {
                unlink($filename);
                throw new ExtensionException("Error: file extension not valid. Please select .xml file");
            }
            
            // ottengo il nome del nodo principale (Practitioner)
            $xmlfile = file_get_contents($file);
            $sxe = new SimpleXMLElement($xmlfile);
            $name = $sxe->getName();
            
            // controllo se il file contiente una risorsa Practitioner
            if ($name != NAME) {
                unlink($filename);
                throw new NameException("Error: type resource not valid. Please upload 'Practitioner' resource");
            }
            
            $xml = XmlParser::load($file->getRealPath());
            
            $id_cpp = $xml->parse([
                'identifier' => [
                    'uses' => 'identifier.value::value'
                ]
            ]);
            
            $cpp = CareProvider::all();
            
            // controllo se il cpp esiste nel sistema
            if (! CareProvider::find($id)) {
                throw new Exception("Practitioner does not exist in the database");
            }
            
            // controllo se l'id del file coincide con quello che si vuole aggiornare
            if ($id_cpp['identifier'] != $id) {
                unlink($filename);
                throw new IdNotEqualsException("Error: id_cpp and identifier not equals");
            }
            
            // Recupero gli elementi necessari a creare il comando da passare alla shell
            $pathJar = 'FHIR-VALIDATOR/validator.jar';
            $pathFile = 'uploads/Administrator/AddPractitioner' . $id . ".xml";
            $pathZip = 'FHIR-VALIDATOR/definitions.xml.zip';
            $pathOutput = 'FHIR-VALIDATOR/validation.xml';
            
            // passo il comando alla shell per eseguire la validazione
            $this->FHIRValidator($pathJar, $pathFile, $pathZip, $pathOutput);
            
            $f = public_path('FHIR-VALIDATOR/validation.xml');
            $f = str_replace("/", "\\", $f);
            
            $xmlfile = file_get_contents($f);
            $ob = simplexml_load_string($xmlfile);
            $json = json_encode($ob);
            $configData = json_decode($json, true);
            
            $s = $configData['text']['div'];
            
            if (! array_key_exists('p', $s)) {
                unlink($filename);
                throw new ValidateException();
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
        } catch (ExtensionException $e) {
            OperationOutcome::display_raw(OperationOutcome::getXML($e->getMessage()));
        } catch (NameException $e) {
            OperationOutcome::display_raw(OperationOutcome::getXML($e->getMessage()));
        } catch (IdNotEqualsException $e) {
            OperationOutcome::display_raw(OperationOutcome::getXML($e->getMessage()));
        } catch (ValidateException $e) {
            OperationOutcome::display_raw(OperationOutcome::getXML($e->getMessage()));
        }
    }

    /**
     * Funzione per l'eliminazione di una risorsa
     */
    function destroy($id)
    {
        $practitioner = CareProvider::find($id);
        
        try {
            
            if (! $practitioner->exists()) {
                throw new IdNotFoundException("resource with the id provided doesn't exist in database");
            }
            
            CareProvider::find($id)->delete();
            
            return response()->json(null, 204);
        } catch (IdNotFoundException $e) {
            OperationOutcome::display_raw(OperationOutcome::getXML($e->getMessage()));
        }
    }

    public static function getResource($id)
    {
        
        // Recupero i dati del paziente
        $practitioner = CareProvider::where('id_cpp', $id)->first();
        
        if (! $practitioner) {
            throw new FHIR\IdNotFoundInDatabaseException("resource with the id provided doesn't exist in database");
        }
        
        // Recupero le qualifiche del practictioner
        $practitioner_qualifiations = CppQualification::where('id_cpp', $id)->get();
        
        // Sono i valori che verranno riportati nella parte descrittiva del documento
        $values_in_narrative = array(
            "Id" => $practitioner->getIdCpp(),
            "Identifier" => "RESP-PRACTICTIONER" . "-" . $practitioner->getIdCpp(),
            "Active" => $practitioner->isActive(),
            "Name" => $practitioner->getName(),
            "Surname" => $practitioner->getSurname(),
            "Telephone" => $practitioner->getPhone(),
            "Mail" => $practitioner->getMail(),
            "Gender" => $practitioner->getGender(),
            "BirthDate" => $practitioner->getBirth(),
            "Address" => $practitioner->getAddress(),
            "Language" => $practitioner->getLanguage()
        
        );
        
        // Practictioner.Qualification
        $narrative_practitioner_qualifications = array();
        $count = 0;
        foreach ($practitioner->getFHIRQualifications() as $pq) {
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
        
        $array = array();
        $array = $values_in_narrative;
        $values_in_narrative = array();
        
        foreach ($array as $key => $value) {
            if (empty($value)) {
                continue;
            }
            $values_in_narrative[$key] = $value;
        }
        
        $array = $narrative_practitioner_qualifications;
        $narrative_practitioner_qualifications = array();
        
        foreach ($array as $key => $value) {
            if (empty($value)) {
                continue;
            }
            $narrative_practitioner_qualifications[$key] = $value;
        }
        
        $array = $custom_extensions;
        $custom_extensions = array();
        
        foreach ($array as $key => $value) {
            if (empty($value)) {
                continue;
            }
            $custom_extensions[$key] = $value;
        }
        
        $data_xml["narrative"] = $values_in_narrative;
        $data_xml["narrative_practitioner_qualifications"] = $narrative_practitioner_qualifications;
        $data_xml["extensions"] = $custom_extensions;
        $data_xml["practitioner"] = $practitioner;
        $data_xml["practitioner_qualifiations"] = $practitioner_qualifiations;
        
        self::xml($data_xml);
    }

    public static function xml($data_xml)
    {
        // Creazione di un oggetto dom con la codifica UTF-8
        $dom = new DOMDocument('1.0', 'utf-8');
        
        // Creazione del nodo Patient, cioè il nodo Root della risorsa
        $practitioner = $dom->createElement('Practitioner');
        // Valorizzo il namespace della risorsa e del documento XML, in questo caso la specifica FHIR
        $practitioner->setAttribute('xmlns', 'http://hl7.org/fhir');
        // Corrello l'elemento con il nodo superiore
        $practitioner = $dom->appendChild($practitioner);
        
        // Creazione del nodo ID sempre presente nelle risorse FHIR
        $id = $dom->createElement('id');
        // Il valore dell'ID è il valore dell'ID nella relativa tabella del DB
        $id->setAttribute('value', $data_xml["narrative"]["Id"]);
        $id = $practitioner->appendChild($id);
        
        // Creazione della parte narrativa in XHTML e composta da tag HTML visualizzabili se aperto il file XML in un Browser
        $narrative = $dom->createElement('text');
        // Corrello l'elemento con il nodo superiore
        $narrative = $practitioner->appendChild($narrative);
        
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
        
        // Narrative
        foreach ($data_xml["narrative"] as $key => $value) {
            // Creazione di una riga
            $tr = $dom->createElement('tr');
            $tr = $tbody->appendChild($tr);
            
            // Creazione della colonna Contact
            $td = $dom->createElement('td', $key);
            $td = $tr->appendChild($td);
            
            // Creazione della colonna con il valore di contact del practitioner
            $td = $dom->createElement('td', $value);
            $td = $tr->appendChild($td);
        }
        
        // Narrative Practitioner.Qualifications
        foreach ($data_xml["narrative_practitioner_qualifications"] as $key => $value) {
            // Creazione di una riga
            $tr = $dom->createElement('tr');
            $tr = $tbody->appendChild($tr);
            
            // Creazione della colonna Contact
            $td = $dom->createElement('td', $key);
            $td = $tr->appendChild($td);
            
            // Creazione della colonna con il valore di contact del practitioner
            $td = $dom->createElement('td', $value);
            $td = $tr->appendChild($td);
        }
        
        // EXTENSIONS IN NARRATIVE
        
        foreach ($data_xml["extensions"] as $key => $value) {
            // Creazione di una riga
            $tr = $dom->createElement('tr');
            $tr = $tbody->appendChild($tr);
            // Language
            $td = $dom->createElement('td', $key);
            $td = $tr->appendChild($td);
            $td = $dom->createElement('td', $value);
            $td = $tr->appendChild($td);
        }
        
        // END EXTENSIONS IN NARRATIVE
        
        // EXTENSIONS
        // comune
        if (array_key_exists("Comune", $data_xml["extensions"])) {
            $extension1 = $dom->createElement('extension');
            $extension1->setAttribute('url', 'http://resp.local/resources/extensions/Practictioner/practitioner-comune.xml');
            $extension1 = $practitioner->appendChild($extension1);
            
            $valueString1 = $dom->createElement('valueString');
            $valueString1->setAttribute('value', $data_xml["extensions"]['Comune']);
            $valueString1 = $extension1->appendChild($valueString1);
        }
        
        // id
        if (array_key_exists("Id_Utente", $data_xml["extensions"])) {
            $extension2 = $dom->createElement('extension');
            $extension2->setAttribute('url', 'http://resp.local/resources/extensions/Practictioner/cpp-persona-id.xml');
            $extension2 = $practitioner->appendChild($extension2);
            
            $valueString2 = $dom->createElement('valueString');
            $valueString2->setAttribute('value', $data_xml["extensions"]['Id_Utente']);
            $valueString2 = $extension2->appendChild($valueString2);
        }
        // END EXTENSIONS
        
        // Creazione del nodo identifier identificativo della risorsa Patient attraverso URI della risorsa
        $identifier = $dom->createElement('identifier');
        $identifier = $practitioner->appendChild($identifier);
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
        
        // Creazione del nodo active settato a true in quanto la risorsa è attiva per il FSEM
        $active = $dom->createElement('active');
        $active->setAttribute('value', $data_xml["narrative"]["Active"]);
        $active = $practitioner->appendChild($active);
        
        // Creazione del nodo per il nominativo del practitioner
        $name = $dom->createElement('name');
        $name = $practitioner->appendChild($name);
        // Creazione del nodo family che indica il nome dalla famiglia di provenienza, quindi il cognome del practitioner
        $family = $dom->createElement('family');
        $family->setAttribute('value', $data_xml["practitioner"]->getSurname());
        $family = $name->appendChild($family);
        // Creazione del nodo given che indica il nome di battesimo dato al practitioner
        $given = $dom->createElement('given');
        $given->setAttribute('value', $data_xml["practitioner"]->getName());
        $given = $name->appendChild($given);
        // Creazione del nodo prefix settato sempre al valore Dr
        $prefix = $dom->createElement('prefix');
        $prefix->setAttribute('value', 'Dr');
        $prefix = $name->appendChild($prefix);
        
        if (! empty($data_xml["practitioner"]->getPhone())) {
            // Creazione del nodo telecom con il contatto telefonico del practitioner
            $telecom = $dom->createElement('telecom');
            $telecom = $practitioner->appendChild($telecom);
            // Creazione del nodo system che indica che il contatto è un valore telefonico
            $system = $dom->createElement('system');
            $system->setAttribute('value', 'phone');
            $system = $telecom->appendChild($system);
            // Creazione del nodo value che contiene il valore del numero di telefono del practitioner
            $value = $dom->createElement('value');
            $value->setAttribute('value', $data_xml["practitioner"]->getPhone());
            $value = $telecom->appendChild($value);
            // Creazione del nodo use che indica la tipologia di numero di telefono
            $use = $dom->createElement('use');
            $use->setAttribute('value', 'mobile');
            $use = $telecom->appendChild($use);
        }
        
        // Creazione del nodo telecom con il contatto mail del practitioner
        if (! empty($data_xml["practitioner"]->getMail())) {
            $telecom = $dom->createElement('telecom');
            $telecom = $practitioner->appendChild($telecom);
            // Creazione del nodo system che indica che il contatto è un valore telefonico
            $system = $dom->createElement('system');
            $system->setAttribute('value', 'email');
            $system = $telecom->appendChild($system);
            // Creazione del nodo value che contiene il valore del numero di telefono del practitioner
            $value = $dom->createElement('value');
            $value->setAttribute('value', $data_xml["practitioner"]->getMail());
            $value = $telecom->appendChild($value);
            // Creazione del nodo use che indica la tipologia di numero di telefono
            $use = $dom->createElement('use');
            $use->setAttribute('value', 'home');
            $use = $telecom->appendChild($use);
        }
        
        // Creazione del nodo address per i dati relativi al recapito del paziente
        $address = $dom->createElement('address');
        $address = $practitioner->appendChild($address);
        // Creazione del nodo use che indica che il recapito è relativo alla casa di residenza
        $use = $dom->createElement('use');
        $use->setAttribute('value', 'home');
        $use = $address->appendChild($use);
        // Creazione del nodo line che indica l'indirizzo di residenza
        
        if (! empty($data_xml["practitioner"]->getLine())) {
            $line = $dom->createElement('line');
            $line->setAttribute('value', $data_xml["practitioner"]->getLine());
            $line = $address->appendChild($line);
        }
        // Creazione del nodo city che indica la città di residenza
        $city = $dom->createElement('city');
        $city->setAttribute('value', $data_xml["practitioner"]->getCity());
        $city = $address->appendChild($city);
        // Creazione del nodo country che indica lo stato di residenza
        $country = $dom->createElement('state');
        $country->setAttribute('value', $data_xml["practitioner"]->getCountryName());
        $country = $address->appendChild($country);
        // Creazione del nodo postalCode che indica il codice postale di residenza
        $postalCode = $dom->createElement('postalCode');
        $postalCode->setAttribute('value', $data_xml["practitioner"]->getPostalCode());
        $postalCode = $address->appendChild($postalCode);
        
        // Creazione del nodo gender per il sesso del practitioner
        $gender = $dom->createElement('gender');
        $gender->setAttribute('value', $data_xml["practitioner"]->getGender());
        $gender = $practitioner->appendChild($gender);
        
        // Creazione del nodo birthdate con la data di nascita del practitioner
        $birthDate = $dom->createElement('birthDate');
        $birthDate->setAttribute('value', $data_xml["practitioner"]->getBirth());
        $birthDate = $practitioner->appendChild($birthDate);
        
        // Practitioner.Qualifications
        foreach ($data_xml["practitioner_qualifiations"] as $pq) {
            // Creazione del nodo qualification
            $qualification = $dom->createElement('qualification');
            $qualification = $practitioner->appendChild($qualification);
            // Creazione del nodo code
            $codeQ = $dom->createElement('code');
            $codeQ = $qualification->appendChild($codeQ);
            // Creazione del nodo coding
            $coding = $dom->createElement('coding');
            $coding = $codeQ->appendChild($coding);
            // Creazione del nodo system
            $system = $dom->createElement('system');
            $system->setAttribute('value', 'http://hl7.org/fhir/v2/0360/2.7');
            $system = $coding->appendChild($system);
            // Creazione del nodo code
            $code = $dom->createElement('code');
            $code->setAttribute('value', $pq->getCode());
            $code = $coding->appendChild($code);
            // Creazione del nodo display
            $display = $dom->createElement('display');
            $display->setAttribute('value', $pq->getQualificationDisplay());
            $display = $coding->appendChild($display);
            // Creazione del nodo text
            $text = $dom->createElement('text');
            $text->setAttribute('value', $pq->getQualificationDisplay());
            $text = $codeQ->appendChild($text);
            
            // Creazione del nodo period
            if (! empty($pq->getStartPeriod()) && ! empty($pq->getEndPeriod())) {
                $period = $dom->createElement('period');
                $period = $qualification->appendChild($period);
                // Creazione del nodo start
                if (! empty($pq->getStartPeriod())) {
                    $start = $dom->createElement('start');
                    $start->setAttribute('value', $pq->getStartPeriod());
                    $start = $period->appendChild($start);
                }
                if (! empty($pq->getEndPeriod())) {
                    // Creazione del nodo end
                    $end = $dom->createElement('end');
                    $end->setAttribute('value', $pq->getEndPeriod());
                    $end = $period->appendChild($end);
                }
            }
            if (! empty($pq->getIssuer())) {
                // Creazione del nodo issuer
                $issuer = $dom->createElement('issuer');
                $issuer = $qualification->appendChild($issuer);
                // Creazione del nodo display
                $display = $dom->createElement('display');
                $display->setAttribute('value', $pq->getIssuer());
                $display = $issuer->appendChild($display);
            }
        }
        
        // Creazione del nodo communication per indicare la lingua di comunicazione del practitioner
        $communication = $dom->createElement('communication');
        $communication = $practitioner->appendChild($communication);
        // Creazione del nodo coding
        $coding = $dom->createElement('coding');
        $coding = $communication->appendChild($coding);
        // Creazione del nodo system in cui si indica il value set dell' IETF
        $system = $dom->createElement('system');
        $system->setAttribute('value', 'urn:ietf:bcp:47');
        $system = $coding->appendChild($system);
        // Creazione del nodo code che indica il codice della lingua parlata, in questo caso l'italiano perche tutti i pazienti del FSEM usano l'italiano
        $code = $dom->createElement('code');
        $code->setAttribute('value', $data_xml["practitioner"]->getCodeLanguage());
        $code = $coding->appendChild($code);
        // Creazione del nodo code che indica il display
        $display = $dom->createElement('display');
        $display->setAttribute('value', $data_xml["practitioner"]->getLanguage());
        $display = $coding->appendChild($display);
        
        // Elimino gli spazi bianchi superflui per la viasualizzazione grafica dell'XML
        $dom->preserveWhiteSpace = false;
        // Formatto il documento per l'output
        $dom->formatOutput = true;
        $path = getcwd() . "\\resources\\Patient\\";
        // Salvo il documento XML nella cartella rsources dando come nome, l'id del paziente
        $dom->save($path . "RESP-PRACTITIONER-" . $data_xml["narrative"]["Id"] . ".xml");
        return $dom->saveXML();
    }
}
