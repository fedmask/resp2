<?php

namespace App\Http\Controllers;

use App\Http\Resources\VoxTesterCollection;
use App\Http\Resources\VoxTesterResource;
use App\Models\VoxTester;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class VoxTesterController extends Controller
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
        return VoxTesterCollection::collection(VoxTester::all());
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

        $audios = $request->audio;
        $i = 1;
        foreach ($audios as $audio) {

            $voxtester = new VoxTester;
            $voxtester->id_utente = Auth::user()->id_utente;
            $voxtester->date = $request->date;

            $fileaudio = $audio;
            $fileaudio = str_replace('data:audio/wav;base64,','', $fileaudio);
            $fileaudio = str_replace(' ', '+', $fileaudio);
            $fileaudioName = date('Ymdhi') . "$i" . '.wav';
            Storage::put('/uploads/voxtester/' . $fileaudioName, base64_decode($fileaudio));
            $voxtester->audio = '/uploads/voxtester/' . $fileaudioName;


            $voxtester->save();

            $i+=1;
        }

        return response([
            'data' => new VoxTesterResource($voxtester)
        ], Response::HTTP_CREATED);



    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\VoxTester  $voxTester
     * @return \Illuminate\Http\Response
     */
    public function show(VoxTester $voxTester)
    {
        return new VoxTesterResource($voxTester);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\VoxTester  $voxTester
     * @return \Illuminate\Http\Response
     */
    public function edit(VoxTester $voxTester)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\VoxTester  $voxTester
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, VoxTester $voxTester)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\VoxTester  $voxTester
     * @return \Illuminate\Http\Response
     */
    public function destroy(VoxTester $voxTester)
    {
        //
    }
}
