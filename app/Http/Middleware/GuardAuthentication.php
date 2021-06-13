<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Globals\Traits\TResponder;
use Illuminate\Http\Response;

class GuardAuthentication
{
    use TResponder;

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param Closure $next
     * @param null $guard
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $guard = null): mixed
    {
        if(\Auth::guard($guard)->check()) {
            return $next($request);
        }

        return $this->error(null, __('auth.wrong-guard'), Response::HTTP_PRECONDITION_FAILED);
    }
}
