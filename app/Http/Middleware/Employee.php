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
        if (\Auth::check() && (\Auth::user()->hasRole("shop") || \Auth::user()->hasRole("employee"))) {
            return $next($request);
        }
        else if (\Auth::check()) {
            return response()->view('errors.forbidden', [], 403);
        }
        else {
            return redirect("shop/login");
        }
    }
}
