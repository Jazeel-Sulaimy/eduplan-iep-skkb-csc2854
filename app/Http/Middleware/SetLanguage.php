<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SetLanguage
{
    public function handle(Request $request, Closure $next)
    {
        $locale = session('locale');

        if (! $locale) {
            $locale = $request->cookie('locale', 'en');
        }

        if (! in_array($locale, ['en', 'ms'])) {
            $locale = 'en';
        }

        App::setLocale($locale);
        session(['locale' => $locale]);

        return $next($request);
    }
}

