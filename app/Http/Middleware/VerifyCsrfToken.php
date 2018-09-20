<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;
use Illuminate\Session\TokenMismatchException;
use Closure;


class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        "/fhir/Patient",
    ];
    
    
    public function handle($request, Closure $next)
    {
    	if($request->cookie('consent') == null){
    		return $next($request);
    	}
    	
    	if (
    			$this->isReading($request) ||
    			$this->runningUnitTests() ||
    			$this->inExceptArray($request) ||
    			$this->tokensMatch($request)
    			) {
    				return $this->addCookieToResponse($request, $next($request));
    			}
    			
    			throw new TokenMismatchException;
    }
    
}
