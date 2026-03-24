<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Priority: 1. URL query param, 2. Cookie, 3. Session, 4. Default config
        $locale = request()->query('lang', Cookie::get('locale', Session::get('locale', config('app.locale', 'en'))));
        
        if (in_array($locale, ['en', 'fr'])) {
            App::setLocale($locale);
            // Save to session and cookie for persistence
            Session::put('locale', $locale);
            Cookie::queue('locale', $locale, 60 * 24 * 30); // 30 days
        }
    }
}
