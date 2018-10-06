<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AnamnesiController extends Controller
{
    public function showAnamnesi(){

        return view('pages.anamnesi');
    }
}
