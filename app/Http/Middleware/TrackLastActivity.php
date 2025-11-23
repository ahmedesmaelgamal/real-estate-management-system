<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackLastActivity
{
 
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
        $timeout = 30 * 60; 
        $lastActivity = session('lastActivityTime');
        if ($lastActivity && (time() - $lastActivity) > $timeout) {
            auth()->logout();
            session()->flush();
            return redirect('/');
        }
        session(['lastActivityTime' => time()]);
    }

    return $next($request);
    }
}
