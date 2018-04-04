<?php

namespace App\Http\Controllers\Fhir\Modules;

use App\Http\Controllers\Fhir\Modules\FHIRUtilities;
use App\Exceptions\FHIR as FHIR;
use App\Models\CareProviders\CppPersona;
use App\Models\Domicile\Comuni;
use Illuminate\Http\Request;
use App;
use Redirect;

/**
 * Implementazione dei servizi REST:
 * show     -> GET
 * destroy  -> DELETE
 * store    -> POST
 * update   -> PUT
 *
 * I metodi lavorano con il file XML secondo lo standard FHIR
 */

class FHIRPractitioner {
   
    public function destroy($id_cpp) {
        
        $cpp = CppPersona::find($id_cpp);
        
        //Verifico l'esistenza del care provider
        if (!$cpp->exists()) {
            throw new FHIR\IdNotFoundInDatabaseException("resource with the id provided doesn't exist in database");
        }

        $cpp->delete();
    }

    public function store(Request $request) {

        $doc = new \SimpleXMLElement($request->getContent());
        
        $cpp_data           = CppPersona::find($doc->id["value"])->first();
        $datafrom_name      = $doc->name->given["value"];
        $datafrom_surname   = $doc->name->family["value"];
        $datafrom_phone     = $doc->telecom->value["value"];
        $datafrom_active    = $doc->active["value"];
        
        /** VERIFICO LA PRESENZA DI ALCUNI DATI NECESSARI PER LA REGISTRAZIONE **/
        
        if ($cpp_data) {
            throw new FHIR\IdNotFoundInDatabaseException("resource with the id exists in database !");
        }
        
        if (empty($datafrom_name) || empty($datafrom_surname)) {
            throw new FHIR\InvalidResourceFieldException("invalid care provider name and surname");
        }
        
        if (empty($datafrom_phone)) {
            throw new FHIR\InvalidResourceFieldException("invalid phone number");
        }
        
        if (empty($datafrom_active)) {
            throw new FHIR\InvalidResourceFieldException("cpp status is empty !");
        }
        
        /** VALIDAZIONE ANDATA A BUON FINE - AGGIORNO IL CPP **/
        
        $comune_nascita = Comuni::where('comune_nominativo', $doc->extension[0]->valueString["value"])->first();
        
        $cpp_data = new CppPersona();
        $cpp_data->setIDTown($comune_nascita->id_comune);
        $cpp_data->setName($datafrom_name);
        $cpp_data->setSurname($datafrom_surname);
        $cpp_data->setPhone($datafrom_phone);
        $cpp_data->setActive($datafrom_active);
        
        $cpp_data->save();
        
        return response('', 201);
    }
    
    public function update(Request $request, $id) {
        
        $doc = new \SimpleXMLElement($request->getContent());

        $cpp_data           = CppPersona::find($doc->id["value"])->first();
        $datafrom_name      = $doc->name->given["value"];
        $datafrom_surname   = $doc->name->family["value"];
        $datafrom_phone     = $doc->telecom->value["value"];
        $datafrom_active    = $doc->active["value"];

        /** VERIFICO LA PRESENZA DI ALCUNI DATI NECESSARI PER LA REGISTRAZIONE **/
        
        if (!$cpp_data) {
            throw new FHIR\IdNotFoundInDatabaseException("resource with the id dont exists in database !");
        }
        
        if (empty($datafrom_name) || empty($datafrom_surname)) {
            throw new FHIR\InvalidResourceFieldException("invalid care provider name and surname");
        }
        
        if (empty($datafrom_phone)) {
            throw new FHIR\InvalidResourceFieldException("invalid phone number");
        }

        if (empty($datafrom_active)) {
            throw new FHIR\InvalidResourceFieldException("cpp status is empty !");
        }
        
        /** VALIDAZIONE ANDATA A BUON FINE - AGGIORNO IL CPP **/
        
        $comune_nascita = Comuni::where('comune_nominativo', $doc->extension[0]->valueString["value"])->first();

        $cpp_data->setIDTown($comune_nascita->id_comune);
        $cpp_data->setName($datafrom_name);
        $cpp_data->setSurname($datafrom_surname);
        $cpp_data->setPhone($datafrom_phone);
        $cpp_data->setActive($datafrom_active);
        
        $cpp_data->save();
    }

    public function show($id_cpp){
        
        $data_cpp = CppPersona::find($id_cpp);
        
        //Verifico l'esistenza del care provider
        if (!$data_cpp->exists()) {
            throw new FHIR\IdNotFoundInDatabaseException("resource with the id provided doesn't exist in database");
        }

        $values_in_narrative = array(
            "Name"       => $data_cpp->getName() . " " . $data_cpp->getSurname(),
            "Contact"    => $data_cpp->getPhone(),
            "City"       => $data_cpp->getTown()
        );
        
        $data_xml["narrative"]     = $values_in_narrative;
        $data_xml["careprovider"]  = $data_cpp;

        return view("fhir.practitioner", ["data_output" => $data_xml]);
    }
    
}

?>