<?php

namespace App\Http\Controllers;

use App\Models\HbMeter;
use App\Models\VoxTester;
use Illuminate\Support\Facades\Auth;

class IoTController extends Controller
{
    public function index(){

        $voxtesters = VoxTester::where('id_utente', Auth::id())->orderBy('id_voxtester', 'desc')->get();
        $hbmeters = HbMeter::where('id_utente', Auth::id())->orderBy('id_hbmeter', 'desc')->get();

        return view("pages.iot", compact('voxtesters','hbmeters'));
    }
}
