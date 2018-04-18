<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\SendMail;
use App\Mail\SuggestionsMailer;
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
    
    /**
     * Gestisce l'invio di una mail da parte dell'utente loggato ad un Care Provider
     *
     */
    public function mail($cpp,$paz,$ogg,$testo){
		Mail::to($cpp)->send(new SendMail($paz,$ogg,$testo));
		return Redirect::back();
    }

}