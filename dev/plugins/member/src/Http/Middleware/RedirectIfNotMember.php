<?php

namespace Dev\Member\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Middleware\AuthenticatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotMember implements AuthenticatesRequests
{
    public function handle(Request $request, Closure $next, string $guard = 'member')
    {
        if (! Auth::guard($guard)->check()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            }

            return redirect()->guest(route('public.member.login'));
        }

        return $next($request);
    }
}
