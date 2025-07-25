<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;

class SetLocale
{
    public function handle($request, Closure $next)
    {
        $locale = session('locale', 'uz');
        if (in_array($locale, ['uz', 'ru', 'en'])) {
            App::setLocale($locale);
        }
        return $next($request);
    }
} 