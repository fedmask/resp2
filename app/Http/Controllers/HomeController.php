<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Patient\Taccuino;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        
        //$records = array();
        if($user->getRole() == $user::PATIENT_DESCRIPTION){    //Dovrebbe essere il paziente
            $records = Taccuino::where('id_paziente', $user->patient()->first()->id_paziente)->get();
        }
        return view('pages.taccuino')->with('records', $records);
    }
}
