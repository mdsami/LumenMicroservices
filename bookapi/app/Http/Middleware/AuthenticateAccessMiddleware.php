<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Access\AuthorizationException;

class AuthenticateAccessMiddleware
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
        $validSecrets = explode(',', env('ACCEPTED_SECRETS'));

        // Search if the "Authorization" header's value is one of the values defined inside the Environment variable VALID_SECRETS 
        if(in_array($request->header('Authorization'), $validSecrets)) {
            return $next($request);
        }
        
        throw new AuthorizationException("Unauthorized.");
    }
}
