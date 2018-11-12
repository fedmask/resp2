<?php
namespace App\Http\Controllers\Fhir\Modules;

use App\Exceptions\FHIR as FHIR;
use App\Models\InvestigationCenter\CentriIndagini;
use App\Models\InvestigationCenter\Indagini;
use App\Models\Icd9\Icd9EsamiStrumentiCodici;
use Illuminate\Http\Request;
use View;
use Illuminate\Filesystem\Filesystem;
use File;
use Orchestra\Parser\Xml\Facade as XmlParser;
use Exception;
use DB;
use Redirect;
use Response;
use SimpleXMLElement;
use DOMDocument;
use Input;
use App\Models\CareProviders\CareProvider;
use DateTime;
use DateTimeZone;
use Date;
use Carbon\Carbon;
use App\Models\Vaccine\Vaccinazione;
use App\Models\FHIR\ImmunizationProvider;

class FHIRImmunization
{

    public function show($id)
    {
        $vaccinazione = Vaccinazione::where('id_vaccinazione', $id)->first();
        
        if (! $vaccinazione) {
            throw new FHIR\IdNotFoundInDatabaseException("resource with the id provided doesn't exist in database");
        }
        
        $values_in_narrative = array(
            "Identifier" => "RESP-IMMUNIZATION" . "-" . $vaccinazione->getId(),
            "Status" => $vaccinazione->getStato(),
            "VaccineCode" => $vaccinazione->getVaccineCodeDisplay(),
            "Patient" => $vaccinazione->getPaziente(),
            "Date" => $vaccinazione->getData(),
            "Route" => $vaccinazione->getRouteDisplay(),
            "DoseQuantity" => $vaccinazione->getQuantity() . " mg",
            "Note" => $vaccinazione->getNote()
        );
        
        $providers = $vaccinazione->getProviders();
        
        $i = 0;
        foreach ($providers as $p) {
            $i ++;
            $values_in_narrative["Practitioner" . "" . $i] = CareProvider::where('id_cpp', $p->id_cpp)->first()->getFullName();
        }
        
        
        $narrative_extensions = array(
            "Confidenzialita" => $vaccinazione->getConfidenzialita()
        );
        
        
        $data_xml["extensions"] = $narrative_extensions;
        $data_xml["narrative"] = $values_in_narrative;
        $data_xml["providers"] = $providers;
        $data_xml["vaccinazione"] = $vaccinazione;
        
        return view("pages.fhir.Immunization.immunization", [
            "data_output" => $data_xml
        ]);
    }

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
        
        $vaccinazioni = Vaccinazione::all();
        
        foreach ($vaccinazioni as $v) {
            if ($v->id_vaccinazione == $id['identifier']) {
                throw new Exception("Immunization is already exists");
            }
        }
        
        $lettura = $xml->parse([
            'identifier' => [
                'uses' => 'identifier.value::value'
            ],
            'status' => [
                'uses' => 'status::value'
            ],
            'notGiven' => [
                'uses' => 'notGiven::value'
            ],
            'vaccineCode' => [
                'uses' => 'vaccineCode.coding.code::value'
            ],
            'patient' => [
                'uses' => 'patient.reference::value'
            ],
            'date' => [
                'uses' => 'date::value'
            ],
            'primarySource' => [
                'uses' => 'primarySource::value'
            ],
            'route' => [
                'uses' => 'route.coding.code::value'
            ],
            'doseQuantity' => [
                'uses' => 'doseQuantity.value::value'
            ],
            'practitioner' => [
                'uses' => 'practitioner[actor.reference::value>attr]' // cpp
            ],
            'practitionerRole' => [
                'uses' => 'practitioner[role.coding.code::value>attr]' // cpp
            ],
            'note' => [
                'uses' => 'note.text::value'
            ]
        
        ]);
        
        $vaccinazione = array(
            'id_vaccinazione' => $lettura['identifier'],
            'id_paziente' => $id_paziente,
            'vaccineCode' => $lettura['vaccineCode'],
            'vaccinazione_confidenzialita' => '3',
            'vaccinazione_data' => $lettura['date'],
            'vaccinazione_aggiornamento' => $lettura['date'],
            'vaccinazione_stato' => $lettura['status'],
            'vaccinazione_quantity' => $lettura['doseQuantity'],
            'vaccinazione_route' => $lettura['route'],
            'vaccinazione_note' => $lettura['note']
        );
        
        if ($lettura['notGiven'] == "true") {
            $vaccinazione['vaccinazione_notGiven'] = '0';
        } else {
            $vaccinazione['vaccinazione_notGiven'] = '1';
        }
        
        if ($lettura['primarySource'] == "true") {
            $vaccinazione['vaccinazione_primarySource'] = '0';
        } else {
            $vaccinazione['vaccinazione_primarySource'] = '1';
        }
        
        $addVaccinazione = new Vaccinazione();
        
        foreach ($vaccinazione as $key => $value) {
            if (empty($value)) {
                continue;
            }
            $addVaccinazione->$key = $value;
        }
        
        $addVaccinazione->save();
        
        $providers = array();
        if (! is_null($lettura['practitioner'])) {
            
            foreach ($lettura['practitioner'] as $c) {
                array_push($providers, $c['attr']);
            }
            // estraggo gli id dei providers
            $id_cpp = array();
            foreach ($providers as $p) {
                $expl = explode("-", $p);
                array_push($id_cpp, $expl[2]);
            }
            // controllo se i providers sono presenti nel sistema
            $cpp = CareProvider::all();
            foreach ($id_cpp as $id) {
                if (! CareProvider::find($id)) {
                    throw new Exception("Providers not exists");
                }
            }
            
            $providersRole = array();
            foreach ($lettura['practitionerRole'] as $r) {
                array_push($providersRole, $r['attr']);
            }
            
            $arrayProv = array();
            $i = 0;
            foreach ($id_cpp as $p) {
                $immProv = array(
                    'id_vaccinazione' => $lettura['identifier'],
                    'id_cpp' => $id_cpp[$i],
                    'role' => $providersRole[$i]
                );
                array_push($arrayProv, $immProv);
                $i ++;
            }
            
            $addImmProv = new ImmunizationProvider();
            foreach ($arrayProv as $p) {
                $addImmProv = new ImmunizationProvider();
                foreach ($p as $key => $value) {
                    if (empty($value)) {
                        continue;
                    }
                    $addImmProv->$key = $value;
                }
                $addImmProv->save();
            }
        }
        
        return response()->json($lettura['identifier'], 201);
    }

    public function update(Request $request, $id)
    {
        $file = $request->file('fileUpdate');
        $id_paziente = Input::get('patient_id');
        
        $xml = XmlParser::load($file->getRealPath());
        
        $id_vacc = $xml->parse([
            'identifier' => [
                'uses' => 'identifier.value::value'
            ]
        ]);
        
        if ($id != $id_vacc['identifier']) {
            throw new Exception("ERROR");
        }
        
        if (! Vaccinazione::find($id_vacc['identifier'])) {
            throw new Exception("Observation does not exist in the database");
        }
        
        $lettura = $xml->parse([
            'identifier' => [
                'uses' => 'identifier.value::value'
            ],
            'status' => [
                'uses' => 'status::value'
            ],
            'notGiven' => [
                'uses' => 'notGiven::value'
            ],
            'vaccineCode' => [
                'uses' => 'vaccineCode.coding.code::value'
            ],
            'patient' => [
                'uses' => 'patient.reference::value'
            ],
            'date' => [
                'uses' => 'date::value'
            ],
            'primarySource' => [
                'uses' => 'primarySource::value'
            ],
            
            'route' => [
                'uses' => 'route.coding.code::value'
            ],
            'doseQuantity' => [
                'uses' => 'doseQuantity.value::value'
            ],
            'practitioner' => [
                'uses' => 'practitioner[actor.reference::value>attr]' // cpp
            ],
            'practitionerRole' => [
                'uses' => 'practitioner[role.coding.code::value>attr]' // cpp
            ],
            'note' => [
                'uses' => 'note.text::value'
            ]
        
        ]);
        
        $vaccinazione = array(
            'id_paziente' => $id_paziente,
            'vaccineCode' => $lettura['vaccineCode'],
            'vaccinazione_confidenzialita' => '3',
            'vaccinazione_data' => $lettura['date'],
            'vaccinazione_aggiornamento' => $lettura['date'],
            'vaccinazione_stato' => $lettura['status'],
            'vaccinazione_quantity' => $lettura['doseQuantity'],
            'vaccinazione_route' => $lettura['route'],
            'vaccinazione_note' => $lettura['note']
        );
        
        if ($lettura['notGiven'] == "true") {
            $vaccinazione['vaccinazione_notGiven'] = '0';
        } else {
            $vaccinazione['vaccinazione_notGiven'] = '1';
        }
        
        if ($lettura['primarySource'] == "true") {
            $vaccinazione['vaccinazione_primarySource'] = '0';
        } else {
            $vaccinazione['vaccinazione_primarySource'] = '1';
        }
        
        $updVacc = Vaccinazione::find($id_vacc['identifier']);
        
        foreach ($vaccinazione as $key => $value) {
            if (empty($value)) {
                continue;
            }
            $updVacc->$key = $value;
        }
        
        $updVacc->save();
        
        $providers = array();
        if (! is_null($lettura['practitioner'])) {
            
            foreach ($lettura['practitioner'] as $c) {
                array_push($providers, $c['attr']);
            }
            // estraggo gli id dei providers
            $id_cpp = array();
            foreach ($providers as $p) {
                $expl = explode("-", $p);
                array_push($id_cpp, $expl[2]);
            }
            // controllo se i providers sono presenti nel sistema
            $cpp = CareProvider::all();
            foreach ($id_cpp as $id) {
                if (! CareProvider::find($id)) {
                    throw new Exception("Providers not exists");
                }
            }
            
            $providersRole = array();
            foreach ($lettura['practitionerRole'] as $r) {
                array_push($providersRole, $r['attr']);
            }
            
            $arrayProv = array();
            $i = 0;
            foreach ($id_cpp as $p) {
                $immProv = array(
                    'id_vaccinazione' => $lettura['identifier'],
                    'id_cpp' => $id_cpp[$i],
                    'role' => $providersRole[$i]
                );
                array_push($arrayProv, $immProv);
                $i ++;
            }
            
            $updImmProv = ImmunizationProvider::find($id_vacc['identifier'])->delete();
            
            $addImmProv = new ImmunizationProvider();
            foreach ($arrayProv as $p) {
                $addImmProv = new ImmunizationProvider();
                foreach ($p as $key => $value) {
                    if (empty($value)) {
                        continue;
                    }
                    $addImmProv->$key = $value;
                }
                $addImmProv->save();
            }
        }
        
        return response()->json($id_vacc['identifier'], 200);
    }
    
    
    function destroy($id)
    {
    
        ImmunizationProvider::find($id)->delete();
        
        Vaccinazione::find($id)->delete();
        
        return response()->json(null, 204);
       
    }
    

    public static function getResource($id)
    {
        $vaccinazione = Vaccinazione::where('id_vaccinazione', $id)->first();
        
        if (! $vaccinazione) {
            throw new FHIR\IdNotFoundInDatabaseException("resource with the id provided doesn't exist in database");
        }
        
        $values_in_narrative = array(
            "Id" => $vaccinazione->getId(),
            "Identifier" => "RESP-IMMUNIZATION" . "-" . $vaccinazione->getId(),
            "Status" => $vaccinazione->getStato(),
            "VaccineCode" => $vaccinazione->getVaccineCodeDisplay(),
            "Patient" => $vaccinazione->getPaziente(),
            "Date" => $vaccinazione->getData(),
            "Route" => $vaccinazione->getRouteDisplay(),
            "DoseQuantity" => $vaccinazione->getQuantity() . " mg",
            "Note" => $vaccinazione->getNote()
        );
        
        $providers = $vaccinazione->getProviders();
        $narrative_providers = array();
        $i = 0;
        foreach ($providers as $p) {
            $i ++;
            $narrative_providers["Practitioner" . "" . $i] = CareProvider::where('id_cpp', $p->id_cpp)->first()->getFullName();
        }
        
        $narrative_extensions = array(
            "Confidenzialita" => $vaccinazione->getConfidenzialita()
        );
        
        
        $data_xml["extensions"] = $narrative_extensions;
        $data_xml["narrative"] = $values_in_narrative;
        $data_xml["narrative_providers"] = $narrative_providers;
        $data_xml["providers"] = $providers;
        $data_xml["vaccinazione"] = $vaccinazione;
        
        self::xml($data_xml);
    }

    public static function xml($data_xml)
    {
        // Creazione di un oggetto dom con la codifica UTF-8
        $dom = new DOMDocument('1.0', 'utf-8');
        
        // Creazione del nodo Patient, cioè il nodo Root della risorsa
        $imm = $dom->createElement('Immunization');
        // Valorizzo il namespace della risorsa e del documento XML, in questo caso la specifica FHIR
        $imm->setAttribute('xmlns', 'http://hl7.org/fhir');
        // Corrello l'elemento con il nodo superiore
        $imm = $dom->appendChild($imm);
        
        // Creazione del nodo ID sempre presente nelle risorse FHIR
        $id = $dom->createElement('id');
        // Il valore dell'ID è il valore dell'ID nella relativa tabella del DB
        $id->setAttribute('value', $data_xml["narrative"]["Id"]);
        $id = $imm->appendChild($id);
        
        // Creazione della parte narrativa in XHTML e composta da tag HTML visualizzabili se aperto il file XML in un Browser
        $narrative = $dom->createElement('text');
        // Corrello l'elemento con il nodo superiore
        $narrative = $imm->appendChild($narrative);
        
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
        
        
        //Narrative
        foreach($data_xml["narrative"] as $key => $value){
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
        
        
        //Narrative.Providers
        foreach ($data_xml["narrative_providers"] as $key => $value) {
            $tr = $dom->createElement('tr');
            $tr = $tbody->appendChild($tr);
            
            // Creazione della colonna BirthDate
            $td = $dom->createElement('td', $key);
            $td = $tr->appendChild($td);
            
            // Creazione della colonna con il valore di nome e cognome del paziente
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
        
        
        
        //EXTENSIONS
        //Reason
        $extension1 = $dom->createElement('extension');
        $extension1->setAttribute('url', 'http://resp.local/resources/extensions/Immunization/immunization-confidenzialita.xml');
        $extension1 = $imm->appendChild($extension1);
        
        $valueInteger = $dom->createElement('valueInteger');
        $valueInteger->setAttribute('value', $data_xml["extensions"]['Confidenzialita']);
        $valueInteger = $extension1->appendChild($valueInteger);
        
        //END EXTENSIONS
        
        
        
        // Creazione del nodo identifier identificativo della risorsa Patient attraverso URI della risorsa
        $identifier = $dom->createElement('identifier');
        $identifier = $imm->appendChild($identifier);
        // Creazione del nodo use con valore fisso ad usual
        // Creazione del nodo system che identifica il namespace degli URI per identificare la risorsa
        $system = $dom->createElement('system');
        $system->setAttribute('value', 'http://resp.local'); // RFC gestione URI
        $system = $identifier->appendChild($system);
        // Creazione del nodo value
        $value = $dom->createElement('value');
        // Do il valore all' URI della risorsa
        $value->setAttribute('value', $data_xml["narrative"]["Id"]);
        $value = $identifier->appendChild($value);
        
        $status = $dom->createElement('status');
        $status->setAttribute('value', $data_xml["vaccinazione"]->getStato());
        $status = $imm->appendChild($status);
        
        // Creazione del nodo active settato a true in quanto la risorsa è attiva per il FSEM
        $notGiven = $dom->createElement('notGiven');
        $notGiven->setAttribute('value', $data_xml["vaccinazione"]->getNotGiven());
        $notGiven = $imm->appendChild($notGiven);
        
        // creazione del nodo patient
        $vaccineCode = $dom->createElement('vaccineCode');
        $vaccineCode = $imm->appendChild($vaccineCode);
        
        $coding = $dom->createElement('coding');
        $coding = $vaccineCode->appendChild($coding);
        
        $system = $dom->createElement('system');
        $system->setAttribute('value', 'urn:oid:1.2.36.1.2001.1005.17');
        $system = $coding->appendChild($system);
        
        $code = $dom->createElement('code');
        $code->setAttribute('value', $data_xml["vaccinazione"]->getVaccineCode());
        $code = $coding->appendChild($code);
        
        $text = $dom->createElement('text');
        $text->setAttribute('value', $data_xml["vaccinazione"]->getVaccineCodeDisplay());
        $text = $vaccineCode->appendChild($text);
        
        $patient = $dom->createElement('patient');
        $patient = $imm->appendChild($patient);
        
        $reference = $dom->createElement('reference');
        $reference->setAttribute('value', "RESP-PATIENT-" . $data_xml["vaccinazione"]->getIdPaziente());
        $reference = $patient->appendChild($reference);
        
        $date = $dom->createElement('date');
        $date->setAttribute('value', $data_xml["vaccinazione"]->getData());
        $date = $imm->appendChild($date);
        
        $primarySource = $dom->createElement('primarySource');
        $primarySource->setAttribute('value', $data_xml["vaccinazione"]->getPrimarySource());
        $primarySource = $imm->appendChild($primarySource);
        
        $route = $dom->createElement('route');
        $route = $imm->appendChild($route);
        
        $coding = $dom->createElement('coding');
        $coding = $route->appendChild($coding);
        
        $system = $dom->createElement('system');
        $system->setAttribute('value', 'http://hl7.org/fhir/v3/RouteOfAdministration');
        $system = $coding->appendChild($system);
        
        $code = $dom->createElement('code');
        $code->setAttribute('value', $data_xml["vaccinazione"]->getRoute());
        $code = $coding->appendChild($code);
        
        $display = $dom->createElement('display');
        $display->setAttribute('value', $data_xml["vaccinazione"]->getRouteDisplay());
        $display = $coding->appendChild($display);
        
        $doseQuantity = $dom->createElement('doseQuantity');
        $doseQuantity = $imm->appendChild($doseQuantity);
        
        $value = $dom->createElement('value');
        $value->setAttribute('value', $data_xml["vaccinazione"]->getQuantity());
        $value = $doseQuantity->appendChild($value);
        
        $system = $dom->createElement('system');
        $system->setAttribute('value', 'http://unitsofmeasure.org');
        $system = $doseQuantity->appendChild($system);
        
        $code = $dom->createElement('code');
        $code->setAttribute('value', 'mg');
        $code = $doseQuantity->appendChild($code);
        
        foreach ($data_xml["providers"] as $p) {
            
            $practitioner = $dom->createElement('practitioner');
            $practitioner = $imm->appendChild($practitioner);
            
            $role = $dom->createElement('role');
            $role = $practitioner->appendChild($role);
            
            $coding = $dom->createElement('coding');
            $coding = $role->appendChild($coding);
            
            $system = $dom->createElement('system');
            $system->setAttribute('value', 'http://hl7.org/fhir/v2/0443');
            $system = $coding->appendChild($system);
            
            $code = $dom->createElement('code');
            $code->setAttribute('value', $p->role);
            $code = $coding->appendChild($code);
            
            $actor = $dom->createElement('actor');
            $actor = $practitioner->appendChild($actor);
            
            $reference = $dom->createElement('reference');
            $reference->setAttribute('value', "RESP-PATIENT-" . $p->id_cpp);
            $reference = $actor->appendChild($reference);
        }
        
        // Elimino gli spazi bianchi superflui per la viasualizzazione grafica dell'XML
        $dom->preserveWhiteSpace = false;
        // Formatto il documento per l'output
        $dom->formatOutput = true;
        $path = getcwd() . "\\resources\\Patient\\";
        // Salvo il documento XML nella cartella rsources dando come nome, l'id del paziente
        $dom->save($path . "RESP-IMMUNIZATION-" . $data_xml["narrative"]["Id"] . ".xml");
        
        return $dom->saveXML();
    }
}