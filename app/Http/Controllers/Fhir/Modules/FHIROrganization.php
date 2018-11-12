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

/**
 * Implementazione dei servizi REST:
 * show     -> GET
 * destroy  -> DELETE
 * store    -> POST
 * update   -> PUT
 *
 * I metodi lavorano con il file XML secondo lo standard FHIR
 */

class FHIROrganization  {

    public function destroy($id) {
        
        $oranization = CentriIndagini::find($id);
        
        if (!$oranization) {
            throw new FHIR\IdNotFoundInDatabaseException("resource with the id provided doesn't exist in database");
        }

        CentriContatti::where("id_centro", $id)->delete();
        
        $oranization->delete();
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

        $organization_data->setName($datafrom_name);
        $organization_data->setAddress($datafrom_address);
        $organization_data->setIDCpp($datafrom_idcpp);
        $organization_data->setIDTown(0);       //Valore di "Non specificato"
        $organization_data->setIDTipology(0);   //Valore di "Non specificato"
        
        //Ottengo gli id secondo il RESP per la tipologia del centro e la città
        
        $centro_tipologia = CentriTipologie::where('tipologia_nome', $datafrom_tipology)->first();
        
        if($centro_tipologia){
            $organization_data->setIDTipology($centro_tipologia->getID());
        }
        
        $centro_citta     = Comuni::where('comune_nominativo', $datafrom_city)->first();
        
        if($centro_citta){
            $organization_data->setIDTown($centro_citta->getID());
        }
        
        $organization_data->save();
        
        //Aggiorno i recapiti presenti (al momento telefono e emai)
        
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

    public function store(Request $request) {
        
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
        
        $organization_data = new CentriIndagini();
        $organization_data->setName($datafrom_name);
        $organization_data->setAddress($datafrom_address);
        $organization_data->setIDCpp($datafrom_idcpp);
        $organization_data->setIDTown(0);       //Valore di "Non specificato"
        $organization_data->setIDTipology(0);   //Valore di "Non specificato"
        
        $centro_tipologia = CentriTipologie::where('tipologia_nome', $datafrom_tipology)->first();
        
        if($centro_tipologia){
            $organization_data->setIDTipology($centro_tipologia->getID());
        }
        
        $centro_citta     = Comuni::where('comune_nominativo', $datafrom_city)->first();
        
        if($centro_citta){
            $organization_data->setIDTown($centro_citta->getID());
        }
        
        $organization_data->save();
        
        //Aggiorno i recapiti presenti (al momento telefono e emai)
        
        if(!empty($datafrom_phone)){
            $oraginzation_contact = new CentriContatti();
            $oraginzation_contact->setIDCenter($organization_data->getIDCenter());
            $oraginzation_contact->setIDModContact(ModalitaContatti::$PHONE_TYPE);
            $oraginzation_contact->setValueContact($datafrom_phone);
            
            $oraginzation_contact->save();
        }
        
        if(!empty($datafrom_email)){
            $oraginzation_contact = new CentriContatti();
            $oraginzation_contact->setIDCenter($organization_data->getIDCenter());
            $oraginzation_contact->setIDModContact(ModalitaContatti::$EMAIL_TYPE);
            $oraginzation_contact->setValueContact($datafrom_email);
            
            $oraginzation_contact->save();
        } 
        
        return response('', 201);
    }

    public function show($id_organization) {

        $organization = CentriIndagini::find($id_organization);
        
        //Verifico l'esistenza del centro indagine
        if (!$organization) {
            throw new FHIR\IdNotFoundInDatabaseException("resource with the id provided doesn't exist in database");
        }

        $values_in_narrative = array(
            'Nome studio'   => $organization->getName(),
            'Via'           => $organization->getAddress(),
            'Citta\''       => $organization->getTown(),
            'Tipo centro'   => $organization->getCenterTipology(),
            'Telefono'      => $organization->getContactPhone(),
            'Email'         => $organization->getContactEmail(),
        );
        
        if(!empty($organization->getCareProvider())){
            $values_in_narrative["Care provider"] = $organization->getCareProvider();
        }

        $data_xml["narrative"]      = $values_in_narrative;
        $data_xml["organization"]   = $organization;
        $data_xml["phone"]          = $organization->getAllContactPhone();
        
        return view("fhir.Organization.organization", ["data_output" => $data_xml]);
    }
}

?>