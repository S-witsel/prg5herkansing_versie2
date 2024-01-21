<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SpecialRightsMiddleware
{
    public function handle($request, Closure $next)
    {
        if ($request->user() && $request->user()->special_rights) {
            return $next($request);
        }

        return redirect()->route('home')->with('error', 'You do not have permission to access this page.');
    }
}
