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
        list($class, $method) = explode('@', $action);
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
        preg_match_all('/App\\\Http\\\Controllers\\\(.*)/',$class,$classMatch);
        if(!isset($classMatch[1][0])){
            Auth::logout();
            abort(403,'CodeError');
        }
        $nowAction = $classMatch[1][0].'@'.$method;
        $user = Auth::user();
        if($user->status !== 1){
            Auth::logout();
            abort(403,'用户状态异常');
        }
        $AdminHandleModel = new AdminHandleModel();
        $Menus = $AdminHandleModel->getMenus();

        //SuperAdmin
        if($user->id !== 1){
            if(empty($user->rid)){
                Auth::logout();
                abort(403,'用户角色异常');
            }
            list($rStatus,$rPower) = $this->getPowers($user->rid);
            if(!$rStatus){
                Auth::logout();
                abort(403,'用户权限异常');
            }
            if(!in_array($nowAction,$rPower)){
                if(Request::ajax()){
                    return response()->json([
                        'msg'=>'您没有权限访问',
                        'data'=>[],
                        'status'=>130001
                    ]);
                }
                abort(403,'您没有权限访问');
            }
            $Menus = $this->MenusReset($Menus,$rPower);
        }
        $_private_info = array();
        $_private_info['menus'] = $Menus;
        $request->attributes->add(compact('_private_info'));
        return $next($request);
    }
    //获取角色权限
    public function getPowers($rid){
        $RolesModel = new AdminRolesModel();
        $arr = $RolesModel->find($rid);
        if($arr){
            if($arr->status  == 1){
                return [true,explode(',',$arr->powers)];
            }
        }
        return [false,[]];
    }
    //个人菜单过滤
    public function MenusReset($Menus,$rPower){
        foreach($Menus as $mk=>&$mv){
            $mv['C'][3] = 'off';
            foreach($mv['F'] as &$fv){
                if($fv['display']){
                    //二级显性菜单 存在权限 C显示
                    if(in_array($mv['C'][0].'@'.$fv['fun_name'],$rPower)) {
                        $mv['C'][3] = 'on';
                    }else{
                        $fv['display'] = false;
                    }
                }
            }
        }
//        dump($Menus,$rPower);
        return $Menus;
    }

}//end++
