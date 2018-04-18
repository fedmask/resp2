<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\SuggestionsMailer;
use App\Mail\SendMail;
use Mail;
use Redirect;
use Validator;
use Session;

class MailController extends Controller
{
	/**
	* Gestisce l'invio di un messaggio di suggerimenti da parte di un utente
	*
	* @param  \Illuminate\Http\Request  $request
	*/
    public function sendSuggestion(Request $request)
    {
    	$validator = Validator::make($request->all(), [
            'nome' => 'required|max:40',
            'mail' => 'required|email|max:40',
            'messaggio' => 'required',
        ]);

        if ($validator->fails()) {
            return Redirect::back()
                        ->withErrors($validator)
                        ->withInput();
        }

        Mail::to('suggerimenti@fsem.eu')->send(new SuggestionsMailer);
        Session::flash('success', 'Suggerimento correttamente inviato. Grazie.'); 
        return Redirect::back();
    }
    
    public function mail($cpp, $paz, $ogg, $testo){
        
        Mail::to($cpp)->send(new sendMail($paz, $ogg, $testo));

        return Redirect::back();
    }
}
