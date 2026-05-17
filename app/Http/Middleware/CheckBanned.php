<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckBanned
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // dd([
        //     'auth_check' => Auth::check(),
        //     'is_banned'  => Auth::check() ? Auth::user()->is_banned : 'not logged in',
        //     'route'      => $request->route()?->getName(),
        // ]);
        if (Auth::check() && Auth::user()->is_banned) {
            if (!$request->routeIs('banned') && !$request->routeIs('logout')) {
                return redirect()->route('banned');
            }
        }
        return $next($request);
    }
}
