<?php 

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

/*

Eccezioni personalizzate che servono per intercettare gli
errori che si possono presentare nell'esecuzione dei servizi
REST delle singole risorse.

*/

// eccezione che che viene lanciata quando il tipo della risorsa
// non e' presente nel sistema
class ResourceNotFoundException extends Exception {}

// eccezione lanciata quando nell'url della richiesta POST
// e' presente l'id (cosa non ammessa per la CREATE)
class IdFoundInCreateException extends Exception {}

// eccezione lanciata quando un campo parsato della risorsa non e'
// valido o ci si aspettava un certo campo non trovato nella risorsa
class InvalidResourceFieldException extends Exception {}

// eccezione lanciata quando una classe che implementa i servizi
// REST, non ha implementato un servizio e quindi non supporta
// l'operazione richiesta dal client
class UnsupportedOperationException extends Exception {}

// eccezione lanciata quando l'id nell'URL della risorsa da
// modificare non coincide con l'id presente come campo
// della risorsa nel documento XML (Vedere un qualsiasi metodo updateResource)
class MatchException extends Exception {}

// eccezione lanciata quando l'id di una risorsa non e' presente
// nel database
class IdNotFoundInDatabaseException extends Exception {}

// eccezione lanciata quando pur avendo effettuato una query
// di cancellazione del record nel database, questo risulta
// ancora presente
class DeleteRequestRefusedException extends Exception {}

// durante la CREATE, se tra le estensioni che specificano
// i campi utente, l'id utente del paziente esiste gia'
// nel database allora lancio questa eccezione
class UserAlreadyExistsException extends Exception {}

?>