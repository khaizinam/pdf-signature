<?php

namespace Dev\Base\Http\Middleware;

use Dev\Base\Exceptions\DisabledInDemoModeException;
use Dev\Base\Facades\BaseHelper;
use Closure;
use Illuminate\Http\Request;

class DisableInDemoModeMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (BaseHelper::hasDemoModeEnabled()) {
            throw new DisabledInDemoModeException();
        }

        return $next($request);
    }
}
