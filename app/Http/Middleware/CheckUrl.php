<?php

namespace App\Http\Middleware;

use Closure;

class CheckUrl
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
//        $arrayForRedirect = ['/index.php', '/index.html'];
//        if (in_array($request->getRequestUri(), $arrayForRedirect) || starts_with($request->getRequestUri(), '/public')) {
//            return redirect()->route('home.index');
//        }
        return $next($request);
    }
}
