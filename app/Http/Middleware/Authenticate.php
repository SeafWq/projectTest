<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{

//    public function handle($request, Closure $next, ...$guards)
//    {
//        if (empty($guards)) {
//            $guards = ['api'];
//        }
//
//        if (Auth::guard($guards)->guest()) {
//            return response()->json(['error' => 'Unauthorized'], 401);
//        }
//
//        return $next($request);
//    }

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson() ? null : route('login');
    }
}
