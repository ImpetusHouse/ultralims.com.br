<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AuthenticateUser
{
    public function handle($request, Closure $next, $guard = null)
    {
        // Verifica se o usuário está autenticado usando o guard padrão
        if (Auth::guard($guard)->check() && Auth::guard($guard)->user() instanceof \App\Models\User) {
            return $next($request);
        }

        // Redireciona para a página de login se o usuário não for do tipo esperado
        if ($request->ajax() || $request->wantsJson()) {
            return response('Unauthorized.', 401);
        } else {
            return redirect()->route('auth.login');
        }
    }
}
