<?php

namespace App\Http\Middleware;

use Closure;

class CheckAdminUser
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

        if( (!auth()->check()) || (! isset(\auth()->user()->type) && in_array(\auth()->user()->type, [
                    \App\User::SUPERADMIN
                ])) ) {
            auth()->logout();
            return redirect('login');
        }
        return $next($request);
    }
}
