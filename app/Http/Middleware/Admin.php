<?php

namespace App\Http\Middleware;

use Closure;

class Admin
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
        if(\Auth::check() && (\Auth::user()->hasRole("admin") || \Auth::user()->hasRole("owner"))) {
            return $next($request);
        }
        return response()->view('errors.forbidden', [], 403);
    }
}
