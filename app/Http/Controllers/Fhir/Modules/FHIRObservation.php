<?php
namespace App\Http\Controllers\Fhir\Modules;

use App\Exceptions\FHIR as FHIR;
use App\Models\InvestigationCenter\CentriIndagini;
use App\Models\InvestigationCenter\Indagini;
use App\Models\Icd9\Icd9EsamiStrumentiCodici;
use Illuminate\Http\Request;
use View;
use Illuminate\Filesystem\Filesystem;
use File;
use Orchestra\Parser\Xml\Facade as XmlParser;
use Exception;
use DB;
use Redirect;
use Response;
use SimpleXMLElement;
use DOMDocument;
use Input;
use App\Models\CareProviders\CareProvider;
use DateTime;
use DateTimeZone;
use Date;
use Carbon\Carbon;

class FHIRObservation
{

    public function show($id)
    {
        $indagine = Indagini::where('id_indagine', $id)->first();
        
        if (! $indagine) {
            throw new FHIR\IdNotFoundInDatabaseException("resource with the id provided doesn't exist in database");
        }
        
        $values_in_narrative = array(
            "Identifier" => "RESP-OBSERVATION" . "-" . $indagine->getId(),
            "Status" => $indagine->getStatusDisplay(),
            "Category" => $indagine->getCategoryDisplay(),
            "Code" => $indagine->getCodeDisplay(),
            "Subject" => "FHIR-PATIENT-" . $indagine->getIdPaziente(),
            "EffectivePeriod" => $indagine->getDataFine(),
            "Issued" => $indagine->getIssued(),
            "Performer" => "FHIR-PRACTITIONER-" . $indagine->getIdCpp(),
            "Interpretation" => $indagine->getInterpretationDisplay()
        );
        
        $data_xml["narrative"] = $values_in_narrative;
        $data_xml["indagine"] = $indagine;
        
        return view("pages.fhir.observation", [
            "data_output" => $data_xml
        ]);
    }

    public function store(Request $request)
    {
        $file = $request->file('file');
        $id_paziente = Input::get('patient_id');
        
        $xml = XmlParser::load($file->getRealPath());
        
        $id = $xml->parse([
            'identifier' => [
                'uses' => 'identifier.value::value'
            ]
        ]);
        
        $indagini = Indagini::all();
        
        foreach ($indagini as $i) {
            if ($i->id_indagine == $id['identifier']) {
                throw new Exception("Indagine is already exists");
            }
        }
        
        $lettura = $xml->parse([
            'identifier' => [
                'uses' => 'identifier.value::value'
            ],
            'status' => [
                'uses' => 'status::value'
            ],
            'category' => [
                'uses' => 'category.coding.code::value'
            ],
            'code' => [
                'uses' => 'code.coding.code::value'
            ],
            'subject' => $id_paziente, // subject = patient = paziente loggato che importa la risorsa
            
            'effectivePeriod' => [
                'uses' => 'effectivePeriod.start::value'
            ],
            'issued' => [
                'uses' => 'issued::value'
            ],
            'performer' => [
                'uses' => 'performer.display::value' // cpp
            ],
            'interpretation' => [
                'uses' => 'interpretation.coding.code::value'
            ]
        
        ]);
        
        $explode = explode(" ", $lettura['performer']);
        $cppName = $explode[0];
        $cppSurname = $explode[1];
        
        $id_cpp = CareProvider::where([
            [
                'cpp_nome',
                '=',
                $cppName
            ],
            [
                'cpp_cognome',
                '=',
                $cppSurname
            ]
        ])->first()->id_cpp;
        
       
        $carbon = new Carbon($lettura['issued']);
        $date = Carbon::parse($lettura['issued'])->toDateTimeString();
  
        
        $indagine = array(
            'id_indagine' => $lettura['identifier'],
            'id_paziente' => $lettura['subject'],
            'id_cpp' => $id_cpp,
            'careprovider' => $lettura['performer'],
            'indagine_data' => $lettura['effectivePeriod'],
            'indagine_data_fine' => $lettura['effectivePeriod'],
            'indagine_aggiornamento' => '2018-04-03',
            'indagine_stato' => $lettura['status'],
            'indagine_issued' => $date,
            'indagine_category' => $lettura['category'],
            'indagine_code' => $lettura['code'],
            'indagine_interpretation' => $lettura['interpretation'],
            
        );
        
        $addIndagine = new Indagini();
        
        foreach ($indagine as $key => $value) {
            if (empty($value)) {
                continue;
            }
            $addIndagine->$key = $value;
        }
        
        $addIndagine->save();
        
        return response()->json($lettura['identifier'], 201);
        
    }
    
    
    public function update(Request $request, $id)
    {
        $file = $request->file('fileUpdate');
        $id_paziente = Input::get('patient_id');
        
        $xml = XmlParser::load($file->getRealPath());
        
        $id_ind = $xml->parse([
            'identifier' => [
                'uses' => 'identifier.value::value'
            ]
        ]);
        
        
        if($id != $id_ind['identifier'] ){
            throw new Exception("ERROR");
        }
        
            if (!Indagini::find($id_ind['identifier'])) {
                throw new Exception("Observation does not exist in the database");
            }
        
        
        $lettura = $xml->parse([
            'identifier' => [
                'uses' => 'identifier.value::value'
            ],
            'status' => [
                'uses' => 'status::value'
            ],
            'category' => [
                'uses' => 'category.coding.code::value'
            ],
            'code' => [
                'uses' => 'code.coding.code::value'
            ],
            'subject' => $id_paziente, // subject = patient = paziente loggato che importa la risorsa
            
            'effectivePeriod' => [
                'uses' => 'effectivePeriod.start::value'
            ],
            'issued' => [
                'uses' => 'issued::value'
            ],
            'performer' => [
                'uses' => 'performer.display::value' // cpp
            ],
            'interpretation' => [
                'uses' => 'interpretation.coding.code::value'
            ]
            
        ]);
        
        $explode = explode(" ", $lettura['performer']);
        $cppName = $explode[0];
        $cppSurname = $explode[1];
        
        $id_cpp = CareProvider::where([
            [
                'cpp_nome',
                '=',
                $cppName
            ],
            [
                'cpp_cognome',
                '=',
                $cppSurname
            ]
        ])->first()->id_cpp;
        
        
        $carbon = new Carbon($lettura['issued']);
        $date = Carbon::parse($lettura['issued'])->toDateTimeString();
        
        
        $indagine = array(
            'id_indagine' => $lettura['identifier'],
            'id_paziente' => $lettura['subject'],
            'id_cpp' => $id_cpp,
            'careprovider' => $lettura['performer'],
            'indagine_data' => $lettura['effectivePeriod'],
            'indagine_data_fine' => $lettura['effectivePeriod'],
            'indagine_aggiornamento' => '2018-04-03',
            'indagine_stato' => $lettura['status'],
            'indagine_issued' => $date,
            'indagine_category' => $lettura['category'], 
            'indagine_code' => $lettura['code'],
            'indagine_interpretation' => $lettura['interpretation'],
            
        );
        
        $updInd = Indagini::find($id_ind['identifier']);
        
        
        foreach ($indagine as $key => $value) {
            if (empty($value)) {
                continue;
            }
            $updInd->$key = $value;
        }
        
        $updInd->save();
        
        return response()->json($id, 200);
    }
}

?>