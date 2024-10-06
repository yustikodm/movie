<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function switchLang($lang): \Illuminate\Http\RedirectResponse
    {
        // Validate the incoming language
        if (in_array($lang, ['en', 'id'])) {
            // Set the application locale
            App::setLocale($lang);

            // Store the selected language in the session
            Session::put('app_locale', $lang);
        }

        return redirect()->back(); // Redirect back to the previous page
    }
}
