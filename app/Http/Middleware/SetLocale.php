<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $locale = $request->segment(1); // Get the first URL segment

        if (in_array($locale, config('app.supportedLocales'))) {
            App::setLocale($locale);
        } else {
            $locale = config('app.fallback_locale');
            App::setLocale($locale);
        }

        return $next($request);
    }
}