<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class LanguageControllers extends Controller
{
    /**
     * Cambia el idioma de la aplicación.
     *
     * @param string $lang El idioma al que se cambiará.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function switchLeng($lang)
    {
        if (array_key_exists($lang, Config::get('Languages'))) {

            // Almacenar la preferencia de idioma en una cookie
            return back()->withCookie(cookie()->forever('applocale', $lang));
        }
        
        return Redirect::back();
    }
}
