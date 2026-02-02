<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string  $roles  Comma-separated list of roles
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = $request->user();

        // Auth middleware should handle this, but safety check
        if (! $user) {
            abort(403, 'Unauthenticated.');
        }

        // Relationship-based role check
        if (! in_array($user->role->name, $roles)) {
            abort(403, 'Unauthorized.');
        }

        return $next($request);
    }
}
