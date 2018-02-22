<?php

require_once("FHIRResource.php");

/*

N.B.
la risorsa Patient utilizza diverse estensioni tra cui blood-type.
Ci sono estensioni che servono per acquisire informazioni sull'utente presente
nel sistema che e' legato al paziente, queste estensioni sono user-id e user-fields.

user-id: sara' utilizzata per aggiornare la risorsa quindi con user-id si
specifica semplicamente l'id dell'utente a cui corrisponde il paziente;
user-fields: e' invece una estensione che contiene tutti i campi della
tabella utenti presente nel database. Questa estensione sara' utilizzata in fase
di creazione e visualizzazione della risorsa in maniera tale da creare un
nuovo utente ogni qualvolta si crea un nuovo paziente nel sistema.

*/

class Patient extends FHIRResource {
	public function __construct() {}

    function deleteResource($id) {
        if (empty(getInfo('idutente', 'pazienti', 'idutente = ' . $id))) {
            throw new IdNotFoundInDatabaseException("resource with the id provided doesn't exist in database");
        }

        # -----------------------------------------
        # ELIMINO I DATI DAL DATABASE

        $query_delete = 'DELETE FROM pazienti WHERE idutente = "' . $id . '"';
        executeQuery($query_delete);

        // effettuo un nuovo controllo per verificare se la risorsa e' stata
        // effettivamente eliminata

        if (!empty(getInfo('idutente', 'pazienti', 'idutente = ' . $id))) {
            throw new DeleteRequestRefusedException("can't delete resources with id provided");
        }
    }

    function updateResource($id, $xml) {
        $xml_values = simplexml_load_string($xml);
        $json = json_encode($xml_values);
        $array_data = json_decode($json, true);

        if (empty(getInfo('idutente', 'pazienti', 'idutente = ' . $id))) {
            throw new IdNotFoundInDatabaseException("resource with the id provided doesn't exist in database");
        }

        $db_values = array(
            'idutente' => '',
            'nome' => '',
            'cognome' => '',
            'datanascita' => '',
            'indirizzo' => '',
            'comunenascita' => '',
            'comuneresidenza' => '',
            'sesso' => '',
            'grupposanguigno' => '',
            'telefono' => '',
        );

        $encrypted_values = array();

        # -----------------------------------------
        # PARSO I DATI DAL DOCUMENTO XML

        // controllo che l'id passato come URL coincida con il campo id della
        // risorsa xml passata come input

        if ($id != $array_data['id']['@attributes']['value']) {
            throw new MatchException('ID provided in url doesn\'t match the one in XML resource');
        }

        // prelevo il nome del paziente
        if (!empty($array_data['name']['family']['@attributes']['value']) &&
            !empty($array_data['name']['given']['@attributes']['value'])) {
            $db_values['nome'] = $array_data['name']['given']['@attributes']['value'];
            $db_values['cognome'] = $array_data['name']['family']['@attributes']['value'];
        } else {
            throw new InvalidResourceFieldException('invalid care provider name and surname');
        }

        // prelevo i campi delle estensioni
        foreach($array_data['extension'] as $extension_element) {
            switch ($extension_element['@attributes']['url']) {
                case 'http://'.$_SERVER['HTTP_HOST'].'/resources/extensions/user-id.xml':
                    $db_values['idutente'] = $extension_element['valueString']['@attributes']['value'];
                    break;
                case 'http://'.$_SERVER['HTTP_HOST'].'/resources/extensions/blood-type.xml';
                    $db_values['grupposanguigno'] = $extension_element['valueString']['@attributes']['value'];
                    break;
                default:
                    throw new InvalidResourceFieldException('an extension is missing');
            }
        }

        // prelevo la data di nascita
        if (!empty($array_data['birthDate']['@attributes']['value'])) {
            $db_values['datanascita'] = $array_data['birthDate']['@attributes']['value'];
        } else {
            throw new InvalidResourceFieldException('invalid patient birthdate');
        }

        // prelevo l'indirizzo di residenza del paziente
        if (!empty($array_data['address']['line']['@attributes']['value'])) {
            $db_values['indirizzo'] = $array_data['address']['line']['@attributes']['value'];
        } else {
            throw new InvalidResourceFieldException('invalid patient address field');
        }

        // prelevo il comune

        if (!empty($array_data['address']['city']['@attributes']['value'])) {
            $db_values['comunenascita'] = $array_data['address']['city']['@attributes']['value'];
            $db_values['comuneresidenza'] = $db_values['comunenascita'];
        } else {
            throw new InvalidResourceFieldException('invalid comune field');
        }

        // prelevo il genere del paziente
        if (!empty($array_data['gender']['@attributes']['value'])) {
            $gender = $array_data['gender']['@attributes']['value'];

            switch($gender) {
                case 'female':
                    $db_values['sesso'] = 'F';
                    break;
                case 'male':
                    $db_values['sesso'] = 'M';
                    break;
                case 'other':
                    $db_values['sesso'] = 'O';
                    break;
            }
        } else {
            throw new InvalidResourceFieldException('invalid patient gender');
        }

        // prelevo il numero di telefono
        if (!empty($array_data['telecom']['value']['@attributes']['value'])) {
            $db_values['telefono'] = $array_data['telecom']['value']['@attributes']['value'];
        } else {
            throw new InvalidResourceFieldException('invalid phone number');
        }

        //print_r($db_values);

        # -----------------------------------------
        # INSERISCO I DATI PARSATI NEL DATABASE

        // cripto i valori presi dal file xml dato che la tabella mysql
        // pazienti accetta i dati in formato blob

        foreach ($db_values as $key => $value) {
            if ($key == 'idutente') {
                // salto al valore successivo nell'array
                // in modo da non criptare anche l'idutente
                continue;
            }

            $data_values[$key] = new Data($db_values[$key]);
            $encrypted_values[$key] = serializeData(encryptData($data_values[$key]));
        }

        # -----------------------------------------
        # AGGIORNO I DATI PARSATI NEL DATABASE

        // query di inserimento che verra' eseguita
        $query_update = 'UPDATE pazienti SET ' .
            'nome = "' . $encrypted_values['nome'] . '", ' .
            'cognome = "' . $encrypted_values['cognome'] . '", ' .
            'datanascita = "' . $encrypted_values['datanascita'] . '", ' .
            'indirizzo = "' . $encrypted_values['indirizzo'] . '", ' .
            'comunenascita = "' . $encrypted_values['comunenascita'] . '", ' .
            'comuneresidenza = "' . $encrypted_values['comuneresidenza'] . '", ' .
            'sesso = "' . $encrypted_values['sesso'] . '", ' .
            'grupposanguigno = "' . $encrypted_values['grupposanguigno'] . '", ' .
            'telefono = "' . $encrypted_values['telefono'] . '", ' .
            'donatoreorgani = "0" ' .
            'WHERE idutente = ' . $id;

        executeQuery($query_update);
    }

	function createResource($xml) {

		// converto il documento in formato json
        // per accedere facilmente alla struttura con un
        // array associativo php
        $xml_values = simplexml_load_string($xml);
        $json = json_encode($xml_values);
        $array_data = json_decode($json, true);

        //echo var_dump($array_data);

        $db_values = array(
            'idutente' => '',
            'nome' => '',
            'cognome' => '',
            'datanascita' => '',
            'indirizzo' => '',
            'comunenascita' => '',
            'comuneresidenza' => '',
            'sesso' => '',
            'grupposanguigno' => '',
            'telefono' => '',
        );

        // valori del database dell'utente a cui corrisponde la risorsa Patient

        $db_values_user = array(
            'id' => '',

            'username' => '',
            'password' => '',
            'pin' => '',
            'codicefiscale' => '',
            'stato' => '',
            'scadenza' => '',
            'codiceruolo' => '',
            'email' => '',
            'active' => '',
            'confKey' => '',

            'salt' => '',
        );

        $encrypted_values = array();

        # -----------------------------------------
        # PARSO I DATI DAL DOCUMENTO XML

        if (!empty($array_data['id']['@attributes']['value'])) {
            throw new IdFoundInCreateException('invalid id specified in CREATE');
        }

        // prelevo il nome del paziente
        if (!empty($array_data['name']['family']['@attributes']['value']) &&
            !empty($array_data['name']['given']['@attributes']['value'])) {
            $db_values['nome'] = $array_data['name']['family']['@attributes']['value'];
            $db_values['cognome'] = $array_data['name']['given']['@attributes']['value'];
        } else {
            throw new InvalidResourceFieldException('invalid care provider name and surname');
        }

        // prelevo i campi delle estensioni
        foreach($array_data['extension'] as $extension_element) {
            switch ($extension_element['@attributes']['url']) {
                case 'http://'.$_SERVER['HTTP_HOST'].'/resources/extensions/user-fields.xml':

                    // itero su tutte le altre sotto estensioni dell'estensione user-fields
                    // in maniera da prelevare gli altri campi per la creazione del nuovo utente
                    foreach($extension_element['extension'] as $inner_ext) {
                        switch ($inner_ext['@attributes']['url']) {
                            case 'username':
                                $db_values_user['username'] = $inner_ext['valueString']['@attributes']['value'];
                            break;
                            case 'password':
                                $db_values_user['password'] = $inner_ext['valueString']['@attributes']['value'];
                            break;
                            case 'pin':
                                $db_values_user['pin'] = $inner_ext['valueString']['@attributes']['value'];
                            break;
                            case 'codicefiscale':
                                $db_values_user['codicefiscale'] = $inner_ext['valueString']['@attributes']['value'];
                            break;
                            case 'stato':
                                $db_values_user['stato'] = $inner_ext['valueString']['@attributes']['value'];
                            break;
                            case 'scadenza':
                                $db_values_user['scadenza'] = $inner_ext['valueString']['@attributes']['value'];
                            break;
                            case 'codiceruolo':
                                $db_values_user['codiceruolo'] = $inner_ext['valueString']['@attributes']['value'];
                            break;
                            case 'email':
                                $db_values_user['email'] = $inner_ext['valueString']['@attributes']['value'];
                            break;
                            case 'active':
                                $db_values_user['active'] = $inner_ext['valueString']['@attributes']['value'];
                            break;
                            case 'confKey':
                                $db_values_user['confKey'] = $inner_ext['valueString']['@attributes']['value'];
                            break;
                            case 'salt':
                                $db_values_user['salt'] = $inner_ext['valueString']['@attributes']['value'];
                            break;
                            default:
                                throw new InvalidResourceFieldException('an inner extension is missing');
                        }
                    }

                    break;
                case 'http://'.$_SERVER['HTTP_HOST'].'/resources/extensions/blood-type.xml';
                    $db_values['grupposanguigno'] = $extension_element['valueString']['@attributes']['value'];
                    break;
                default:
                    throw new InvalidResourceFieldException('an extension is missing');
            }
        }

        // prelevo la data di nascita
        if (!empty($array_data['birthDate']['@attributes']['value'])) {
            $db_values['datanascita'] = $array_data['birthDate']['@attributes']['value'];
        } else {
            throw new InvalidResourceFieldException('invalid patient birthdate');
        }

        // prelevo l'indirizzo di residenza del paziente
        if (!empty($array_data['address']['line']['@attributes']['value'])) {
            $db_values['indirizzo'] = $array_data['address']['line']['@attributes']['value'];
        } else {
            throw new InvalidResourceFieldException('invalid patient address field');
        }

        // prelevo il comune

        if (!empty($array_data['address']['city']['@attributes']['value'])) {
            $db_values['comunenascita'] = $array_data['address']['city']['@attributes']['value'];
            $db_values['comuneresidenza'] = $db_values['comunenascita'];
        } else {
            throw new InvalidResourceFieldException('invalid comune field');
        }

        // prelevo il genere del paziente
        if (!empty($array_data['gender']['@attributes']['value'])) {
            $gender = $array_data['gender']['@attributes']['value'];

            switch($gender) {
                case 'female':
                    $db_values['sesso'] = 'F';
                    break;
                case 'male':
                    $db_values['sesso'] = 'M';
                    break;
                case 'other':
                    $db_values['sesso'] = 'O';
                    break;
            }
        } else {
            throw new InvalidResourceFieldException('invalid patient gender');
        }

        // prelevo il numero di telefono
        if (!empty($array_data['telecom']['value']['@attributes']['value'])) {
            $db_values['telefono'] = $array_data['telecom']['value']['@attributes']['value'];
        } else {
            throw new InvalidResourceFieldException('invalid phone number');
        }

        // controllo che nel database non esista un altro paziente con lo stesso username

        if (!empty(getInfo('username', 'utenti', 'username = "' . $db_values_user['username'] . '"'))) {
            throw new UserAlreadyExistsException('cannot create resource Patient because username specified via extension already exists');
        }

        //print_r($db_values);

        # -----------------------------------------
        # INSERISCO I DATI PARSATI NEL DATABASE

        // per prima cosa creo il nuovo utente a cui associare la risorsa Patient

        $query_insert = 'INSERT INTO utenti (id, username, password, pin, codicefiscale, stato, scadenza, codiceruolo, email, active, confKey) VALUES (NULL, "' .
            $db_values_user['username'] . '", "' .
            $db_values_user['password'] . '", ' .
            (empty($db_values_user['pin']) ? 'NULL' : '"' . $db_values_user['pin'] . '"') . ', "' .
            $db_values_user['codicefiscale'] . '", "' .
            $db_values_user['stato'] . '", "' .
            $db_values_user['scadenza'] . '", "' .
            $db_values_user['codiceruolo'] . '", "' .
            $db_values_user['email'] . '", "' .
            $db_values_user['active'] . '", "' .
            $db_values_user['confKey'] . '")';

        executeQuery($query_insert);

        // se tutto e' andato a buon fine, prelevo l'id del nuovo record appena creato nel database per l'utente

        $db_values_user['id'] = getInfo('id', 'utenti', 'username = "' . $db_values_user['username'] . '"');

        if (empty($db_values_user['id'])) {
            throw new InvalidResourceFieldException('impossible to create username in database');
        }

        $db_values['idutente'] = $db_values_user['id'];

        // salvo il salt della password nel file Users.xml

        $xml = simplexml_load_file($_SERVER['DOCUMENT_ROOT']."modello PBAC/Users.xml");

        $newSalt = $xml->addChild('Utente');
        $newSalt->addChild('username', $db_values_user['username']);
        $newSalt->addChild('salt', $db_values_user['salt']);

        $dom = new DOMDocument;
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput   = true;
        $dom->loadXML($xml->asXML());

        $f = fopen($_SERVER['DOCUMENT_ROOT']."modello PBAC/Users.xml","w");
        fwrite($f,$dom->saveXML());
        fclose($f);

		// inserisco i dati effettivi del paziente nel database

        // cripto i valori presi dal file xml dato che la tabella mysql
        // pazienti accetta i dati in formato blob

        foreach ($db_values as $key => $value) {
            if ($key == 'idutente') {
                // salto al valore successivo nell'array
                // in modo da non criptare anche l'idutente
                continue;
            }

            $data_values[$key] = new Data($db_values[$key]);
            $encrypted_values[$key] = serializeData(encryptData($data_values[$key]));
        }

        $query_insert = 'INSERT INTO pazienti (id, idutente, nome, cognome,' .
                                ' datanascita, indirizzo,' .
                                ' comunenascita, comuneresidenza,' .
                                ' sesso, grupposanguigno, telefono, donatoreorgani)' .
         ' VALUES (NULL, ' . $db_values['idutente'] . ', "'  . $encrypted_values['nome'] . '", "' . $encrypted_values['cognome'] . '", "' . $encrypted_values['datanascita'] . '", "'. $encrypted_values['indirizzo'] . '", "' . $encrypted_values['comunenascita'] . '", "' . $encrypted_values['comuneresidenza'] . '", "' . $encrypted_values['sesso'] . '", "' . $encrypted_values['grupposanguigno'] . '", "' . $encrypted_values['telefono'] . '", "0")';

        executeQuery($query_insert);

        $value_id = $db_values['idutente'];

        return $value_id;
	}

	function getResource($id)
	{
		//Recupero i dati del paziente avente l' ID richiesto
		$idutente = $id;

        if (empty(getInfo('idutente', 'pazienti', 'idutente = ' . $id))) {
            throw new IdNotFoundInDatabaseException("resource with the id provided doesn't exist in database");
        }

        // prelevo i dati dell'utente da mostrare come estensione
        $db_values = array(
            'username' => getInfo('username', 'utenti', 'id = ' . $idutente),
            'password' => getInfo('password', 'utenti', 'id = ' . $idutente),
            'pin' => getInfo('pin', 'utenti', 'id = ' . $idutente),
            'codicefiscale' => getInfo('codicefiscale', 'utenti', 'id = ' . $idutente),
            'stato' => getInfo('stato', 'utenti', 'id = ' . $idutente),
            'scadenza' => getInfo('scadenza', 'utenti', 'id = ' . $idutente),
            'codiceruolo' => getInfo('codiceruolo', 'utenti', 'id = ' . $idutente),
            'email' => getInfo('email', 'utenti', 'id = ' . $idutente),
            'active' => getInfo('active', 'utenti', 'id = ' . $idutente),
            'confKey' => getInfo('confKey', 'utenti', 'id = ' . $idutente),

            'salt' => '',
        );

        // prelevo il salt della password dal file xml

        $xml_values = simplexml_load_file($_SERVER['DOCUMENT_ROOT'] . "modello PBAC/Users.xml");
        $json = json_encode($xml_values);
        $array_data = json_decode($json, true);

        foreach ($array_data['Utente'] as $user) {
            if ($user['username'] == $db_values['username']) {
                $db_values['salt'] = $user['salt'];
            }
        }

        // prelevo il resto dei dati del paziente dal database

        $paziente_gruppo_sanguigno = "";
        if (getInfo('grupposanguigno', 'pazienti', 'idutente = ' . $idutente) != "")
            $paziente_gruppo_sanguigno = decryptData(deserializeData(getInfo('grupposanguigno', 'pazienti', 'idutente = ' . $idutente)));

		//dichiaro la variabile in modo tale che se non vi è il relativo valore nel DB, il sistema non vada in crash
		$nome_utente = "";
		if(getInfo('nome', 'pazienti', 'idutente = ' . $idutente)!="")
			$nome_utente = decryptData(deserializeData(getInfo('nome', 'pazienti', 'idutente = ' . $idutente)));

		//dichiaro la variabile in modo tale che se non vi è il relativo valore nel DB, il sistema non vada in crash
		$cognome_utente ="";
		if(getInfo('cognome', 'pazienti', 'idutente = ' . $idutente)!="")
			$cognome_utente = decryptData(deserializeData(getInfo('cognome', 'pazienti', 'idutente = ' . $idutente)));

		//dichiaro la variabile in modo tale che se non vi è il relativo valore nel DB, il sistema non vada in crash
		$data_nascita = "";
		if(getInfo('datanascita', 'pazienti', 'idutente = ' . $idutente)!="")
			$data_nascita = decryptData(deserializeData(getInfo('datanascita', 'pazienti', 'idutente = ' . $idutente)));

		//dichiaro la variabile in modo tale che se non vi è il relativo valore nel DB, il sistema non vada in crash
		$data_morte ="";
		if(getInfo('datamorte', 'pazienti', 'idutente = ' . $idutente)!="")
			$data_morte = decryptData(deserializeData(getInfo('datamorte', 'pazienti', 'idutente = ' . $idutente)));

		//dichiaro la variabile in modo tale che se non vi è il relativo valore nel DB, il sistema non vada in crash
		$indirizzo = "";
		if(getInfo('indirizzo', 'pazienti', 'idutente = ' . $idutente)!="")
			$indirizzo = decryptData(deserializeData(getInfo('indirizzo', 'pazienti', 'idutente = ' . $idutente)));

		//dichiaro la variabile in modo tale che se non vi è il relativo valore nel DB, il sistema non vada in crash
		$comunenascita = "";
		if(getInfo('comunenascita', 'pazienti', 'idutente = ' . $idutente)!="")
			$comunenascita = decryptData(deserializeData(getInfo('comunenascita', 'pazienti', 'idutente = ' . $idutente)));

		//dichiaro la variabile in modo tale che se non vi è il relativo valore nel DB, il sistema non vada in crash
		$comuneresidenza = "";
		if(getInfo('comuneresidenza', 'pazienti', 'idutente = ' . $idutente)!="")
			$comuneresidenza = decryptData(deserializeData(getInfo('comuneresidenza', 'pazienti', 'idutente = ' . $idutente)));

		//dichiaro la variabile in modo tale che se non vi è il relativo valore nel DB, il sistema non vada in crash
		$sesso = "";
		if(getInfo('sesso', 'pazienti', 'idutente = ' . $idutente)!="")
			$sesso = decryptData(deserializeData(getInfo('sesso', 'pazienti', 'idutente = ' . $idutente)));

		//dichiaro la variabile in modo tale che se non vi è il relativo valore nel DB, il sistema non vada in crash
		$telefono = "";
		if(getInfo('telefono', 'pazienti', 'idutente = ' . $idutente)!="")
			$telefono = decryptData(deserializeData(getInfo('telefono', 'pazienti', 'idutente = ' . $idutente)));

		//dichiaro la variabile in modo tale che se non vi è il relativo valore nel DB, il sistema non vada in crash
		$stato_matrimoniale = "";
		if(getInfo('statomatrimoniale', 'pazienti', 'idutente = ' . $idutente)!="")
			$stato_matrimoniale = decryptData(deserializeData(getInfo('statomatrimoniale', 'pazienti', 'idutente = ' . $idutente)));

		$citta = "";
		if(getInfo('comune', 'pazienti', 'idutente = ' . $idutente)!="")
			$citta = decryptData(deserializeData(getInfo('comune', 'pazienti', 'idutente = ' . $idutente)));

		//dichiaro la variabile in modo tale che se non vi è il relativo valore nel DB, il sistema non vada in crash
		$cap = "";
		if(getInfo('cap', 'pazienti', 'idutente = ' . $idutente)!="")
			$cap = decryptData(deserializeData(getInfo('cap', 'pazienti', 'idutente = ' . $idutente)));

		//dichiaro la variabile in modo tale che se non vi è il relativo valore nel DB, il sistema non vada in crash
		$stato= "";
		if(getInfo('nazione', 'pazienti', 'idutente = ' . $idutente)!="")
			$stato= decryptData(deserializeData(getInfo('nazione', 'pazienti', 'idutente = ' . $idutente)));

		//dichiaro la variabile in modo tale che se non vi è il relativo valore nel DB, il sistema non vada in crash
		$pref_stato = "";
		if(getInfo('prefisso_stato', 'pazienti', 'idutente = ' . $idutente)!="")
			$pref_stato = decryptData(deserializeData(getInfo('prefisso_stato', 'pazienti', 'idutente = ' . $idutente)));

		//Recupero la foto del paziente dal DB
		$foto = getInfo('nome', 'data', "idproprietario = " . $idutente." AND tipologia =  	'Immagine profilo'");
		//$foto = openImage(null,'Immagine profilo',  $idutente);

		//Recupero tutti i contatti di emergeza del Paziente
		$emergencyContacts = "";
		if(count(getArray('id','contattoemergenza','id='.$idutente))>0)
			$emergencyContacts = getArray('id','contattoemergenza','id='.$idutente);

		//dichiaro le variabili in modo tale che se non vi sono i relativi valori nel DB, il sistema non vada in crash
		$nome_contatto = array();
		$numero_contatto = array();
		$relazione_contatto	= array();
		$ncontattiemergenza = "";

		//Se vi sono contatti di emergenza per il paziente ne valorizzo le relative infomazioni richieste dalla risorsa
		if($emergencyContacts != null){
			$ncontattiemergenza = count($emergencyContacts);

			for($i=0; $i<$ncontattiemergenza; $i++){
				//Controllo che il campo non sia  vuoto
				if(getInfo('nome', 'contattoemergenza', 'idutente = ' . $emergencyContacts[$i])!="")
					$nome_contatto[$i] = decryptData(deserializeData(getInfo('nome', 'contattoemergenza', 'idutente = ' . $emergencyContacts[$i])));
				//Controllo che il campo non sia  vuoto
				if(getInfo('numero', 'contattoemergenza', 'idutente = ' . $emergencyContacts[$i])!="")
					$numero_contatto[$i] = decryptData(deserializeData(getInfo('numero', 'contattoemergenza', 'idutente = ' . $emergencyContacts[$i]))); //solo digits
				//Controllo che il campo non sia  vuoto
				if(getInfo('tipo_contatto', 'contattoemergenza', 'idutente = ' . $emergencyContacts[$i])!="")
					$relazione_contatto[$i] = decryptData(deserializeData(getInfo('tipo_contatto', 'contattoemergenza', 'idutente = ' . $emergencyContacts[$i])));
				else $relazione_contatto[$i]="";
			}

		}

		//Recupero tutti i Careprovider del paziente
		$careproviders = getArray('id','careproviderpersona','id='.$idutente);

		//dichiaro la variabile in modo tale che se non vi è il relativo valore nel DB, il sistema non vada in crash
		$id_careprovider = array();

		//dichiaro la variabile in modo tale che se non vi è il relativo valore nel DB, il sistema non vada in crash
		$ncareproviders = "";
		if($careproviders != null){
			$ncareproviders = count($careproviders);
			for($i=0; $i<$ncareproviders; $i++){
				$id_careprovider[$i] = getInfo('id', 'careproviderpersona', 'idutente = ' . $careproviders[$i]);
			}

		}

		//Associo ad ogni codice dello stato civile il corrispettivo valore testuale in italiano
		$maritalstatus = $stato_matrimoniale;
		if($maritalstatus=="")
		  $maritalstatus = "Nessuno";
		elseif($maritalstatus=="A")
			  $maritalstatus = "Annullato";
		elseif($maritalstatus=="D")
			  $maritalstatus = "Divorziato";
		elseif($maritalstatus=="I")
			  $maritalstatus = "Interlocutorio";
		elseif($maritalstatus=="L")
			  $maritalstatus = "Legalmente Separato";
		elseif($maritalstatus=="M")
			  $maritalstatus = "Sposato";
		elseif($maritalstatus=="P")
			  $maritalstatus = "Poligamo";
		elseif($maritalstatus=="S")
			  $maritalstatus = "Mai Sposato";
		elseif($maritalstatus=="T")
			  $maritalstatus = "Convivente";
		elseif($maritalstatus=="W")
			  $maritalstatus = "Vedovo";

		//Creazione del documento XML per il paziente

		//Creazione di un oggetto dom con la codifica UTF-8
		$dom = new DOMDocument('1.0', 'utf-8');

		//Creazione del nodo Patient, cioè il nodo Root  della risorsa
		$patient = $dom->createElement('Patient');
		//Valorizzo il namespace della risorsa e del documento XML, in  questo caso la specifica FHIR
		$patient->setAttribute('xmlns', 'http://hl7.org/fhir');
		//Corrello l'elemento con il nodo superiore
		$patient = $dom->appendChild($patient);


		//Creazione del nodo ID sempre presente nelle risorse FHIR
		$id = $dom->createElement('id');
		//Il valore dell'ID è il valore dell'ID nella relativa tabella del DB
		$id->setAttribute('value', $idutente);
		$id = $patient->appendChild($id);


		//Creazione della parte narrativa in XHTML e composta da tag HTML visualizzabili se aperto il file XML in un Browser
		$narrative = $dom->createElement('text');
		//Corrello l'elemento con il nodo superiore
		$narrative = $patient->appendChild($narrative);


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


		//Creazione di una riga
		$tr = $dom->createElement('tr');
		$tr = $tbody->appendChild($tr);

		//Creazione della colonna Name
		$td = $dom->createElement('td',"Name");
		$td = $tr->appendChild($td);

		//Creazione della colonna con il valore di nome e cognome del paziente
		$td = $dom->createElement('td', $nome_utente." ".$cognome_utente);
		$td = $tr->appendChild($td);


		//Creazione di una riga
		$tr = $dom->createElement('tr');
		$tr = $tbody->appendChild($tr);


		//Creazione della colonna BirthDate
		$td = $dom->createElement('td',"BirthDate");
		$td = $tr->appendChild($td);


		//Creazione della colonna con il valore di data di nascita del paziente
		$td = $dom->createElement('td', $data_nascita);
		$td = $tr->appendChild($td);


		//Creazione di una riga
		$tr = $dom->createElement('tr');
		$tr =$tbody->appendChild($tr);


		//Creazione della colonna Contact
		$td = $dom->createElement('td',"Contact");
		$td = $tr->appendChild($td);


		//Creazione della colonna con il valore del contatto telefonico
		$td = $dom->createElement('td',$telefono);
		$td = $tr->appendChild($td);


		//Creazione di una riga
		$tr = $dom->createElement('tr');
		$tr = $tbody->appendChild($tr);


		//Creazione della colonna City
		$td = $dom->createElement('td',"City");
		$td = $tr->appendChild($td);


		//Creazione della colonna con il valore del comune di residenza
		$td = $dom->createElement('td',$comuneresidenza);
		$td = $tr->appendChild($td);


		//Creazione di una riga
		$tr = $dom->createElement('tr');
		$tr = $tbody->appendChild($tr);


		//Creazione della colonna Address
		$td = $dom->createElement('td',"Address");
		$td = $tr->appendChild($td);


		///Creazione della colonna con il valore dell'indirizzo
		$td = $dom->createElement('td',$indirizzo);
		$td = $tr->appendChild($td);


		//Creazione di una riga
		$tr = $dom->createElement('tr');
		$tr = $tbody->appendChild($tr);


		//Creazione della colonna State
		$td = $dom->createElement('td',"State");
		$td = $tr->appendChild($td);


		//Creazione della colonna con il valore dello stato di residenza
		$td = $dom->createElement('td',$stato." ".$pref_stato);
		$td = $tr->appendChild($td);


		//Creazione di una riga
		$tr = $dom->createElement('tr');
		$tr = $tbody->appendChild($tr);


		//Creazione della colonna Marital Status
		$td = $dom->createElement('td',"Marital Status");
		$td = $tr->appendChild($td);


		//Creazione della colonna con il valore di stato civile
		$td = $dom->createElement('td',$maritalstatus);
		$td = $tr->appendChild($td);

        // creo l'estensione per indicare il gruppo sanguigno
        $node_extension = $dom->createElement('extension');
        $node_extension->setAttribute('url', 'http://'.$_SERVER['HTTP_HOST'].'/resources/extensions/blood-type.xml');
        $node_extension = $patient->appendChild($node_extension);

        $node_valueString = $dom->createElement('valueString');
        $node_valueString->setAttribute('value', $paziente_gruppo_sanguigno);
        $node_valueString = $node_extension->appendChild($node_valueString);

        // creazione del nodo extension che rappresenta i vari campi dell'utente a cui
        // corrisponde il paziente della risorsa

        $node_extension_fields = $dom->createElement('extension');
        $node_extension_fields->setAttribute('url', 'http://'.$_SERVER['HTTP_HOST'].'/resources/extensions/user-fields.xml');
        $node_extension_fields = $patient->appendChild($node_extension_fields);

        foreach($db_values as $i => $value) {
            $node_inner_extension = $dom->createElement('extension');
            $node_inner_extension->setAttribute('url', $i);
            $node_inner_extension = $node_extension_fields->appendChild($node_inner_extension);

            $node_valueString = $dom->createElement('valueString');
            $node_valueString->setAttribute('value', $value);
            $node_valueString = $node_inner_extension->appendChild($node_valueString);
        }

		//Creazione del nodo identifier identificativo della risorsa Patient attraverso URI della risorsa
		$identifier = $dom->createElement('identifier');
		$identifier = $patient->appendChild($identifier);
		//Creazione del nodo use con valore fisso ad usual
		$use = $dom->createElement('use');
		$use->setAttribute('value', 'usual');
		$use = $identifier->appendChild($use);
		//Creazione del nodo system che identifica il namespace degli URI per identificare la risorsa
		$system = $dom->createElement('system');
		$system->setAttribute('value', 'urn:ietf:rfc:3986');  //RFC gestione URI
		$system = $identifier->appendChild($system);
		//Creazione del nodo value
		$value = $dom->createElement('value');
		//Do il valore all' URI della risorsa
		$value->setAttribute('value', "../fhir/Patient/".$idutente);
		$value = $identifier->appendChild($value);


		//Creazione del nodo active settato a true in quanto la risorsa è attiva per il FSEM
		$active = $dom->createElement('active');
		$active->setAttribute('value', 'true');
		$active = $patient->appendChild($active);


		//Creazione del nodo per il nominativo del paziente
		$name = $dom->createElement('name');
		$name = $patient->appendChild($name);
		//Creazione del nodo use settato sempre al valore usual
		$use = $dom->createElement('use');
		$use->setAttribute('value', 'usual');
		$use = $name->appendChild($use);
		//Creazione del nodo family che indica il nome dalla famiglia di provenienza, quindi il cognome del paziente
		$family = $dom->createElement('family');
		$family->setAttribute('value', $cognome_utente);
		$family = $name->appendChild($family);
		//Creazione del nodo given che indica il nome di battesimo dato al paziente
		$given = $dom->createElement('given');
		$given->setAttribute('value', $nome_utente);
		$given = $name->appendChild($given);



		//Creazione del nodo telecom con il contatto telefonico del paziente
		$telecom = $dom->createElement('telecom');
		$telecom = $patient->appendChild($telecom);
		//Creazione del nodo system che indica che il contatto è un valore telefonico
		$system = $dom->createElement('system');
		$system->setAttribute('value', 'phone');
		$system = $telecom->appendChild($system);
		//Creazione del nodo value che contiene il valore del numero di telefono del paziente
		$value = $dom->createElement('value');
		$value->setAttribute('value', $telefono);
		$value = $telecom->appendChild($value);
		//Creazione del nodo use che indica la tipologia di numero di telefono
		$use = $dom->createElement('use');
		//Contro se il numero di telefono è di un mobile o fisso
		if($telefono[0]=="3")
			$use->setAttribute('value', 'mobile');
		elseif($telefono[0]=="0")
			$use->setAttribute('value', 'home');
		$use = $telecom->appendChild($use);


		//Creazione del nodo gender per il sesso del paziente
		$gender = $dom->createElement('gender');
		//Controllo se il sesso salvato nel FSEM sia maschio o femmina e do il valore all'attributo con codifica HL7
		if($sesso=="M")
			$sex="male";
		else
			$sex="female";
		$gender->setAttribute('value', $sex);
		$gender = $patient->appendChild($gender);


		//Creazione del nodo birthdate con la data di nascita del paziente
		$birthDate = $dom->createElement('birthDate');
		$birthDate->setAttribute('value', $data_nascita);
		$birthDate = $patient->appendChild($birthDate);


		//Effettuo il controllo sulla data di decesso del paziente
		if($data_morte=="")
		{
			//Se la data di decesso non esiste allora setto a false il valore del nodo deceasedBoolean
			$deceasedBoolean = $dom->createElement('deceasedBoolean');
			$deceasedBoolean->setAttribute('value', 'false');
			$deceasedBoolean = $patient->appendChild($deceasedBoolean);
		}
		else
		{
			//Se la data di decesso esiste allora la inserisco
			$deceasedDateTime = $dom->createElement('deceasedDateTime');
			$deceasedDateTime->setAttribute('value', $data_morte);
			$deceasedDateTime = $patient->appendChild($deceasedDateTime);
		}


		//Creazione del nodo address per i dati relativi al recapito del paziente
		$address = $dom->createElement('address');
		$address = $patient->appendChild($address);
		//Creazione del nodo use che indica che il recapito è relativo alla casa di residenza
		$use = $dom->createElement('use');
		$use->setAttribute('value', 'home');
		$use = $address->appendChild($use);
		//Creazione del nodo line che indica l'indirizzo di residenza
		$line = $dom->createElement('line');
		$line->setAttribute('value', $indirizzo);
		$line = $address->appendChild($line);
		//Creazione del nodo city che indica la città di residenza
		$city = $dom->createElement('city');
		$city->setAttribute('value', $comuneresidenza);
		$city = $address->appendChild($city);
		//Creazione del nodo postalCode che indica il codice postale di residenza
		$postalCode = $dom->createElement('postalCode');
		$postalCode->setAttribute('value', $cap);
		$postalCode = $address->appendChild($postalCode);
		//Creazione del nodo country che indica lo stato di residenza
		$country = $dom->createElement('country');
		$country->setAttribute('value', $pref_stato);
		$country = $address->appendChild($country);


		//Creazione del nodo maritalStatus cioè lo stato civile del paziente
		$maritalStatus = $dom->createElement('maritalStatus');
		$maritalStatus = $patient->appendChild($maritalStatus);
		//Creazione del nodo coding che indica la codifica usata
		$coding = $dom->createElement('coding');
		$coding = $maritalStatus->appendChild($coding);
		//Creazione del nodo system che indica il value set da cui confrontare la validità dei codici
		$system = $dom->createElement('system');
		$system->setAttribute('value', "http://hl7.org/fhir/v3/MaritalStatus"); //value set HL7
		$system = $coding->appendChild($system);
		//Creazione del nodo code con codice dello stato civile
		$code = $dom->createElement('code');
		$code->setAttribute('value', $stato_matrimoniale);
		$code = $coding->appendChild($code);
		//Creazione del nodo dysplay cioè la visualizzazione dello stato civile
		$dysplay = $dom->createElement('display');
		//Do il valore all' attributo del tag
		$dysplay->setAttribute('value', $maritalstatus );
		$dysplay = $coding->appendChild($dysplay);


		//Controllo che ci sia una foto relativa al paziente
		if($foto!=""){
			//Creazione del nodo photo se esiste la foto del paziente
			$photo = $dom->createElement('photo');
			$photo = $patient->appendChild($photo);
			//Creazione del nodo contentType che indica l'estensione e quindi il tipo di foto
			$contentType = $dom->createElement('contentType');
			$contentType->setAttribute('value', 'image/jpeg');
			$contentType = $photo->appendChild($contentType);
			//Creazione del nodo url che contiene l'indirizzo in cui si trova la foto
			$url = $dom->createElement('url');
			$url->setAttribute('value', "../files/uploads/".$foto);
			$url = $photo->appendChild($url);
			/*$data = $dom->createElement('data');
			$data->setAttribute('value', $foto);
			$data = $photo->appendChild($data);*/
		}

		//Inserisco tutti i contatti di emergenza in quanto possono essere più di uno
		for($i=0; $i<$ncontattiemergenza; $i++)
		{
			$contact = $dom->createElement('contact');
			$contact = $patient->appendChild($contact);
			//Creazione del nodo relationship indicante la relazione che intercorre fra paziente e contatto
			$relationship = $dom->createElement('relationship');
			$relationship = $contact->appendChild($relationship);
			$coding = $dom->createElement('coding');
			$coding = $relationship->appendChild($coding);
			//Creazione del nodo system dal quale recupero il value set delle tipologie di contatti
			$system = $dom->createElement('system');
			$system->setAttribute('value', 'http://hl7.org/fhir/patient-contact-relationship');
			$system = $coding->appendChild($system);
			//Creazione del nodo code avente il valore della tipologia di contatto
			$code = $dom->createElement('code');
			$code->setAttribute('value', $relazione_contatto[$i]);
			$code = $coding->appendChild($code);
			//Creazione del nodo name con il nominativo del contatto
			$name = $dom->createElement('name');
			$name = $contact->appendChild($name);
			//Creazione del nodo use settato sempre a usual
			$use = $dom->createElement('use');
			//Do il valore all' attributo del tag
			$use->setAttribute('value', 'usual');
			$use = $name->appendChild($use);
			//Creazione del nodo text in cui inserisco il valore del nominativo del contatto
			$text = $dom->createElement('text');
			$text->setAttribute('value', $nome_contatto[$i]);
			$text = $name->appendChild($text);
			//Creazione del nodo telecom per il recapito del contatto di emergenza
			$telecom = $dom->createElement('telecom');
			$telecom = $contact->appendChild($telecom);
			//Creazione del nodo system che indica che il recapito è un numero telefonico
			$system = $dom->createElement('system');
			$system->setAttribute('value', 'phone');
			$system = $telecom->appendChild($system);
			//Creazione del nodo value contenente il numero telefonico del contatto
			$value = $dom->createElement('value');
			$value->setAttribute('value', $numero_contatto[$i]);
			$value = $telecom->appendChild($value);
			//Creazione del nodo use che indica se il numero di telefono è fisso o mobile
			$use = $dom->createElement('use');
			//Controllo se il primo carattere del numero è 3 e in questo caso è un numero mobile altrimenti è un fisso
			if($numero_contatto[$i][0]=="3")
				$use->setAttribute('value', 'mobile');
			elseif($numero_contatto[$i][0]=="0")
				$use->setAttribute('value', 'home');
			$use = $telecom->appendChild($use);
		}


		//Creazione del nodo communication per indicare la lingua di comunicazione del paziente
		$communication = $dom->createElement('communication');
		$communication = $patient->appendChild($communication);
		//Creazione del nodo coding
		$coding = $dom->createElement('coding');
		$coding = $communication->appendChild($coding);
		//Creazione del nodo system in cui si indica il value set dell' IETF
		$system = $dom->createElement('system');
		$system->setAttribute('value', 'https://tools.ietf.org/html/bcp47');
		$system = $coding->appendChild($system);
		//Creazione del nodo code che indica il codice della lingua parlata, in questo caso l'italiano perche tutti i pazienti del FSEM usano l'italiano
		$code = $dom->createElement('code');
		$code->setAttribute('value', 'it');
		$code = $coding->appendChild($code);
		//Creazione del nodo display per visualizzazione testuale del valore della lingua
		$display = $dom->createElement('display');
		//Do il valore all' attributo del tag
		$display->setAttribute('value', 'Italiano');
		$display = $coding->appendChild($display);


		//Creo il riferimento a tutti i careprovider selezionati dal paziente
		for($i=0; $i<$ncareproviders; $i++)
		{
			//Creazione del nodo careProvider che è in relazione alla risorsa Practitioner
			$careProvider = $dom->createElement('careProvider');
			$careProvider = $patient->appendChild($careProvider);
			//Creazione del nodo reference per inserire il riferimento alla relativa risorsa Practitioner
			$reference = $dom->createElement('reference');
			$reference->setAttribute('value', "../fhir/Practitioner/".$id_careprovider[$i]);
			$reference = $careProvider->appendChild($reference);
		}

		//Elimino gli spazi bianchi superflui per la viasualizzazione grafica dell'XML
		$dom->preserveWhiteSpace = false;
		//Formatto il documento per l'output
		$dom->formatOutput = true;
		//Salvo il documento XML nella cartella rsources dando come nome, l'id del paziente
		//$dom->save("../fhir/Patient/".$idutente.".xml");

		return $dom->saveXML();
	}
}

?>
