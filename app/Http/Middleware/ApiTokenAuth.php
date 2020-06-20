<?php

namespace App\Http\Middleware;

use Closure;

class ApiTokenAuth
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
        $token = $request->header('X-API-TOKEN');
        if (env('API_AUTH_TOKEN') != $token) {
            abort(401, 'Unauthorized');
        }
        return $next($request);
    }
}
