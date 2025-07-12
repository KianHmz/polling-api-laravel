<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureGuestMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user('sanctum')) {
            return response()->json([
                'message' => 'Already authenticated!',
            ], 409);
        }
        return $next($request);
    }
}
