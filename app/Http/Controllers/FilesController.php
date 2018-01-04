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

        $file_model = File::create([
            'id_paziente' => Input::get('idPatient'),
            'id_audit_log' => Input::get('idLog'),
            'id_file_confidenzialita' => Input::get('confidentiality'),
            'file_nome' => $file->getClientOriginalName(),
            'file_commento' => Input::get('comment'),
        ]);

        $file_model->save();
        //$file->store("patient/".Input::get('idPatient'), $file->getClientOriginalName(), 'local');
        
        //Storage::disk('public')->putFileAs("/patient/".Input::get('idPatient'), $file, $file->getClientOriginalName(), 'public'); 
        $file->storeAs("patient/".Input::get('idPatient'), $file->getClientOriginalName(), 'public');
		return Redirect::back();
	}

	/**
	* Cancella un file tra quelli associati ad un paziente
	*/
	public function deleteFile(){
		Storage::disk('public')->delete('patient/'.Input::get('id_patient').'/'.Input::get('name'));
		File::where('file_nome', Input::get('name'))->where('id_paziente', Input::get('id_patient'))->first()->delete();
		return Redirect::back();
	}
	
}
