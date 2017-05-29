<?php

namespace App\Http\Middleware;

use Closure;

class Vendor
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
        if(\Auth::check() && \Auth::user()->hasRole("vendor")) {
            return $next($request);
        }
        else if(\Auth::check()) {
            return response("You're not authorized", 403);
        }
        else {
            return redirect("vendor/login");
        }
    }
}
