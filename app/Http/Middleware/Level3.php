<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Level3
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // dd(Auth::user()->clearance_level);
        $user = Auth::user();

        if (!$user) {
            return back()->with('errors_', '-not logged in-');
        }

        if ($user->clearance_level >= 3) {
            return $next($request);
        } else {
            dd($user->clearance_level);
            return back()->with('errors_', '-clearance level is too low-');
        }

    }
}
