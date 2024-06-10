<?php

namespace App\Http\Middleware;

use App\Helpers\ResponseTraits;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRoleApi
{
    use ResponseTraits;

    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Check if the user is authenticated
        if (!auth()->check()) {
            return redirect()->route('auth.showLogin');
        }

        // Check if the user has at least one of the required roles
        foreach ($roles as $role) {
            $user = auth()->user() ?? null;
            if ($user  &&  $user->hasRole($role)) {
                return $next($request);
            }
        }

        // If the user does not have any of the required roles, redirect back
        return $this->forbidden();
    }
}
