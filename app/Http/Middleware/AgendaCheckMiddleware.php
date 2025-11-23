<?php

namespace App\Http\Middleware;

use App\Models\Agenda;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AgendaCheckMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
       $excludeRoutes = [
            "agendas.create",
            "agendas.store",
            "agendas.edit",
            "agendas.update",
            "meetings.store",
            "meetings.update"
        ];

        if (! $request->routeIs($excludeRoutes)) {
            Agenda::where("taken", 0)
                ->where("session_id", session()->getId())
                ->update([
                    "session_id" => null,
                ]);
        }

        return $next($request);
    }
}
