<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckCommentCount
{

    public function handle($request, Closure $next)
    {
        $user = auth()->user();

        if (!$user->special_rights && $user->comments()->count() < 5) {
            return redirect()->route('home')->with('error', 'You must have at least 5 comments to create a new topic.');
        }

        return $next($request);
    }
}
