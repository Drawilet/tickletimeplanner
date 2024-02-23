<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;

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
        $locale = $request->cookie('locale');

        if ($locale && in_array($locale, config("app.available_locales"))) {
            App::setLocale($locale);
        } else {
            $lang = $request->getPreferredLanguage(config('app.available_locales'));
            App::setLocale($lang ?? config('app.fallback_locale'));
        }

        return $next($request);
    }
}
