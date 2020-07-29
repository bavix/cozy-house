<?php

namespace App\Http\Middleware;

use Closure;

class TokenInBodyAuthorization
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
        if ($request->input('token')) {
            $request->headers->set('Authorization', 'Bearer ' . $request->input('token'));
            $request->headers->set('content-type', 'application/json');
            $request->headers->set('accept', 'application/json');
        }

        return $next($request);
    }
}
