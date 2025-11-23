<?php

namespace App\Http\Middleware;

use App\Models\ContractTerm;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TermsCheckMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $excludeRoutes = [
            "contracts.create",
            "contracts.store",
            "contracts.edit",
            "contracts.update",
            "agenda.",
        ];  

        if (! $request->routeIs($excludeRoutes)) {
            ContractTerm::where("taken", 0)
                ->where("session_id", session()->getId())
                ->update([
                    "session_id" => null,
                ]);
        }

        return $next($request);
    }
}
