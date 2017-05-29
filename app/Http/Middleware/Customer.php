<?php

namespace App\Http\Middleware;

use Closure;

class Customer
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
        if(\Auth::check() && \Auth::user()->hasRole("customer")) {
            return $next($request);
        }
        else if(\Auth::check()) {
            return response("You're forbidden", 403);
        }
        return redirect("customer/login");
    }
}
