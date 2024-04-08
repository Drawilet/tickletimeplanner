<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;

class LocaleController extends Controller
{
    /**
     * Cambia el idioma de la aplicación.
     *
     * @param string $lang El idioma al que se cambiará.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function switchLocale($locale)
    {
        if (in_array($locale, config(("app.available_locales")))) {
            return back()->withCookie(cookie()->forever('locale', $locale));
        } else
            return Redirect::back();
    }
}
