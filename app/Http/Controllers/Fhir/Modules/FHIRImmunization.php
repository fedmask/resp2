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
        
        $data_xml["narrative"] = $values_in_narrative;
        $data_xml["providers"] = $providers;
        $data_xml["vaccinazione"] = $vaccinazione;
        
        return view("pages.fhir.immunization", [
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
}