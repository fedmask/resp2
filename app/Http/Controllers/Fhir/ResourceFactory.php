<?php



include('ResourceExceptions.php');

/*

Questa classe permette di gestire le classi che generano risorse
FHIR in xml in maniera dinamica, in base al parametro passato al costruttore
della classe. Le varie classi che generano le risorse fhir, generano solo
un output xml. Una eventuale conversione JSON dovra' essere gestita in
livelli superiori.

Ogni volta che verra' aggiunta una nuova classe che corrisponde ad una risorsa
FHIR, bisogna aggiungere all'array $resources il nome della risorsa ed inserire
la risorsa nella directory modules seguendo il layout delle altre risorse gia'
sviluppate.

Il pattern di design applicato per creare dinamicamente delle classi
che abbiano gli stessi metodi e' il factory method.

*/

class ResourceFactory {
    // ogni volta che si crea una nuova risorsa
    // bisogna elencare nel seguente array il nome della risorsa
    private $resources = array(
        'FHIRPatient',
        'FHIRPractitioner',
        'FHIRObservation',
        'FHIRDiagnosticReport',
        'FHIRFamilyMemberHistory',
        'FHIROrganization'
    );

    private $resource = NULL;

    public function __construct($type) {
        $res_instances = [];
        $res_found = false;

        // includo dinamicamente i vari file php
        foreach($this->resources as $res) {
            require_once('Modules/' . $res . '.php');
            
            // dopo che ho incluso la classe inserisco
            // in un array una istanza della classe appena caricata
            $res_instances[$res] = new $res();

            if ($type == $res)
                $res_found = true;
        }

        // se la stringa specificata come parametro del costruttore
        // corrisponde ad una effettivo nome di una classe FHIR
        // allora istanzio l'oggetto corrispondente in $resource

        if ($res_found) {
            $this->resource = $res_instances[$type];
        } else {
            throw new ResourceNotFoundException("Resource not found!");
        }
    }

    // richiamo dinamicamente le funzioni dei vari file php
    public function getData($id) {
        return $this->resource->getResource($id);
    }

    // i metodi per la creazione di nuove risorse che utilizzano
    // il servizio POST dovranno ritornare l'id della risorsa appena creata
    public function postData($xml) {
        return $this->resource->createResource($xml);
    }

    // richiamo dinamicamente il metodo per l'aggiornamento
    // dei dati di una risorsa, la funzione non ritorna alcun
    // valore poiche' abbiamo gia' l'id della risorsa da aggiornare
    public function putData($id, $xml) {
        $this->resource->updateResource($id, $xml);
    }

    // richiamo dinamicamente il metodo per la cancellazione
    // di una risorsa dal database specificando l'id in input
    public function deleteData($id) {
        $this->resource->deleteResource($id);
    }
}

?>