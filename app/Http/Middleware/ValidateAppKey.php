<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ValidateAppKey
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
        $appKey = $request->header('App-Key');

        if (!$appKey || !hash_equals($appKey, str_replace('base64:', '', env('APP_KEY')))) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
