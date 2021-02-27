<?php

namespace App\Http\Middleware;
//use Illuminate\Http\Request;

use Closure;

class SetLocale
{
    public function handle($request, Closure $next)
    {
        app()->setLocale(config('app.locale'));
        if(session()->has('locale')) {
            app()->setLocale(session('locale'));
        }

        /* //--Automatically with their preferred language
        if (Session::has('locale')) {
            $locale = Session::get('locale', Config::get('app.locale'));
        } else {
            $locale = substr($request->server('HTTP_ACCEPT_LANGUAGE'), 0, 2);

            if ($locale != 'fr' && $locale != 'en') {
                $locale = 'en';
            }
        }

        App::setLocale($locale);
        */

        return $next($request);
    }
}
