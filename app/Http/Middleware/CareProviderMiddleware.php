<?php

namespace App\Http\Middleware;

use App\Models\CurrentUser\User;
use Closure;
use Auth;

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
            return redirect('unauthorized_request');
        }

        return $next($request);
    }
}
