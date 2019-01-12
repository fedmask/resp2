<?php

namespace App\Http\Controllers;

use App\Models\HbMeter;
use Illuminate\Support\Facades\Auth;

class IoTController extends Controller
{
    public function index(){

        $hbmeters = HbMeter::where('id_utente', Auth::id())->orderBy('id_hbmeter', 'desc')->get();

        return view("pages.iot", compact('hbmeters'));
    }
}
