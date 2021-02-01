<?php

namespace Isolar\Middleware;

use Closure;
use Isolar\Http\Request;

class AuthenticationMiddleware implements MiddlewareInterface
{
    /**
     * Handle the request before the controller.
     * 
     * @param Request $request
     * @param Closure $next
     * 
     * @return void|string
     */
    public function handle(Request $request, Closure $next)
    {
        $next();
    }
}