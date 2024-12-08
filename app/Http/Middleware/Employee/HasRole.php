<?php

namespace App\Http\Middleware\Employee;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HasRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $employee = auth('employee')->user();

        if (! $employee?->hasRole($role)) {
            abort(403);
        }

        return $next($request);
    }
}
