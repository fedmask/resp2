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
        
        return view("pages.fhir.RelatedPerson.relatedPerson", [
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
        
        // emergency
        if (! is_null($file)) {
            
            $xml = XmlParser::load($file->getRealPath());
            
            $id_contatto = $xml->parse([
                'identifier' => [
                    'uses' => 'identifier.value::value'
                ]
            ]);
          
            if ($id_contatto['identifier'] != $id) {
                throw new Exception("Emergency Contact does not exist in the database");
            }
            
            $tipo = "Contatto";
        } else {
            // parente
            $file = $request->file('fileUpdateRel');
            $xml = XmlParser::load($file->getRealPath());
            
            $id_parente = $xml->parse([
                'identifier' => [
                    'uses' => 'identifier.value::value'
                ]
            ]);
            
            if ($id_parente['identifier'] != $id) {
                throw new Exception("Relative does not exist in the database");
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
            
            $updContatto = Contatto::where('id_contatto', $lettura['identifier'])->first();
            
            foreach ($contatto as $key => $value) {
                if (empty($value)) {
                    continue;
                }
                $updContatto->$key = $value;
            }
            
            $updContatto->save();
        } else {
            
            $parente = array();
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
            
            $updParente = Parente::where('id_parente', $lettura['identifier'])->first();
            
            foreach ($parente as $key => $value) {
                if (empty($value)) {
                    continue;
                }
                $updParente->$key = $value;
            }
            
            $updParente->save();
            
            $pazFam = array();
            $pazFam['id_parente'] = $lettura['identifier'];
            $pazFam['relazione'] = $lettura['relationship'];
            $pazFam['familiarita_grado_parentela'] = '';
            $pazFam['familiarita_aggiornamento_data'] = '';
            $pazFam['familiarita_conferma'] = '';
            
            $updPazFam = PazientiFamiliarita::where('id_parente', $lettura['identifier'])->first();
            
            foreach ($pazFam as $key => $value) {
                if (empty($value)) {
                    continue;
                }
                $updPazFam->$key = $value;
            }
            
            $updPazFam->save();
        }
        
        return response()->json($id, 200);
    }
    
    function destroy($id)
    {
        $id_paziente = Input::get('patient_id');
        $tipo = Input::get('type');
        
        if($tipo == "EM"){
            Contatto::find($id)->delete();
            return response()->json(null, 204);
        }else{
            PazientiFamiliarita::find($id)->delete();
            return response()->json(null, 204);
        }
    }
    
    public static function getResource($id){
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
                "Id" => $id,
                "Identifier" => "RESP-RELATEDPERSON-EM" . "-" . $relPers->getId(),
                "Active" => $relPers->isActive(),
                "Patient" => "FHIR-PATIENT-" . $relPers->getIdPaziente(),
                "Relationship" => $relPers->getRelazione(),
                "RelationshipCode" => $relPers->getRelazioneCode(),
                "Name" => $relPers->getFullName(),
                "Nome" => $relPers->getNome(),
                "Cognome" => $relPers->getCognome(),
                "Telecom" => $relPers->getTelecom(),
                "Telefono" => $relPers->getTelefono(),
                "Mail" => $relPers->getMail(),
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
                "Id" => $id,
                "Identifier" => "RESP-RELATEDPERSON-REL" . "-" . $relPers->getId(),
                "Active" => $relPers->isActive(),
                "Patient" => "FHIR-PATIENT-" . $relPers->getIdPaziente(),
                "Relationship" => $relPers->getRelazione(),
                "RelationshipCode" => $relPers->getRelazioneCode(),
                "Name" => $relPers->getFullName(),
                "Nome" => $relPers->getNome(),
                "Cognome" => $relPers->getCognome(),
                "Telecom" => $relPers->getTelecom(),
                "Telefono" => $relPers->getTelefono(),
                "Mail" => $relPers->getMail(),
                "Gender" => $relPers->getSesso(),
                "BirthDate" => $relPers->getDataNascita()
            );
        }
        
        $data_xml["narrative"] = $values_in_narrative;
        $data_xml["relPers"] = $relPers;
        $data_xml["tipo"] = $tipo;
        
        self::xml($data_xml);
    }
    
    public static function xml($data_xml){
        //Creazione di un oggetto dom con la codifica UTF-8
        $dom = new DOMDocument('1.0', 'utf-8');
        
        //Creazione del nodo Patient, cioè il nodo Root  della risorsa
        $relPer = $dom->createElement('RelatedPerson');
        //Valorizzo il namespace della risorsa e del documento XML, in  questo caso la specifica FHIR
        $relPer->setAttribute('xmlns', 'http://hl7.org/fhir');
        //Corrello l'elemento con il nodo superiore
        $relPer = $dom->appendChild($relPer);
        
        
        //Creazione del nodo ID sempre presente nelle risorse FHIR
        $id = $dom->createElement('id');
        //Il valore dell'ID è il valore dell'ID nella relativa tabella del DB
        $id->setAttribute('value', $data_xml["narrative"]["Id"]);
        $id = $relPer->appendChild($id);
        
        //Creazione della parte narrativa in XHTML e composta da tag HTML visualizzabili se aperto il file XML in un Browser
        $narrative = $dom->createElement('text');
        //Corrello l'elemento con il nodo superiore
        $narrative = $relPer->appendChild($narrative);
        
        
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
        
        
        
        //Creazione del nodo identifier identificativo della risorsa Patient attraverso URI della risorsa
        $identifier = $dom->createElement('identifier');
        $identifier = $relPer->appendChild($identifier);
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
        $active = $relPer->appendChild($active);
        
        //creazione del nodo patient
        $patient = $dom->createElement('patient');
        $patient = $relPer->appendChild($patient);
        
        $reference = $dom->createElement('reference');
        $reference->setAttribute('value', $data_xml["narrative"]["Patient"]);
        $reference = $patient->appendChild($reference);
        
        
        //creazione del nodo relationship
        $relationship = $dom->createElement('relationship');
        $relationship = $relPer->appendChild($relationship);
        
        $coding = $dom->createElement('coding');
        $coding = $relationship->appendChild($coding);
   
        $system = $dom->createElement('system');
        $system->setAttribute('value', 'http://hl7.org/fhir/v3/RoleCode');
        $system = $coding->appendChild($system);
        
        $code = $dom->createElement('code');
        $code->setAttribute('value', $data_xml["narrative"]["RelationshipCode"]);
        $code = $coding->appendChild($code);
        
        
             
        //Creazione del nodo per il nominativo del paziente
        $name = $dom->createElement('name');
        $name = $relPer->appendChild($name);
        //Creazione del nodo use settato sempre al valore usual
        $use = $dom->createElement('use');
        $use->setAttribute('value', 'usual');
        $use = $name->appendChild($use);
        //Creazione del nodo family che indica il nome dalla famiglia di provenienza, quindi il cognome del paziente
        $family = $dom->createElement('family');
        $family->setAttribute('value', $data_xml["narrative"]["Cognome"]);
        $family = $name->appendChild($family);
        //Creazione del nodo given che indica il nome di battesimo dato al paziente
        $given = $dom->createElement('given');
        $given->setAttribute('value', $data_xml["narrative"]["Nome"]);
        $given = $name->appendChild($given);
        
        
        //Creazione del nodo telecom con il contatto telefonico del paziente
        $telecom = $dom->createElement('telecom');
        $telecom = $relPer->appendChild($telecom);
        //Creazione del nodo system che indica che il contatto è un valore telefonico
        $system = $dom->createElement('system');
        $system->setAttribute('value', 'phone');
        $system = $telecom->appendChild($system);
        //Creazione del nodo value che contiene il valore del numero di telefono del paziente
        $value = $dom->createElement('value');
        $value->setAttribute('value', $data_xml["narrative"]["Telefono"]);
        $value = $telecom->appendChild($value);
        //Creazione del nodo use che indica la tipologia di numero di telefono
        $use = $dom->createElement('use');
        $use->setAttribute('value', 'mobile');
        $use = $telecom->appendChild($use);
        
        
        //Creazione del nodo telecom con il contatto mail del paziente
        $telecom = $dom->createElement('telecom');
        $telecom = $relPer->appendChild($telecom);
        //Creazione del nodo system che indica che il contatto è un valore telefonico
        $system = $dom->createElement('system');
        $system->setAttribute('value', 'email');
        $system = $telecom->appendChild($system);
        //Creazione del nodo value che contiene il valore del numero di telefono del paziente
        $value = $dom->createElement('value');
        $value->setAttribute('value', $data_xml["narrative"]["Mail"]);
        $value = $telecom->appendChild($value);
        //Creazione del nodo use che indica la tipologia di numero di telefono
        $use = $dom->createElement('use');
        $use->setAttribute('value', 'home');
        $use = $telecom->appendChild($use);
        
        
        //Creazione del nodo gender per il sesso del paziente
        $gender = $dom->createElement('gender');
        $gender->setAttribute('value', $data_xml["narrative"]["Gender"]);
        $gender = $relPer->appendChild($gender);
        
        //Creazione del nodo birthdate con la data di nascita del paziente
        $birthDate = $dom->createElement('birthDate');
        $birthDate->setAttribute('value', $data_xml["narrative"]["BirthDate"]);
        $birthDate = $relPer->appendChild($birthDate);
        
        
        
        //Elimino gli spazi bianchi superflui per la viasualizzazione grafica dell'XML
        $dom->preserveWhiteSpace = false;
        //Formatto il documento per l'output
        $dom->formatOutput = true;
        $path = getcwd()."\\resources\\Patient\\";
        //Salvo il documento XML nella cartella rsources dando come nome, l'id del paziente
        if($data_xml['tipo'] == "Contatto"){
            $dom->save($path."RESP-RELATEDPERSON-EM-".$data_xml["narrative"]["Id"].".xml");
        }else{
            $dom->save($path."RESP-RELATEDPERSON-REL-".$data_xml["narrative"]["Id"].".xml");
        }
        
        return $dom->saveXML();
        
    }
}