<?php

namespace App\Http\Middleware;

use Closure;

class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (\Session::has('locale')) {
            \App::setLocale(\Session::get('locale'));

            // You know default language in locale is english

            // So for this middleware will change language by session  

        }
        return $next($request);
    }
}
