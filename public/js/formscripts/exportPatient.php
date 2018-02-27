<?php

include("../resources/ResourceFactory.php");
include('../resources/OperationOutcome.php');

if (isset($_GET['patientid'])) {
    $patient_id = $_GET['patientid'];

    // controllo se l'utente che sta esportando la risorsa
    // e' il care provider del paziente di cui sta chiedendo la cartella oppure
    // se e' il paziente stesso a scaricare la propria cartella

    if (isCareProvider(getRole(getMyID()))) {
        $care_provider_id = getMyID();
        $is_auth = FALSE;

        // prelevo tutti gli id dei pazienti a cui e' associato il care provider
        // che e' attualmente loggato
        $patient_ids = getArray('idutente', 'careproviderpaziente', 'idcpp = ' . $care_provider_id);

        foreach($patient_ids as $single_id) {
            if ($single_id == $patient_id) {
                // se il care provider loggato e' autorizzato
                // ad accedere al paziente inserito come GET
                // allora non sussistono problemi

                $is_auth = TRUE;
            }
        }

        if (!$is_auth) {
            echo OperationOutcome::getXML('Non hai i permessi per prelevare la cartella del paziente.');
            exit();
        }
    } else if (getCurrentID() != $_GET['patientid']) {
        echo OperationOutcome::getXML('Devi essere autenticato per scaricare la tua cartella sanitaria.');
        exit();
    }

    // dopo aver settato la variabile per l'id del paziente
    // setto alcune variabili per la configurazione degli url
    // e del file che verra' scaricato dal client

    $zip_filename = 'cartella_paziente_' . $patient_id . '.resp';

    // specifico quali risorse del protocollo FHIR
    // voglio esportare nei vari file
    $xml_resource = array(
        'Patient' => array(),
        'FamilyMemberHistory' => array(),
        'DiagnosticReport' => array(),
        'Observation' => array(),
    );

    try {
        // prelevo la risorsa paziente
        if (!empty(getInfo('id', 'pazienti', 'idutente = ' . $patient_id))) {
            $resource = new ResourceFactory('Patient');
            $xml_resource['Patient'][0] = $resource->getData($patient_id);
        } else {
             echo OperationOutcome::getXML('Il paziente con l\'ID specificato non esiste nel sistema');
             exit();
        }

        // controllo se ci sono anamnesi familiari
        if (!empty(getInfo('id', 'anamnesifamiliare_nuova', 'idpaziente = ' . $patient_id))) {
            // prelevo l'id di ogni risorsa anamnesi
            $fmh_ids = getArray('id', 'anamnesifamiliare_nuova', 'idpaziente = ' . $patient_id);

            foreach($fmh_ids as $single_id) {
                $resource = new ResourceFactory('FamilyMemberHistory');

                array_push($xml_resource['FamilyMemberHistory'],
                    $resource->getData($single_id));
            }
        }

        // controllo se ci sono diagnosi
        if (!empty(getInfo('id', 'diagnosi', 'idPaziente = ' . $patient_id))) {
            $diagnosi_ids = getArray('id', 'diagnosi', 'idPaziente = ' . $patient_id);

            foreach($diagnosi_ids as $single_id) {
                $resource = new ResourceFactory('DiagnosticReport');

                array_push($xml_resource['DiagnosticReport'], $resource->getData($single_id));
            }
        }

        // controllo se ci sono indagini
        if (!empty(getInfo('id', 'indagini', 'idpaziente = ' . $patient_id))) {
            $indagini_ids = getArray('id', 'indagini', 'idpaziente = ' . $patient_id);

            foreach($indagini_ids as $single_id) {
                $resource = new ResourceFactory('Observation');

                array_push($xml_resource['Observation'], $resource->getData($single_id));
            }
        }
    } catch (Exception $e) {
        echo OperationOutcome::getXML('Impossibile scaricare i dati del paziente');
        exit();
    }

    // codice che mi servira' per salvare tutte le risorse in un zip che
    // faro' poi scaricare all'utente

    $zip = new ZipArchive;
    $res = $zip->open($zip_filename, ZipArchive::CREATE);

    if($res === TRUE) {
        $i = 0;
        foreach($xml_resource as $name => $files) {
            foreach($files as $file) {
                $zip->addFromString($name . '_' . $i . '.xml', $file);
                $i++;
            }
        }
        $zip->close();

        // forzo il download del file zip al browser del client che effettua la richiesta

        $file_url = 'http://' . $_SERVER['HTTP_HOST'] . '/formscripts/' . $zip_filename;

        header('Content-Type: application/octet-stream');
        header("Content-Transfer-Encoding: Binary");
        header("Content-disposition: attachment; filename=\"" . basename($file_url) . "\"");

        # php black magick
        ob_clean();
        flush();

        readfile($file_url);
        
        // cancello l'archivio zip dopo averlo fatto scaricare
        unlink($zip_filename);
    } else {
        echo OperationOutcome::getXML('Impossibile creare l\'archivio ZIP');
    }

} else {
    echo OperationOutcome::getXML('Specifica l\'id del paziente');
}

?>