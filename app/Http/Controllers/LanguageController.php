<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class LanguageController extends Controller
{
    public function change(Request $request, $locale)
    {
        if (! in_array($locale, ['en', 'ms'])) {
            $locale = 'en';
        }

        session(['locale' => $locale]);
        App::setLocale($locale);

        return redirect()
            ->back()
            ->withCookie(cookie('locale', $locale, 60 * 24 * 30));
    }
}

