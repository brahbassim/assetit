<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        // Priority: 1. URL query param, 2. Session, 3. Default config
        $locale = $request->query('lang', Session::get('locale', config('app.locale', 'en')));
        
        if (in_array($locale, ['en', 'fr'])) {
            App::setLocale($locale);
            // Save to session for persistence
            Session::put('locale', $locale);
        }

        return $next($request);
    }
}
