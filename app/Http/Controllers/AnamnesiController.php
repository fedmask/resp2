<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Anamnesi;
use App\Models\Patient\Pazienti;
use Auth;

class AnamnesiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $anamnesiFamiliare = Anamnesi::all();
        return view('pages.anamnesi',compact('anamnesiFamiliare'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Create Anamensi
        $anamnesi = new Anamnesi;
        $anamnesi->id_paziente = Pazienti::where('id_utente', Auth::id())->first()->id_paziente;
        $anamnesi->id_anamnesi_log = 123;
        $anamnesi->anamnesi_contenuto = $request->input('testofam');
        $anamnesi->save();

        return redirect('/anamnesi');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
