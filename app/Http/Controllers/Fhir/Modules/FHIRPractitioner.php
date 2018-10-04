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
    
}

?>