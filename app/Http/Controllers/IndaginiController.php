<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CareProviders\CppDiagnosi;
use App\Models\Diagnosis\Diagnosi;
use App\Models\CareProviders\CareProvider;
use App\Models\CurrentUser\User;
use App\Models\InvestigationCenter\Indagini;
use App\Models\InvestigationCenter\IndaginiEliminate;
use Auth;
use Carbon\Carbon;
use Redirect;

class IndaginiController extends Controller
{

    /**
     * aggiunge una indagine richiesta
     */
    public function addIndagineRichiesta($tipo, $motivo, $Cpp, $idCpp, $idPaz, $stato)
    {
        $data = Carbon::today();
        
        $var = explode("--", $motivo);
        $diagnosi = array();
        $diagnosi = Diagnosi::all();
        $ret;
        
        if (sizeof($var) > 1) {
            foreach ($diagnosi as $d) {
                if (($d->diagnosi_inserimento_data == ($var[1])) && ($d->id_paziente == $idPaz) && ($d->diagnosi_patologia == $var[0])) {
                    $ret = $d->id_diagnosi;
                }
            }
        } else {
            $ret = '0';
        }
        
        if ($ret == '0' && $idCpp != '0') {
            $indagine = Indagini::create([
                'id_paziente' => $idPaz,
                'id_cpp' => $idCpp,
                'careprovider' => $Cpp,
                'indagine_data' => $data,
                'indagine_aggiornamento' => $data,
                'indagine_stato' => $stato,
                'indagine_tipologia' => $tipo,
                'indagine_motivo' => $var[0]
            ]);
        }
        
        if ($ret == '0' && $idCpp == '0') {
            $indagine = Indagini::create([
                'id_paziente' => $idPaz,
                'careprovider' => $Cpp,
                'indagine_data' => $data,
                'indagine_aggiornamento' => $data,
                'indagine_stato' => $stato,
                'indagine_tipologia' => $tipo,
                'indagine_motivo' => $var[0]
            ]);
        }
        
        if ($ret != '0' && $idCpp == '0') {
            $indagine = Indagini::create([
                'id_diagnosi' => $ret,
                'id_paziente' => $idPaz,
                'careprovider' => $Cpp,
                'indagine_data' => $data,
                'indagine_aggiornamento' => $data,
                'indagine_stato' => $stato,
                'indagine_tipologia' => $tipo,
                'indagine_motivo' => $var[0]
            ]);
        }
        
        if ($ret != '0' && $idCpp != '0') {
            $indagine = Indagini::create([
                'id_diagnosi' => $ret,
                'id_paziente' => $idPaz,
                'id_cpp' => $idCpp,
                'careprovider' => $Cpp,
                'indagine_data' => $data,
                'indagine_aggiornamento' => $data,
                'indagine_stato' => $stato,
                'indagine_tipologia' => $tipo,
                'indagine_motivo' => $var[0]
            ]);
        }
        
        $indagine->save();
        
        return Redirect::back();
    }

    /**
     * aggiunge una indagine programmata
     */
    public function addIndagineProgrammata($tipo, $motivo, $Cpp, $idCpp, $idPaz, $stato, $idCentr, $dataVis)
    {
        $var = explode("--", $motivo);
        $diagnosi = array();
        $diagnosi = Diagnosi::all();
        $ret;
        
        if (sizeof($var) > 1) {
            foreach ($diagnosi as $d) {
                if (($d->diagnosi_inserimento_data == ($var[1])) && ($d->id_paziente == $idPaz) && ($d->diagnosi_patologia == $var[0])) {
                    $ret = $d->id_diagnosi;
                }
            }
        } else {
            $ret = '0';
        }
        
        if ($ret == '0' && $idCpp != '0') {
            $indagine = Indagini::create([
                'id_paziente' => $idPaz,
                'id_cpp' => $idCpp,
                'careprovider' => $Cpp,
                'indagine_data' => $dataVis,
                'indagine_aggiornamento' => $dataVis,
                'indagine_stato' => $stato,
                'indagine_tipologia' => $tipo,
                'indagine_motivo' => $var[0],
                'id_centro_indagine' => $idCentr
            ]);
        }
        
        if ($ret == '0' && $idCpp == '0') {
            $indagine = Indagini::create([
                'id_paziente' => $idPaz,
                'careprovider' => $Cpp,
                'indagine_data' => $dataVis,
                'indagine_aggiornamento' => $dataVis,
                'indagine_stato' => $stato,
                'indagine_tipologia' => $tipo,
                'indagine_motivo' => $var[0],
                'id_centro_indagine' => $idCentr
            ]);
        }
        
        if ($ret != '0' && $idCpp == '0') {
            $indagine = Indagini::create([
                'id_diagnosi' => $ret,
                'id_paziente' => $idPaz,
                'careprovider' => $Cpp,
                'indagine_data' => $dataVis,
                'indagine_aggiornamento' => $dataVis,
                'indagine_stato' => $stato,
                'indagine_tipologia' => $tipo,
                'indagine_motivo' => $var[0],
                'id_centro_indagine' => $idCentr
            ]);
        }
        
        if ($ret != '0' && $idCpp != '0') {
            $indagine = Indagini::create([
                'id_diagnosi' => $ret,
                'id_paziente' => $idPaz,
                'id_cpp' => $idCpp,
                'careprovider' => $Cpp,
                'indagine_data' => $dataVis,
                'indagine_aggiornamento' => $dataVis,
                'indagine_stato' => $stato,
                'indagine_tipologia' => $tipo,
                'indagine_motivo' => $var[0],
                'id_centro_indagine' => $idCentr
            ]);
        }
        
        $indagine->save();
        
        return Redirect::back();
    }

    /**
     * aggiunge una indagine programmata
     */
    public function addIndagineCompletata($tipo, $motivo, $Cpp, $idCpp, $idPaz, $stato, $idCentr, $dataVis, $referto, $allegato)
    {
        $var = explode("--", $motivo);
        $diagnosi = array();
        $diagnosi = Diagnosi::all();
        $ret;
        
        if (sizeof($var) > 1) {
            foreach ($diagnosi as $d) {
                if (($d->diagnosi_inserimento_data == ($var[1])) && ($d->id_paziente == $idPaz) && ($d->diagnosi_patologia == $var[0])) {
                    $ret = $d->id_diagnosi;
                }
            }
        } else {
            $ret = '0';
        }
        
        if ($ret == '0' && $idCpp != '0') {
            $indagine = Indagini::create([
                'id_paziente' => $idPaz,
                'id_cpp' => $idCpp,
                'careprovider' => $Cpp,
                'indagine_data' => $dataVis,
                'indagine_aggiornamento' => $dataVis,
                'indagine_stato' => $stato,
                'indagine_tipologia' => $tipo,
                'indagine_motivo' => $var[0],
                'id_centro_indagine' => $idCentr,
                'indagine_referto' => $referto,
                'indagine_allegato' => $allegato
            ]);
        }
        
        if ($ret == '0' && $idCpp == '0') {
            $indagine = Indagini::create([
                'id_paziente' => $idPaz,
                'careprovider' => $Cpp,
                'indagine_data' => $dataVis,
                'indagine_aggiornamento' => $dataVis,
                'indagine_stato' => $stato,
                'indagine_tipologia' => $tipo,
                'indagine_motivo' => $var[0],
                'id_centro_indagine' => $idCentr,
                'indagine_referto' => $referto,
                'indagine_allegato' => $allegato
            ]);
        }
        
        if ($ret != '0' && $idCpp == '0') {
            $indagine = Indagini::create([
                'id_diagnosi' => $ret,
                'id_paziente' => $idPaz,
                'careprovider' => $Cpp,
                'indagine_data' => $dataVis,
                'indagine_aggiornamento' => $dataVis,
                'indagine_stato' => $stato,
                'indagine_tipologia' => $tipo,
                'indagine_motivo' => $var[0],
                'id_centro_indagine' => $idCentr,
                'indagine_referto' => $referto,
                'indagine_allegato' => $allegato
            ]);
        }
        
        if ($ret != '0' && $idCpp != '0') {
            $indagine = Indagini::create([
                'id_diagnosi' => $ret,
                'id_paziente' => $idPaz,
                'id_cpp' => $idCpp,
                'careprovider' => $Cpp,
                'indagine_data' => $dataVis,
                'indagine_aggiornamento' => $dataVis,
                'indagine_stato' => $stato,
                'indagine_tipologia' => $tipo,
                'indagine_motivo' => $var[0],
                'id_centro_indagine' => $idCentr,
                'indagine_referto' => $referto,
                'indagine_allegato' => $allegato
            ]);
        }
        
        $indagine->save();
        
        return Redirect::back();
    }

    /**
     * modifica una indagine richiesta
     */
    public function ModIndagineRichiesta($id, $tipo, $motivo, $Cpp, $idCpp, $idPaz, $stato)
    {
        $data = Carbon::today();
        
        $var = explode("--", $motivo);
        $diagnosi = array();
        $diagnosi = Diagnosi::all();
        $ret = '0';
        
        if (sizeof($var) > 1) {
            foreach ($diagnosi as $d) {
                if (($d->diagnosi_inserimento_data == ($var[1])) && ($d->id_paziente == $idPaz) && ($d->diagnosi_patologia == $var[0])) {
                    $ret = $d->id_diagnosi;
                } else {
                    $ret = '0';
                }
            }
        }
        
        $match = [
            'id_indagine' => $id
        ];
        
        if ($ret == '0' && $idCpp != '0') {
            $editIndagine = \DB::table('tbl_indagini')->where($match)->update([
                'id_paziente' => $idPaz,
                'id_cpp' => $idCpp,
                'careprovider' => $Cpp,
                'indagine_aggiornamento' => $data,
                'indagine_stato' => $stato,
                'indagine_tipologia' => $tipo,
                'indagine_motivo' => $var[0]
            ]);
        }
        
        if ($ret == '0' && $idCpp == '0') {
            $editIndagine = \DB::table('tbl_indagini')->where($match)->update([
                'id_paziente' => $idPaz,
                'careprovider' => $Cpp,
                'indagine_aggiornamento' => $data,
                'indagine_stato' => $stato,
                'indagine_tipologia' => $tipo,
                'indagine_motivo' => $var[0]
            ]);
        }
        
        if ($ret != '0' && $idCpp == '0') {
            $editIndagine = \DB::table('tbl_indagini')->where($match)->update([
                'id_diagnosi' => $ret,
                'id_paziente' => $idPaz,
                'careprovider' => $Cpp,
                'indagine_aggiornamento' => $data,
                'indagine_stato' => $stato,
                'indagine_tipologia' => $tipo,
                'indagine_motivo' => $var[0]
            ]);
        }
        
        if ($ret != '0' && $idCpp != '0') {
            $editIndagine = \DB::table('tbl_indagini')->where($match)->update([
                'id_diagnosi' => $ret,
                'id_paziente' => $idPaz,
                'id_cpp' => $idCpp,
                'careprovider' => $Cpp,
                'indagine_aggiornamento' => $data,
                'indagine_stato' => $stato,
                'indagine_tipologia' => $tipo,
                'indagine_motivo' => $var[0]
            ]);
        }
        
        return Redirect::back();
    }

    /**
     * modifica una indagine programmata
     */
    public function ModIndagineProgrammata($id, $tipo, $motivo, $Cpp, $idCpp, $idPaz, $stato, $idCentr, $dataVis)
    {
        
        $var = explode("--", $motivo);
        $diagnosi = array();
        $diagnosi = Diagnosi::all();
        $ret = '0';
        
        if (sizeof($var) > 1) {
            foreach ($diagnosi as $d) {
                if (($d->diagnosi_inserimento_data == ($var[1])) && ($d->id_paziente == $idPaz) && ($d->diagnosi_patologia == $var[0])) {
                    $ret = $d->id_diagnosi;
                } else {
                    $ret = '0';
                }
            }
        }
        
        $match = [
            'id_indagine' => $id
        ];
        
        
        if ($ret == '0' && $idCpp != '0') {
            $editIndagine = \DB::table('tbl_indagini')->where($match)->update([
                'id_paziente' => $idPaz,
                'id_cpp' => $idCpp,
                'careprovider' => $Cpp,
                'indagine_aggiornamento' => $dataVis,
                'indagine_stato' => $stato,
                'indagine_tipologia' => $tipo,
                'indagine_motivo' => $var[0],
                'id_centro_indagine' => $idCentr
            ]);
        }
        
        if ($ret == '0' && $idCpp == '0') {
            $editIndagine = \DB::table('tbl_indagini')->where($match)->update([
                'id_paziente' => $idPaz,
                'careprovider' => $Cpp,
                'indagine_aggiornamento' => $dataVis,
                'indagine_stato' => $stato,
                'indagine_tipologia' => $tipo,
                'indagine_motivo' => $var[0],
                'id_centro_indagine' => $idCentr
            ]);
        }
        
        if ($ret != '0' && $idCpp == '0') {
            $editIndagine = \DB::table('tbl_indagini')->where($match)->update([
                'id_diagnosi' => $ret,
                'id_paziente' => $idPaz,
                'careprovider' => $Cpp,
                'indagine_aggiornamento' => $dataVis,
                'indagine_stato' => $stato,
                'indagine_tipologia' => $tipo,
                'indagine_motivo' => $var[0],
                'id_centro_indagine' => $idCentr
            ]);
        }
        
        if ($ret != '0' && $idCpp != '0') {
            $editIndagine = \DB::table('tbl_indagini')->where($match)->update([
                'id_diagnosi' => $ret,
                'id_paziente' => $idPaz,
                'id_cpp' => $idCpp,
                'careprovider' => $Cpp,
                'indagine_aggiornamento' => $dataVis,
                'indagine_stato' => $stato,
                'indagine_tipologia' => $tipo,
                'indagine_motivo' => $var[0],
                'id_centro_indagine' => $idCentr
            ]);
        }
        
        return Redirect::back();
       
    }
    
    /**
     * modifica una indagine completata
     */
    public function ModIndagineCompletata($id, $tipo, $motivo, $Cpp, $idCpp, $idPaz, $stato, $idCentr, $dataVis, $referto, $allegato)
    {
        
        $var = explode("--", $motivo);
        $diagnosi = array();
        $diagnosi = Diagnosi::all();
        $ret = '0';
        
        if (sizeof($var) > 1) {
            foreach ($diagnosi as $d) {
                if (($d->diagnosi_inserimento_data == ($var[1])) && ($d->id_paziente == $idPaz) && ($d->diagnosi_patologia == $var[0])) {
                    $ret = $d->id_diagnosi;
                } else {
                    $ret = '0';
                }
            }
        }
        
        $match = [
            'id_indagine' => $id
        ];
        
        
        if ($ret == '0' && $idCpp != '0') {
            $editIndagine = \DB::table('tbl_indagini')->where($match)->update([
                'id_paziente' => $idPaz,
                'id_cpp' => $idCpp,
                'careprovider' => $Cpp,
                'indagine_aggiornamento' => $dataVis,
                'indagine_stato' => $stato,
                'indagine_tipologia' => $tipo,
                'indagine_motivo' => $var[0],
                'id_centro_indagine' => $idCentr,
                'indagine_referto' => $referto,
                'indagine_allegato' => $allegato
            ]);
        }
        
        if ($ret == '0' && $idCpp == '0') {
            $editIndagine = \DB::table('tbl_indagini')->where($match)->update([
                'id_paziente' => $idPaz,
                'careprovider' => $Cpp,
                'indagine_aggiornamento' => $dataVis,
                'indagine_stato' => $stato,
                'indagine_tipologia' => $tipo,
                'indagine_motivo' => $var[0],
                'id_centro_indagine' => $idCentr,
                'indagine_referto' => $referto,
                'indagine_allegato' => $allegato
            ]);
        }
        
        if ($ret != '0' && $idCpp == '0') {
            $editIndagine = \DB::table('tbl_indagini')->where($match)->update([
                'id_diagnosi' => $ret,
                'id_paziente' => $idPaz,
                'careprovider' => $Cpp,
                'indagine_aggiornamento' => $dataVis,
                'indagine_stato' => $stato,
                'indagine_tipologia' => $tipo,
                'indagine_motivo' => $var[0],
                'id_centro_indagine' => $idCentr,
                'indagine_referto' => $referto,
                'indagine_allegato' => $allegato
            ]);
        }
        
        if ($ret != '0' && $idCpp != '0') {
            $editIndagine = \DB::table('tbl_indagini')->where($match)->update([
                'id_diagnosi' => $ret,
                'id_paziente' => $idPaz,
                'id_cpp' => $idCpp,
                'careprovider' => $Cpp,
                'indagine_aggiornamento' => $dataVis,
                'indagine_stato' => $stato,
                'indagine_tipologia' => $tipo,
                'indagine_motivo' => $var[0],
                'id_centro_indagine' => $idCentr,
                'indagine_referto' => $referto,
                'indagine_allegato' => $allegato
            ]);
        }
        
        return Redirect::back();
        
    }

    /**
     * elimina l'indagine selezionata
     */
    public function eliminaIndagine($getIdIndagine, $idUtente)
    {
        $match = [
            'id_indagine' => $getIdIndagine
        ];
        
        $edited_character = \DB::table('tbl_indagini')->where($match)->update([
            'indagine_stato' => '5'
        ]);
        
        $indagineElim = IndaginiEliminate::create([
            'id_utente' => $idUtente,
            'id_indagine' => $getIdIndagine
        ]);
        
        $indagineElim->save();
        
        return Redirect::back();
    }
}
