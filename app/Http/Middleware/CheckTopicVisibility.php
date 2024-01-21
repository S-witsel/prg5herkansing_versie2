<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Topic;

class CheckTopicVisibility
{
    public function handle($request, Closure $next)
    {
        $topic = $request->route('topic');

        if (!$topic || !$topic->is_visible) {
            abort(404);
        }

        return $next($request);
    }
}
