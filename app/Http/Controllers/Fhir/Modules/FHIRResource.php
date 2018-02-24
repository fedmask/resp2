<?php

namespace App\Http\Controllers\Fhir\Modules;

// Classe astratta da cui derivano tutte le altre risorse
// che devono garantire i servizi REST

abstract class FHIRResource {
    abstract function getResource($id);
    abstract function createResource($xml);
    abstract function updateResource($id, $xml);
    abstract function deleteResource($id);
}

?>