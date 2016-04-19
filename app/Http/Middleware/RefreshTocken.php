<?php

namespace App\Http\Middleware;

use app\OpenTest\Functions;
use Closure;

class RefreshTocken
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
        $response = $next($request);
        $response->headers->set('NewToken',Functions::RefreshToken());
        return $response;
    }
}
