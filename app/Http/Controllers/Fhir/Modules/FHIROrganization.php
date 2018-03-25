<?php
namespace App\Http\Controllers\Fhir\Modules;

use App\Exceptions\FHIR as FHIR;
use App\Models\InvestigationCenter\CentriIndagini;
use App\Models\InvestigationCenter\CentriTipologie;
use App\Models\InvestigationCenter\CentriContatti;
use App\Models\InvestigationCenter\ModalitaContatti;
use App\Models\InvestigationCenter\Indagini;
use App\Models\Domicile\Comuni;
use Illuminate\Http\Request;

class FHIROrganization  {

    function delete($id) {
        
        if (!CentriIndagini::find($id)->exists()) {
            throw new FHIR\IdNotFoundInDatabaseException("resource with the id provided doesn't exist in database");
        }

        # ELIMINO I DATI DAL DATABASE
        CentriContatti::where("id_centro", $id)->delete();
        CentriIndagini::find($id)->delete();
    }

    function update(Request $request, $id_organization) {
        
        $doc = new \SimpleXMLElement($request->getContent());
        
        $organization_data   = CentriIndagini::find($id_organization);
        $datafrom_name       = $doc->name["value"];
        $datafrom_address    = $doc->address->line["value"];
        $datafrom_city       = $doc->address->city["value"];
        $datafrom_idcpp      = $doc->extension[0]->valueString["value"];
        $datafrom_tipology   = $doc->extension[1]->valueString["value"];
        $datafrom_phone      = $doc->telecom[1]->value["value"];
        $datafrom_email      = $doc->telecom[0]->value["value"];
        
        /** VERIFICO LA PRESENZA DI ALCUNI DATI NECESSARI PER LA REGISTRAZIONE **/
        
        if (!$organization_data) {
            throw new FHIR\IdNotFoundInDatabaseException("resource with the id provided not exists in database !");
        }
        
        if (empty($datafrom_name)) {
            throw new FHIR\InvalidResourceFieldException("organization name cannot be empty !");
        }
        
        if (empty($datafrom_address)) {
            throw new FHIR\InvalidResourceFieldException("organization address cannot be empty !");
        }
        
        if (empty($datafrom_city)) {
            throw new FHIR\InvalidResourceFieldException("organization city cannot be empty !");
        }
        
        if (empty($datafrom_idcpp)) {
            throw new FHIR\InvalidResourceFieldException("organization cpp cannot be empty !");
        }
        
        if (empty($datafrom_tipology)) {
            throw new FHIR\InvalidResourceFieldException("organization type cannot be empty !");
        }
        
        /** VALIDAZIONE ANDATA A BUON FINE - CREO IL PAZIENTE E L'UTENTE ASSOCIATO **/

        $organization_data->centro_nome       = $datafrom_name;
        $organization_data->centro_indirizzo  = $datafrom_address;
        $organization_data->id_ccp_persona    = $datafrom_idcpp;
        $organization_data->id_tipologia      = 0; //Valore di "Non specificato"
        $organization_data->id_comune         = 0; //Valore di "Non specificato"
        
        $centro_tipologia = CentriTipologie::where('tipologia_nome', $datafrom_tipology)->first();
        
        if($centro_tipologia){
            $organization_data->id_tipologia = $centro_tipologia->id_centro_tipologia;
        }
        
        $centro_citta     = Comuni::where('comune_nominativo', $datafrom_city)->first();
        
        if($centro_citta){
            $organization_data->id_comune = $centro_citta->id_comune;
        }
        
        $organization_data->save();
        
        if(!empty($datafrom_phone)){
            CentriContatti::where("id_centro", $id_organization)
            ->where("id_modalita_contatto", ModalitaContatti::$PHONE_TYPE)
            ->update(["contatto_valore" => $datafrom_phone]);
        }
        
        if(!empty($datafrom_email)){
            CentriContatti::where("id_centro", $id_organization)
            ->where("id_modalita_contatto", ModalitaContatti::$EMAIL_TYPE)
            ->update(["contatto_valore" => $datafrom_email]);
        } 
    }

    function store(Request $request) {
        
        $doc = new \SimpleXMLElement($request->getContent());
        
        $datafrom_name       = $doc->name["value"];
        $datafrom_address    = $doc->address->line["value"];
        $datafrom_city       = $doc->address->city["value"];
        $datafrom_idcpp      = $doc->extension[0]->valueString["value"];
        $datafrom_tipology   = $doc->extension[1]->valueString["value"];
        $datafrom_phone      = $doc->telecom[1]->value["value"];
        $datafrom_email      = $doc->telecom[0]->value["value"];
        
        /** VERIFICO LA PRESENZA DI ALCUNI DATI NECESSARI PER LA REGISTRAZIONE **/

        if (empty($datafrom_name)) {
            throw new FHIR\InvalidResourceFieldException("organization name cannot be empty !");
        }
        
        if (empty($datafrom_address)) {
            throw new FHIR\InvalidResourceFieldException("organization address cannot be empty !");
        }
        
        if (empty($datafrom_city)) {
            throw new FHIR\InvalidResourceFieldException("organization city cannot be empty !");
        }
        
        if (empty($datafrom_idcpp)) {
            throw new FHIR\InvalidResourceFieldException("organization cpp cannot be empty !");
        }
        
        if (empty($datafrom_tipology)) {
            throw new FHIR\InvalidResourceFieldException("organization type cannot be empty !");
        }

        /** VALIDAZIONE ANDATA A BUON FINE - CREO IL PAZIENTE E L'UTENTE ASSOCIATO **/
        
        $organization_data                    = new CentriIndagini();
        $organization_data->centro_nome       = $datafrom_name;
        $organization_data->centro_indirizzo  = $datafrom_address;
        $organization_data->id_ccp_persona    = $datafrom_idcpp;
        $organization_data->id_tipologia      = 0; //Valore di "Non specificato"
        $organization_data->id_comune         = 0; //Valore di "Non specificato"
        
        $centro_tipologia = CentriTipologie::where('tipologia_nome', $datafrom_tipology)->first();
        
        if($centro_tipologia){
            $organization_data->id_tipologia = $centro_tipologia->id_centro_tipologia;
        }
        
        $centro_citta     = Comuni::where('comune_nominativo', $datafrom_city)->first();
        
        if($centro_citta){
            $organization_data->id_comune = $centro_citta->id_comune;
        }
        
        $organization_data->save();
        
        if(!empty($datafrom_phone)){
            $oraginzation_contact = new CentriContatti();
            $oraginzation_contact->id_centro            = $organization_data->id_centro;
            $oraginzation_contact->id_modalita_contatto = ModalitaContatti::$PHONE_TYPE;
            $oraginzation_contact->contatto_valore      = $datafrom_phone;
            
            $oraginzation_contact->save();
        }
        
        if(!empty($datafrom_email)){
            $oraginzation_contact = new CentriContatti();
            $oraginzation_contact->id_centro            = $organization_data->id_centro;
            $oraginzation_contact->id_modalita_contatto = ModalitaContatti::$EMAIL_TYPE;
            $oraginzation_contact->contatto_valore      = $datafrom_email;
            
            $oraginzation_contact->save();
        } 
    }

    function show($id_organization) {

        $centro_indagine = CentriIndagini::find($id_organization);
        
        if (!$centro_indagine) {
            throw new FHIR\IdNotFoundInDatabaseException("resource with the id provided doesn't exist in database");
        }

        $values_in_narrative = array(
            'Nome studio'   => $centro_indagine->centro_nome,
            'Via'           => $centro_indagine->centro_indirizzo,
            'Citta\''       => $centro_indagine->getTown(),
            'Tipo centro'   => $centro_indagine->getCenterTipology(),
            'Telefono'      => $centro_indagine->getContactPhone(),
            'Email'         => $centro_indagine->getContactEmail(),
        );
        
        if(!empty($centro_indagine->getCareProvider())){
            $values_in_narrative["Care provider"] = "Dott. " . $centro_indagine->getCareProvider();
        }

        $data_xml["narrative"]      = $values_in_narrative;
        $data_xml["organization"]   = $centro_indagine;
        $data_xml["phone"]          = $centro_indagine->getAllContactPhone();
        
        return view("fhir.organization", ["data_output" => $data_xml]);
    }
}

?>