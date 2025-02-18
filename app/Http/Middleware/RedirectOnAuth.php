<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectOnAuth {
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  Closure(): void  $next
     */
    public function handle(Request $request, Closure $next) : Response {
        // logged in user cannot see the generic welcome page inviting to login
        // instead take them right to home
        if (Auth::check()) {
            return redirect()->route('home');
        }
        return $next($request);
    }
}
