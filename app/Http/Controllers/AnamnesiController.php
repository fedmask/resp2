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

        $userid = Pazienti::where('id_utente', Auth::id())->first()->id_paziente;
        $anamnesiFamiliare = Anamnesi::where('id_paziente', Auth::id())->get();

        return view('pages.anamnesi',compact('userid','anamnesiFamiliare'));
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
        $userid = Pazienti::where('id_utente', Auth::id())->first()->id_paziente;
        $anamnesi = Anamnesi::find($userid);
        if(isset($anamnesi->id_paziente)){
            $anamnesi->delete();
        }

        //Create Anamensi
        $anamnesi = new Anamnesi;
        $anamnesi->id_paziente = $userid;
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
        $anamnesi = Anamnesi::find($id);
        $anamnesi->anamnesi_contenuto = $request->input('testofam');
        $anamnesi->save();
        return redirect('/anamnesi');
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
