<?php

namespace App\Http\Middleware;

use Closure;

class Employee
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
        if (\Auth::check() && (\Auth::user()->hasRole("vendor") || \Auth::user()->hasRole("employee"))) {
            return $next($request);
        }
        else if (\Auth::check()) {
            return response("You're forbidden to handle vendor work", 403);
        }
        else {
            return redirect("vendor/login");
        }
    }
}
