<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;


class CheckAdminRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        dd([auth()->user(),auth()->user()->role]);
        if (auth()->check() && auth()->user()->role == 'Admin') {
            return $next($request);
        }
        // if(!auth()->check())
        abort(403, 'Unauthorized action.');
        // if(auth()->user()->role == 'User')
        // abort(403, 'you are just a user.');
    }

}
