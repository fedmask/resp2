<?php

/*
Per lo sviluppo delle API RESTful di questo server, ho preso in
considerazione le specifiche presenti sul sito ufficiale di HL7

https://www.hl7.org/fhir/http.html
*/

include("ResourceFactory.php");
include("ResourceView.php");
include('OperationOutcome.php');

//recupero il tipo di risorsa richiesta dal client e l'id della stessa per generare il file XML
$uri = explode("/",$_SERVER['REQUEST_URI']);

// creo un oggetto di tipo resource view che mi permettera' di visualizzare
// il contenuto della risorsa, passandogli successivamente il tipo e l'id della risorsa

$view = new ResourceView();

$url_content = [
    'type'   => $uri[2],
    'id'     => $uri[3],
    'format' => '',
];

// $uri[2]; è il Nome risorsa richiesta
// $uri[3] è l'ID della risorsa (che potrebbe contenere anche la stringa ?_format=x in quel
// caso il formato viene parsato e $uri[3] ritorna ad essere un numero)

if (preg_match("/(.*?)\?_format=(.*?)$/i", $url_content['id'], $matches)) {
    $url_content['id']     = $matches[1];
    $url_content['format'] = $matches[2];
}

// controllo il metodo con cui è stato richiesto il servizio
switch ($_SERVER['REQUEST_METHOD']) {
    case "GET":
        // al momento qualsiasi care provider puo' avere accesso alle API
        // sarebbe piu' consono per uno sviluppo futuro implementare un sistema
        // di API token per garantire piu' riservatezza nelle varie richieste http
        if (!isLogged() || sessionExpired() || !isCareProvider(getRole(getMyID()))) {
            echo OperationOutcome::getXML("Per accedere alle API è necessaria l'autenticazione come care provider!");
            exit();
        }

        $is_error = false;
        $message = '';

        try {
            $resource = new ResourceFactory($url_content['type']);
            $message = $resource->getData($url_content['id']);
        } catch (ResourceNotFoundException $e) {
            $is_error = true;
            $message = OperationOutcome::getXML($e->getMessage());

            http_response_code(404);
        } catch (IdNotFoundInDatabaseException $e) {
            $is_error = true;
            $message = OperationOutcome::getXML($e->getMessage());

            http_response_code(404);
        } catch (UnsupportedOperationException $e) {
            $is_error = true;
            $message = OperationOutcome::getXML($e->getMessage());

            http_response_code(422);
        }

        // se il formato non e' specificato allora mostro la pagina in formato
        // html con il box del codice della risorsa ed i pulsanti di azione
        // altrimenti mostro la risorsa in formato grezzo in base al formato
        // specificato nell'URL

        if (empty($url_content['format'])) {
            $view->display_html($url_content['type'], $url_content['id'], $message, $is_error);
        } else {
            $view->display_raw($message, $url_content['format']);
        }

        break;
    case "POST":
        // se e' specificato un id nell'url allora ritorno un errore
        // poiche' la create non deve contenere l'id ma solo il tipo della risorsa
        if (!empty($url_content['id'])) {
            $view->display_raw(OperationOutcome::getXML('ID found in URL'));
            http_response_code(400);
            exit();
        }

        // !!! ATTENZIONE !!!
        // prima di leggere dallo stream php://input e' necessario
        // modificare il file php.ini impostando il campo:
        // always_populate_raw_post_data = -1

        $xml_content = file_get_contents("php://input");
        $content_type = $_SERVER['CONTENT_TYPE'];

        // controllo che il content type rispetti quello specificato
        // dallo standard
        if ($content_type != 'application/xml-fhir') {
            $view->display_raw(OperationOutcome::getXML("invalid Content-Type"));
            http_response_code(400);
            exit();
        }

        // costruisco dinamicamente un oggetto risorsa
        // ed eseguo il metodo per inserire il contenuto xml
        // nel database
        try {
            
            $resource = new ResourceFactory($url_content['type']);
            $new_id = $resource->postData($xml_content);
                
            // costruisco l'url per l'header location anche se
            // il servizio history non e' ancora disponibile tra le API
            $resource_url = 'http://' . $_SERVER['HTTP_HOST'] . '/fhir/' .
                $url_content['type'] . '/' . $new_id . '/_history/' . $new_id;
            header('Location: ' . $resource_url);

            http_response_code(201);

        } catch (IdFoundInCreateException $e) {
            $view->display_raw(OperationOutcome::getXML($e->getMessage()));
            // se la risorsa data in input per la create
            // contiene il campo id dobbiamo ritornare un errore
            // poiche' per la create non possiamo specificare id
            http_response_code(400);
        } catch (InvalidResourceFieldException $e) {
            $view->display_raw(OperationOutcome::getXML($e->getMessage()));
            // se la risorsa data in input non rispetta il formato
            // della risorsa xml specificata dallo standard
            // ritorno un codice di errore 422 per le regole di business
            // vedere: https://www.hl7.org/fhir/http.html#create
            http_response_code(422);
        } catch (UnsupportedOperationException $e) {
            // il metodo POST non e' stato implementato dalla
            // risorsa pertanto ritorno un errore
            $view->display_raw(OperationOutcome::getXML($e->getMessage()));
            http_response_code(422);
        } catch (ResourceNotFoundException $e) {
            $view->display_raw(OperationOutcome::getXML($e->getMessage()));
            http_response_code(404);
        } catch (UserAlreadyExistsException $e) {
            $view->display_raw(OperationOutcome::getXML($e->getMessage()));
            http_response_code(422);
        } catch (IdNotFoundInDatabaseException $e) {
            $view->display_raw(OperationOutcome::getXML($e->getMessage()));
            http_response_code(422);
        }
        
        break;
    case "PUT":
        // se non e' specificato un id nell'url allora ritorno un errore
        // poiche' la create deve contenere l'id
        if (empty($url_content['id'])) {
            $view->display_raw(OperationOutcome::getXML("ID not found in url"));
            http_response_code(400);
            exit();
        }

        $xml_content = file_get_contents("php://input");
        $content_type = $_SERVER['CONTENT_TYPE'];

        // controllo che il content type rispetti quello specificato
        // dallo standard
        if ($content_type != 'application/xml-fhir') {
            $view->display_raw(OperationOutcome::getXML("invalid Content-Type"));
            http_response_code(400);
            exit();
        }

        // costruisco dinamicamente un oggetto risorsa
        // ed eseguo il metodo per aggiornare il contenuto xml
        // nel database
        try {
            
            $resource = new ResourceFactory($url_content['type']);
            $resource->putData($url_content['id'], $xml_content);
                
            $resource_url = 'http://' . $_SERVER['HTTP_HOST'] . '/fhir/' .
                $url_content['type'] . '/' . $url_content['id'];
            header('Location: ' . $resource_url);

            http_response_code(200);

        } catch (MatchException $e) {
            $view->display_raw(OperationOutcome::getXML($e->getMessage()));
            http_response_code(400);
        } catch (UnsupportedOperationException $e) {
            // se il metodo PUT non e' stato implementato dalla
            // risorsa ritorno un errore
            $view->display_raw(OperationOutcome::getXML($e->getMessage()));
            http_response_code(422);
        } catch (ResourceNotFoundException $e) {
            $view->display_raw(OperationOutcome::getXML($e->getMessage()));
            http_response_code(404);
        } catch (InvalidResourceFieldException $e) {
            $view->display_raw(OperationOutcome::getXML($e->getMessage()));
            http_response_code(422);
        } catch (IdNotFoundInDatabaseException $e) {
            $view->display_raw(OperationOutcome::getXML($e->getMessage()));
            http_response_code(404);
        }
        
        break;
    case "DELETE":
        // e' necessario fornire l'id della risorsa da eliminare nell'url
        // della richiesta
        if (empty($url_content['id'])) {
            $view->display_raw(OperationOutcome::getXML("ID not found in url"));
            http_response_code(400);
            exit();
        }

        try {
            $resource = new ResourceFactory($url_content['type']);
            $resource->deleteData($url_content['id']);

            http_response_code(200);

        } catch (UnsupportedOperationException $e) {
            $view->display_raw(OperationOutcome::getXML($e->getMessage()));
            http_response_code(405);
        } catch (ResourceNotFoundException $e) {
            $view->display_raw(OperationOutcome::getXML($e->getMessage()));
            http_response_code(404);
        } catch (IdNotFoundInDatabaseException $e) {
            $view->display_raw(OperationOutcome::getXML($e->getMessage()));
            http_response_code(404);
        } catch (DeleteRequestRefusedException $e) {
            // questa eccezione viene lanciata se il metodo pur effettuando
            // una delete nel database non riesce ad eliminarla
            $view->display_raw(OperationOutcome::getXML($e->getMessage()));
            http_response_code(405);
        }

        break;
    default:
        http_response_code(400); //RETURN DI DEFAULT
}

?>