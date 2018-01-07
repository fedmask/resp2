<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Patient\Pazienti;
use App\Models\CurrentUser\User;
use App\Models\CurrentUser\Recapiti;
use App\Models\Domicile\Comuni;
use App\Models\File;
use Validator;
use Redirect;
use Auth;
use DB;
use Input;
use Storage;
use App;

class FilesController extends Controller
{
    /**
    * Carica un file associandolo alla cartella dell'utente loggato
    */
    public function uploadFile(Request $request){
        $file = $request->file('file_field');
        $ext = $file->guessClientExtension();

        $validator = Validator::make(Input::all(), [
            'file_field' => 'required',
            'comment' => 'required',
            'confidentiality' => 'required',
        ]);

        if ($validator->fails()) {
            return Redirect::back()
                        ->withErrors($validator)
                        ->withInput();
        }
        
        //$file->store("patient/".Input::get('idPatient'), $file->getClientOriginalName(), 'local');
        //$file->storeAs("patient/".Input::get('idPatient'), $file->getClientOriginalName(), 'local');
        
        if(Storage::disk('public')->putFileAs("/patient/".Input::get('idPatient'), $file, $file->getClientOriginalName(), 'public')){
           
            $file_model = File::create([
                'id_paziente' => Input::get('idPatient'),
                'id_audit_log' => Input::get('idLog'),
                'id_file_confidenzialita' => Input::get('confidentiality'),
                'file_nome' => $file->getClientOriginalName(),
                'file_commento' => Input::get('comment'),
            ]);
            
            $file_model->save();
            
            return Redirect::back();
            
        }else{
            //Uffaaaa... per qualche motivo il file non � stato caricato
            App::abort(500);
        }
    }

    /**
    * Cancella un file tra quelli associati ad un paziente
    */
    public function deleteFile(){
        Storage::disk('public')->delete('patient/'.Input::get('id_patient').'/'.Input::get('name'));
        File::where('file_nome', Input::get('name'))->where('id_paziente', Input::get('id_patient'))->first()->delete();
        return Redirect::back();
    }

    /**
    * Aggiorna il livello di confidenzialità associato ad un file
    */
    public function updateFileConfidentiality(){
        $file = File::where('file_nome', Input::get('name'))->where('id_paziente', Input::get('id_patient'))->first();
        $file->id_file_confidenzialita = Input::get('updateConfidentiality');
        $file->save();
        return Redirect::back();
    }
    
    public function downloadImage($photo_id){

        $user       = Auth::user();
        $user_id    = $user->patient()->first()->id_paziente;
        
        //Controllo che sia il proprietario di questa immagine. Download solo per lui
        $is_owner = File::where('id_file', $photo_id)->where('id_paziente', $user_id)->first();
        
        if($is_owner){
            $img_name   = $is_owner->file_nome;
            $path_file  = "app/public/patient/".$user_id."/".$img_name;
            
            return response()->download(storage_path($path_file));
        }else{
            //Sho! Prevedere una gestione delle risorse migliore che magari sia fatta a monte del sistema
            App::abort(403, 'Access denied ;)');
        }
    }
    
}