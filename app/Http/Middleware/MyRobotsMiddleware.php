<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Spatie\RobotsMiddleware\RobotsMiddleware;
//use Closure;

class MyRobotsMiddleware extends RobotsMiddleware
{
    /**
     * @return string|bool
     */
    protected function shouldIndex(Request $request)
    {
        return $request->route()->getPrefix() !== "/admin"
            || $request->route()->getPrefix() !== "/owner"
            || $request->route()->getPrefix() !== "/shop" ;
    }
}
