<?php

namespace Modules\Mobilesettings\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class GenerateMenus
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {


        return $next($request);
    }
}

