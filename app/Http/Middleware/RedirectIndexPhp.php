<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RedirectIndexPhp
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->getRequestUri() === '/index.php') {
            return redirect('/');
        }

        return $next($request);
    }
}
