<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChangeLanguageController extends Controller
{
    public function __invoke($locale)
    {
        if (in_array($locale, config('app.supportedLocales'))) {
            session(['locale' => $locale]);
            app()->setLocale($locale);
        }

        // Redirect back to the previous URL, replacing the locale segment
        $previousUrl = url()->previous();
        $parsedUrl = parse_url($previousUrl);

        $path = $parsedUrl['path'] ?? '/';
        $segments = explode('/', ltrim($path, '/'));

        // Replace the locale segment
        if (in_array($segments[0], config('app.supportedLocales'))) {
            $segments[0] = $locale;
        } else {
            array_unshift($segments, $locale);
        }

        $newUrl = url(implode('/', $segments));

        return redirect($newUrl);
    }
}
