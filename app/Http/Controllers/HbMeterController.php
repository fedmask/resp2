<?php

namespace App\Http\Controllers;

use App\Http\Resources\HbMeterCollection;
use App\Http\Resources\HbMeterResource;
use App\Models\HbMeter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class HbMeterController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api')->except('index', 'show');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return HbMeterCollection::collection(HbMeter::all());
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
        $hbmeter = new HbMeter;
        $hbmeter->id_utente = Auth::user()->id_utente;
        $hbmeter->analisi_giorno = $request->analisi_giorno;
        $hbmeter->analisi_valore = $request->analisi_valore;

        $hbmeter->save();

        return response([
            'data' => new HbMeterResource($hbmeter)
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\HbMeter  $hbMeter
     * @return \Illuminate\Http\Response
     */
    public function show(HbMeter $hbMeter)
    {
        return new HbMeterResource($hbMeter);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HbMeter  $hbMeter
     * @return \Illuminate\Http\Response
     */
    public function edit(HbMeter $hbMeter)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\HbMeter  $hbMeter
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HbMeter $hbMeter)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HbMeter  $hbMeter
     * @return \Illuminate\Http\Response
     */
    public function destroy(HbMeter $hbMeter)
    {
        //
    }
}
