<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;

class LogFilter
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
        $AllLogFloderPaths = File::directories(storage_path('logs'));
        $floders = [];
        foreach($AllLogFloderPaths as $f){
            preg_match_all('/logs\/(.*)/',$f,$fmatch);
            $floders[] = $fmatch[1][0];
        }
        $nowL = $request->get('f',0);
        if($nowL){
            if(!in_array($nowL,$floders)){
                abort(403,'没有该日志分组');
            }
        }

        Config::set('log-viewer.storage-path',storage_path('logs/'.$request->get('f')));
        return $next($request);
    }
}
