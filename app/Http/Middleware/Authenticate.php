<?php

namespace App\Http\Middleware;

use App\Helpers\ResponseTraits;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Authenticate extends Middleware
{
    use ResponseTraits;

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson() ? null : route('login');
    }

    /**
     * Handle an unauthenticated user.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  array                    $guards
     * @return void
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    protected function unauthenticated($request, array $guards)
    {
        // If the request expects JSON, return a JSON response
        if ($request->expectsJson()) {
            abort(
                response()->json(
                    [
                        'status'  => false,
                        'success' => 0,
                        'message' => 'Unauthenticated',
                        'code' => Response::HTTP_UNAUTHORIZED,
                    ],
                    Response::HTTP_UNAUTHORIZED
                )
            );
        }

        // Otherwise, use the default unauthenticated handling
        parent::unauthenticated($request, $guards);
    }
}
