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
        $res = true;
        if($request->segment(1) !== null)
            $res = $request->segment(1) !== "admin"
                || $request->segment(1) !== "owner"
                || $request->segment(1) !== "shop" ;
        return $res;
    }
}
