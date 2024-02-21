<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class Language
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
{
    // Leer la preferencia de idioma de la cookie
    $language = $request->cookie('applocale');

    // Si la cookie existe, establecer el idioma de la aplicación
    if ($language && array_key_exists($language, config('Languages'))) {
        App::setLocale($language);
    } else {
        App::setLocale(config('app.fallback_locale'));
    }

    return $next($request);
}
}
