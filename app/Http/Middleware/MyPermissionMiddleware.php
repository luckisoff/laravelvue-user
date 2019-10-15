<?php

namespace App\Http\Middleware;

use Closure;

class MyPermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $permissions=auth()->user()->getAllPermissions();
        if(\sizeof($permissions)>0)
        {
            return $next($request);
        }
        return redirect('/welcome')->with(["message"=>"Restricted Area"]);

    }
}
