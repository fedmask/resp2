<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Patient\Pazienti;
use App\Models\CurrentUser\User;
use App\Models\CurrentUser\Recapiti;
use App\Models\Domicile\Comuni;
use App\Models\Patient\Taccuino;
use App\Eceptions\UserAlreadyExistsException;
use App\Models\FHIR\PatientContact;
use Validator;
use Redirect;
use Auth;
use DB;
use Exception;
use Input;
use Orchestra\Parser\Xml\Facade as XmlParser;


class UploadResourceFhirController extends Controller
{
    
    public function uploadPatient(Request $request){
        
        $file = $request->file('file');
        
        $xml = XmlParser::load($file->getRealPath());
        
        $id = $xml->parse(['identifier' => ['uses' => 'identifier.value::value']]);
        
        $pazienti = Pazienti::all();
        
        foreach($pazienti as $p){
            if($p->id_paziente == $id['identifier']){
                throw new Exception("Patient is already exists");
            }
        }
        
        $patient = $xml->parse([
            'identifier' => ['uses' => 'identifier.value::value'],
            'active' => ['uses' => 'active::value'],
            'name' => ['uses' => 'name.given::value'],
            'surname' => ['uses' => 'name.family::value'],
            'telecom' => ['uses' => 'telecom[value::value]'],
            'gender' => ['uses' => 'gender::value'],
            'birthDate' => ['uses' => 'birthDate::value'],
            'deceasedBoolean' => ['uses' => 'deceasedBoolean::value'],
            'line' => ['uses' => 'address.line::value'],
            'city' => ['uses' => 'address.city::value'],
            'state' => ['uses' => 'address.state::value'],
            'postalCode' => ['uses' => 'address.postalCode::value'],
            'maritalStatus' => ['uses' => 'maritalStatus.coding.code::value'],
            'communication' => ['uses' => 'communication.language.coding.code::value'],
            'extension' => ['uses' => 'extension.valueBoolean::value'],
            'ContRelCode' => ['uses' => 'contact[relationship.coding.code::value>attr]'],
            'ContSurname' => ['uses' => 'contact[name.family::value>attr]'],
            'ContName' => ['uses' => 'contact[name.given::value>attr]'],
            'ContPhone' => ['uses' => 'contact[telecom.value::value>attr]'],
            //TODO email 
            //TODP Patient.Contact
            
        ]);
        
     $contRelCode = array();
     foreach($patient['ContRelCode'] as $cont){
         array_push($contRelCode, $cont['attr']);
     }
     
     $contSurname = array();
     foreach($patient['ContSurname'] as $cont){
         array_push($contSurname, $cont['attr']);
     }
     
     $contName = array();
     foreach($patient['ContName'] as $cont){
         array_push($contName, $cont['attr']);
     }
     
     $contPhone = array();
     foreach($patient['ContPhone'] as $cont){
         array_push($contPhone, $cont['attr']);
     }


   $telecom = array();
        
        foreach($patient['telecom'][0] as $p){
            array_push($telecom ,$p);
        }
        
        
        foreach($patient['telecom'][1] as $p){
         array_push($telecom ,$p);
    }

        
        $comune = Comuni::all()->where('comune_nominativo', $patient['city'])->first();
        

        
        $addUtente = User::create([
            'utente_nome' => $patient['name']." ".$patient['surname'],
            'id_tipologia'=> 'mos',
            'utente_password' => bcrypt('test1234'),
            'utente_stato' => '1',
            'utente_scadenza' => '2030-01-01',
            'utente_email' => $telecom[1],
            'utente_dati_condivisione' => '1',
            'utente_token_accesso' => ''
            
        ]);
        
        $addUtente->save();
  
       
        $utente = User::all()->last();
        
        $addContatti = Recapiti::create([
            'id_utente' => $utente->id_utente,
            'id_comune_residenza' => $comune->id_comune,
            'id_comune_nascita' => $comune->id_comune,
            'contatto_telefono' => $telecom[0],
            'contatto_indirizzo' => $patient['line'],
        ]);
        
        
        $addContatti->save();
        
        
        $addPaziente = Pazienti::create([
            'id_paziente' => $patient['identifier'],
            'id_utente' => $utente->id_utente,
            'paziente_nome' => $patient['name'],
            'paziente_cognome' => $patient['surname'],
            'paziente_nascita' => $patient['birthDate'],
            'paziente_codfiscale' => '',
            'paziente_sesso' => $patient['gender'],
            'paziente_gruppo' => '',
            'paziente_rh' => '',
            'paziente_donatore_organi' => $patient['extension'],
            'id_stato_matrimoniale' => $patient['maritalStatus'],
            'paziente_lingua' => $patient['communication']
        ]);
        
        $addPaziente->save();
        
        
        $patientContact;
        for ($i = 0; $i < sizeof($contRelCode); $i ++) {
            $patientContact = PatientContact::create([
                'Id_Patient' => $patient['identifier'],
                'Relationship' => $contRelCode[$i],
                'Name' => $contName[$i],
                'Surname' => $contSurname[$i],
                'Telephone' => $contPhone[$i],
                'Mail' => ''
            ]);
            
            $patientContact->save();
        }
        
        
        return Redirect::back();
    }
    
}