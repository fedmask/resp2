<?php
namespace App\Http\Middleware;


use Illuminate\View\Middleware\ShareErrorsFromSession;
use Closure;
use Illuminate\Support\ViewErrorBag;

class SessionErrors extends ShareErrorsFromSession
{

    public function handle($request, Closure $next)
    {
        if($request->cookie('consent') == null){
            $this->view->share('errors',new ViewErrorBag());
            return $next($request);
        }
        // If the current session has an "errors" variable bound to it, we will share
        // its value with all view instances so the views can easily access errors
        // without having to bind. An empty bag is set when there aren't errors.
        $this->view->share(
            'errors', $request->session()->get('errors') ?: new ViewErrorBag
        );

        // Putting the errors in the view for every view allows the developer to just
        // assume that some errors are always available, which is convenient since
        // they don't have to continually run checks for the presence of errors.

        return $next($request);
    }

}