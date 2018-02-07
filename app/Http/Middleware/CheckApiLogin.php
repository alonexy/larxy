<?php

namespace App\Http\Middleware;

use Closure;

class CheckApiLogin
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
        ##传递参数例子
        $_private_info = array();
        $_private_info['userid']    = 1;
        $_private_info['user_info'] = 2;
        //dump($_private_info);
        $request->attributes->add(compact('_private_info'));
        return $next($request);
    }
}
