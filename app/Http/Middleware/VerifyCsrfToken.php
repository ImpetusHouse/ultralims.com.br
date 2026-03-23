<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        'saveContato', '/contato/save/', 'lgpd', '/lgpd',
        'webhooks/machined/*',
        'webhooks/rankfix/*',
        'webhooks/login/*',
        'webhooks/alert/*',
        'cliente-ultra/comunicados',
        'cliente-ultra/comunicados/*',
        'apis/*'
    ];
}
