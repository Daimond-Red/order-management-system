<?php

namespace App\Http\Middleware;

use Closure;

class CheckUser
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
        // if( auth()->user()->status == 2 ) {

        //     try{
        //         \DB::table('oauth_access_tokens')->where('user_id', auth()->user()->id)->delete();
        //     } catch (\Exception $e) {

        //     }
        //     \App\DeviceToken::removeDeviceToken();
            
        //     return appError('Your account is not verified yet.');
        // }

        return $next($request);
    }
}
