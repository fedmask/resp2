<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PassportController extends Controller
{
    public $successStatus = 200;

    public function login(){
        if(Auth::attempt(['utente_nome' => request('utente_nome'), 'password' => request('password')])){
            $user=Auth::user();
            $success['token'] = $user->createToken('MyApp')->accessToken;
            return response()->json(['error' => false, 'token'=>$success, 'message' => 'Login Successful', 'user' => array('id_utente' =>$user->id_utente)], $this->successStatus);
        }else{
            return response()->json(['error' => true, 'token'=> null, 'message' => 'Wrong credential', 'user' => null],401);
        }
    }

    public function getDetails(){
        $user = Auth::user();
        return response()->json(['success' => $user], $this->successStatus);
    }
}
