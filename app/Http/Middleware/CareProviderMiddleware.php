<?php

namespace App\Http\Middleware;

use App\Models\CurrentUser\User;
use Closure;
use Auth;
use App\Http\Controllers\Fhir\OperationOutcome;

class CareProviderMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        //Solo i Care Provider hanno accesso alle risorse !
        if (!Auth::check() || $request->user()->getRole() != User::CAREPROVIDER_ID)
        {
            /** TODO: Creare questa pagine per personalizzare l'errore di accesso alle risorse FHIR **/
            $error_in_xml = OperationOutcome::getXML("Per accedere alle API e' necessaria l'autenticazione come care provider!");

            return response()->view('errors.FHIR', ["errorMessage" => $error_in_xml], 401)->withHeaders(['Content-Type' => 'application/xml']);
        }

        return $next($request);
    }
}
