<?php

namespace App\Http\Middleware;

use App\Common\Functions;
use App\Models\AdminHandleModel;
use App\Models\AdminRolesModel;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class CheckAdmin
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
        $action = \Route::current()->getActionName();

        $uuid = Functions::uuids();
        #中间件 记录 访问日志
        app('db')->listen(function($query, $bindings = null, $time = null, $connectionName = null) use($uuid){
            $tmp = str_replace('?', '"'.'%s'.'"', $query);
            $tmp = vsprintf($tmp, $bindings);
            $SqlLogs = [$tmp,$time,$connectionName];
            Functions::SysLog('Admin-operation-log','==SQL==',[
                'uuid'=>$uuid,
                'sqls'=>$SqlLogs
            ]);
        });
        Functions::SysLog('Admin-operation-log','==Access==',[
            'uuid'=>$uuid,
            'userInfo'=>Auth::user()->toArray(),
            'action'=>$action,
            'reqData'=>$request->all(),
        ]);

        $AdminHandleModel = new AdminHandleModel();
        $Menus = $AdminHandleModel->getMenus();
        list($res,$msg,$Menus) = $AdminHandleModel->checkFunPower($action,$Menus);
        if(!$res){
            abort(403,$msg);
        }
        $_private_info = array();
        $_private_info['menus'] = $Menus;
        $request->attributes->add(compact('_private_info'));
        return $next($request);
    }

}//end++
