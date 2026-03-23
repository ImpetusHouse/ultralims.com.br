<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class UTMTracker
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $utmParams = ['utm_source', 'utm_medium', 'utm_campaign'];

        foreach ($utmParams as $param) {
            if ($request->has($param)) {
                Cookie::queue($param, $request->query($param), 60 * 24 * 30); // Cookie válido por 30 dias
            }
        }

        return $next($request);
    }
}
