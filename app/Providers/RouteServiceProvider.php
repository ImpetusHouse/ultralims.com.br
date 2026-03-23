<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Vinkla\Hashids\Facades\Hashids;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });

        Route::bind('user', function($value, $route) {
            return Hashids::decode($value)[0] ?? 0;
        });
        //-----------------------------------------------------------// - PUBLICAÇÕES
        Route::bind('article', function($value, $route) {
            return Hashids::decode($value)[0] ?? 0;
        });
        //-----------------------------------------------------------// - PÁGINAS
        Route::bind('page', function($value, $route) {
            return Hashids::decode($value)[0] ?? 0;
        });
        Route::bind('prompt', function($value, $route) {
            return Hashids::decode($value)[0] ?? 0;
        });
        //-----------------------------------------------------------// - GERAL
        Route::bind('card', function($value, $route) {
            return Hashids::decode($value)[0] ?? 0;
        });
        Route::bind('alert', function($value, $route) {
            return Hashids::decode($value)[0] ?? 0;
        });
        Route::bind('testimonial', function($value, $route) {
            return Hashids::decode($value)[0] ?? 0;
        });
        Route::bind('event', function($value, $route) {
            return Hashids::decode($value)[0] ?? 0;
        });
        Route::bind('faq', function($value, $route) {
            return Hashids::decode($value)[0] ?? 0;
        });
        Route::bind('gallery', function($value, $route) {
            return Hashids::decode($value)[0] ?? 0;
        });
        Route::bind('topic', function($value, $route) {
            return Hashids::decode($value)[0] ?? 0;
        });
        Route::bind('logosCategory', function($value, $route) {
            return Hashids::decode($value)[0] ?? 0;
        });
        Route::bind('magazine', function($value, $route) {
            return Hashids::decode($value)[0] ?? 0;
        });
        Route::bind('portfolio', function($value, $route) {
            return Hashids::decode($value)[0] ?? 0;
        });
        Route::bind('product', function($value, $route) {
            return Hashids::decode($value)[0] ?? 0;
        });
        //-----------------------------------------------------------// - Ultra Lims
        Route::bind('banner', function($value, $route) {
            return Hashids::decode($value)[0] ?? 0;
        });
        Route::bind('cookie', function($value, $route) {
            return Hashids::decode($value)[0] ?? 0;
        });
        //-----------------------------------------------------------// - III
        Route::bind('member', function($value, $route) {
            return Hashids::decode($value)[0] ?? 0;
        });
        Route::bind('researchCenter', function($value, $route) {
            return Hashids::decode($value)[0] ?? 0;
        });
        Route::bind('research', function($value, $route) {
            return Hashids::decode($value)[0] ?? 0;
        });
        //-----------------------------------------------------------// - TICKET
        Route::bind('preAwnser', function($value, $route) {
            return Hashids::decode($value)[0] ?? 0;
        });
        Route::bind('reasonsRefusal', function($value, $route) {
            return Hashids::decode($value)[0] ?? 0;
        });
        Route::bind('awnser', function($value, $route) {
            return Hashids::decode($value)[0] ?? 0;
        });
        Route::bind('ticket', function($value, $route) {
            return Hashids::decode($value)[0] ?? 0;
        });
        //-----------------------------------------------------------// - SETTINGS
        Route::bind('group', function($value, $route) {
            return Hashids::decode($value)[0] ?? 0;
        });
        Route::bind('redirect', function($value, $route) {
            return Hashids::decode($value)[0] ?? 0;
        });
        Route::bind('email', function($value, $route) {
            return Hashids::decode($value)[0] ?? 0;
        });
        Route::bind('menu', function($value, $route) {
            return Hashids::decode($value)[0] ?? 0;
        });
        Route::bind('font', function($value, $route) {
            return Hashids::decode($value)[0] ?? 0;
        });
    }
}
