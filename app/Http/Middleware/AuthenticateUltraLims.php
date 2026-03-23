<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\UltraLims\UL_User;

class AuthenticateUltraLims
{
    public function handle($request, Closure $next, $guard = 'ultralims')
    {
        // Verifica se o cookie 'user' com 'userId' está presente
        if (isset($_COOKIE['user']["'userId'"]) && isset($_COOKIE['user']["'laboratorioId'"])) {
            $user = UL_User::where('id', $_COOKIE['user']["'userId'"])->where('idLaboratorio', $_COOKIE['user']["'laboratorioId'"])->first(); // Pega o usuário com base no ID do cookie
            if ($user) {
                Auth::guard($guard)->login($user); // Loga o usuário
            }
        }

        // Verifica se o usuário está logado
        if (Auth::guard($guard)->guest()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->route('home');
            }
        }

        return $next($request);
    }
}
