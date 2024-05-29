<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ClearanceLevel5
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (!$user) {
            return back()->with('errors_', '-not logged in-');
        }

        if ($user->clearance_level >= 5) {
            return $next($request);
        } else {
            return back()->with('errors_', '-clearance level is too low-');
        }
    }
}
