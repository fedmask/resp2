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
use App\Models\FHIR\Contatto;
use App\Models\Parente;
use App\Models\CodificheFHIR\RelationshipType;
use App\Models\Patient\PazientiFamiliarita;
use Input;

class FHIRRelatedPerson
{

    public function show($id)
    {
        $id = explode(",", $id);
        $tipo = $id[1];
        $id = $id[0];
        
        $relPers;
        $values_in_narrative;
        
        if ($tipo == "Contatto") {
            $relPers = new Contatto();
            $relPers = Contatto::where('id_contatto', $id)->first();
            
            if (! $relPers) {
                throw new FHIR\IdNotFoundInDatabaseException("resource with the id provided doesn't exist in database");
            }
            
            $values_in_narrative = array(
                "Identifier" => "RESP-RELATEDPERSON-EM" . "-" . $relPers->getId(),
                "Active" => $relPers->isActive(),
                "Patient" => "FHIR-PATIENT-" . $relPers->getIdPaziente(),
                "Relationship" => $relPers->getRelazione(),
                "Name" => $relPers->getFullName(),
                "Telecom" => $relPers->getTelecom(),
                "Gender" => $relPers->getSesso(),
                "BirthDate" => $relPers->getDataNascita()
            );
        } else {
            $relPers = new Parente();
            $relPers = Parente::where('id_parente', $id)->first();
            
            if (! $relPers) {
                throw new FHIR\IdNotFoundInDatabaseException("resource with the id provided doesn't exist in database");
            }
            
            $values_in_narrative = array(
                "Identifier" => "RESP-RELATEDPERSON-REL" . "-" . $relPers->getId(),
                "Active" => $relPers->isActive(),
                "Patient" => "FHIR-PATIENT-" . $relPers->getIdPaziente(),
                "Relationship" => $relPers->getRelazione(),
                "Name" => $relPers->getFullName(),
                "Telecom" => $relPers->getTelecom(),
                "Gender" => $relPers->getSesso(),
                "BirthDate" => $relPers->getDataNascita()
            );
        }
        
        $data_xml["narrative"] = $values_in_narrative;
        $data_xml["relPers"] = $relPers;
        
        return view("pages.fhir.relatedPerson", [
            "data_output" => $data_xml
        ]);
    }

    public function store(Request $request)
    {
        $file = $request->file('file');
        $id_paziente = Input::get('paziente_id');
        
        $xml;
        $relPers;
        $tipo;
        
        // emergency
        if (! is_null($file)) {
            
            $xml = XmlParser::load($file->getRealPath());
            
            $id = $xml->parse([
                'identifier' => [
                    'uses' => 'identifier.value::value'
                ]
            ]);
            
            $relPers = new Contatto();
            $relPers = Contatto::all();
            
            foreach ($relPers as $r) {
                if ($r->id_contatto == $id['identifier']) {
                    throw new Exception("Emergency Contact has already been associated");
                }
            }
            
            $tipo = "Contatto";
        } else {
            // parente
            $file = $request->file('fileRel');
            $xml = XmlParser::load($file->getRealPath());
            
            $id = $xml->parse([
                'identifier' => [
                    'uses' => 'identifier.value::value'
                ]
            ]);
            
            $relPers = Parente::all();
            
            foreach ($relPers as $r) {
                if ($r->id_parente == $id['identifier']) {
                    throw new Exception("Relative has already been associated");
                }
            }
            
            $tipo = "Parente";
        }
        
        $lettura = $xml->parse([
            'identifier' => [
                'uses' => 'identifier.value::value'
            ],
            'active' => [
                'uses' => 'active::value'
            ],
            'patient' => [
                'uses' => 'patient.reference::value'
            ],
            'relationship' => [
                'uses' => 'relationship.coding.code::value'
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
            ]
        
        ]);
        
        $telecom = array();
        
        foreach ($lettura['telecom'] as $p) {
            array_push($telecom, $p['attr']);
        }
        
        $tel = array();
        
        if (! is_null($telecom[0])) {
            $tel['telefono'] = $telecom[0];
        }
        
        if (! is_null($telecom[1])) {
            $tel['mail'] = $telecom[1];
        }
        
        if ($tipo == "Contatto") {
            
            $contatto = array();
            $contatto['id_contatto'] = $lettura['identifier'];
            $contatto['id_paziente'] = $id_paziente;
            $contatto['attivo'] = $lettura['active'];
            $contatto['relazione'] = $lettura['relationship'];
            $contatto['nome'] = $lettura['name'];
            $contatto['cognome'] = $lettura['surname'];
            $contatto['sesso'] = $lettura['gender'];
            $contatto['telefono'] = $tel['telefono'];
            $contatto['mail'] = $tel['mail'];
            $contatto['data_nascita'] = $lettura['birthDate'];
            $contatto['data_inizio'] = '';
            $contatto['data_fine'] = '';
            
            $addContatto = new Contatto();
            
            foreach ($contatto as $key => $value) {
                if (empty($value)) {
                    continue;
                }
                $addContatto->$key = $value;
            }
            
            $addContatto->save();
        } else {
            
            $parente = array();
            $parente['id_parente'] = $lettura['identifier'];
            $parente['codice_fiscale'] = '';
            $parente['nome'] = $lettura['name'];
            $parente['cognome'] = $lettura['surname'];
            $parente['sesso'] = $lettura['gender'];
            $parente['data_nascita'] = $lettura['birthDate'];
            $parente['telefono'] = $tel['telefono'];
            $parente['mail'] = $tel['mail'];
            $parente['eta'] = '';
            $parente['decesso'] = $lettura['active'];
            $parente['eta_decesso'] = '';
            $parente['data_decesso'] = '';
            
            $addParente = new Parente();
            
            foreach ($parente as $key => $value) {
                if (empty($value)) {
                    continue;
                }
                $addParente->$key = $value;
            }
            
            $addParente->save();
            
            $pazFam = array();
            $pazFam['id_paziente'] = $id_paziente;
            $pazFam['id_parente'] = $lettura['identifier'];
            $pazFam['relazione'] = $lettura['relationship'];
            $pazFam['familiarita_grado_parentela'] = '';
            $pazFam['familiarita_aggiornamento_data'] = '';
            $pazFam['familiarita_conferma'] = '';
            
            $addPazFam = new PazientiFamiliarita();
            
            foreach ($pazFam as $key => $value) {
                if (empty($value)) {
                    continue;
                }
                $addPazFam->$key = $value;
            }
            
            $addPazFam->save();
        }
        
        return response()->json($lettura['identifier'], 201);
    }

    public function update(Request $request, $id)
    {
        $file = $request->file('fileUpdate');
        $id_paziente = Input::get('paziente_id');
        
        $xml;
        $relPers;
        $tipo;
        
        $i;
        // emergency
        if (! is_null($file)) {
            
            $xml = XmlParser::load($file->getRealPath());
            
            $i = $xml->parse([
                'identifier' => [
                    'uses' => 'identifier.value::value'
                ]
            ]);
            
            
            $tipo = "Contatto";
        } else {
            // parente
            $file = $request->file('fileUpdateRel');
            $xml = XmlParser::load($file->getRealPath());
            
            $i = $xml->parse([
                'identifier' => [
                    'uses' => 'identifier.value::value'
                ]
            ]);
            
            $relPers = Parente::all();
            $tipo = "Parente";
        }
        print_r($i);
    }
}