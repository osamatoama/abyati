<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response;

class Localize
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $sessionLocale = session('locale');
        $cookieLocale = Cookie::get('locale');
        $availableLocales = array_keys(config('locales'));

        if ($sessionLocale && in_array($sessionLocale, $availableLocales)) {
            $locale = $sessionLocale;
        } elseif ($cookieLocale && in_array($cookieLocale, $availableLocales)) {
            $locale = $cookieLocale;
        } else {
            $locale = config('app.locale');
        }

        app()->setLocale($locale);
        Carbon::setLocale($locale);

        return $next($request);
    }
}
