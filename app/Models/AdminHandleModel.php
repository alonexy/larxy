<?php

namespace App\Models;


use App\Common\Functions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class AdminHandleModel extends Model
{
    public function getMenus(){
        $path = __DIR__.'/../Http/Controllers/Admin';
        $Menus = [];
        foreach(File::allFiles($path) as $k=>$partial)
        {
            preg_match_all('/Admin\/(.*)\.php/',$partial->getPathname(),$match);
            $classPath = "\App\Http\Controllers\Admin\\".$match[1][0];
            list($c,$f) = $this->getDocs($classPath);
            if($c && $f){
                $Menus[$k]['C']=$c;
                $Menus[$k]['F']=$f;
            }
        }
        $newMenus = [];
        foreach($Menus as &$mk){
            $mk['sort'] = $mk['C'][4];
        }
        $newMenus = Functions::arrays_sort_by_item($Menus,'SORT_ASC','sort');
        $newMenus = array_values($newMenus);
        return $newMenus;
    }
    /**
     * 反射类的注释
     * @param $classPath
     */
    public function getDocs($classPath){
        $reflect = new \ReflectionClass(new $classPath());
        $FDocs  = [];
        $Cdocs  = [];
        preg_match_all("/App\\\Http\\\Controllers\\\\(.*)/",$reflect->getName(),$Cpath);
        preg_match_all('/@Cname\:(.*)/',$reflect->getDocComment(),$Cmatch);
        preg_match_all('/@Cstyle\:(.*)/',$reflect->getDocComment(),$Cstylematch);
        preg_match_all('/@Csort\:(.*)/',$reflect->getDocComment(),$Csortmatch);
        if(isset($Cmatch[1][0])){
            if(isset($Cpath[1][0])){
                array_push($Cdocs,$Cpath[1][0]);
            }else{
                array_push($Cdocs,false);
            }
            array_push($Cdocs,$Cmatch[1][0]);
            if(isset($Cstylematch[1][0])){
                array_push($Cdocs,$Cstylematch[1][0]);
            }else{
                array_push($Cdocs,false);
            }
            array_push($Cdocs,'on');
            if(isset($Csortmatch[1][0])){
                array_push($Cdocs,$Csortmatch[1][0]);
            }else{
                array_push($Cdocs,100);
            }
            foreach($reflect->getMethods() as $val){
                preg_match_all('/@Fname\:(.*)/',$val->getDocComment(),$Fmatch);
                preg_match_all('/@Fdisplay\:(.*)/',$val->getDocComment(),$Fdisplaymatch);
                preg_match_all('/@Fstyle\:(.*)/',$val->getDocComment(),$Fstylematch);
                if(isset($Fmatch[1][0])){
                    $FDocs[$Fmatch[1][0]]['fun_name'] = $val->name;
                    $FDocs[$Fmatch[1][0]]['display']  = false;
                    $FDocs[$Fmatch[1][0]]['style']    = 'fa-circle-o';
                    if(isset($Fdisplaymatch[1][0])){
                        $FDocs[$Fmatch[1][0]]['display'] = (bool)$Fdisplaymatch[1][0];
                    }
                    if(isset($Fstylematch[1][0])){
                        $FDocs[$Fmatch[1][0]]['style'] = (string)$Fstylematch[1][0];
                    }
                }
            }
        }else{
            array_push($Cdocs,false);
            array_push($Cdocs,false);
            array_push($Cdocs,false);
            array_push($Cdocs,false);
            array_push($Cdocs,false);
        }
        return [$Cdocs,$FDocs];
    }
//    function arrays_multisort($data,$sort_order_field,$sort_order=SORT_ASC,$sort_type=SORT_NUMERIC){
//        foreach($data as $val){
//            $key_arrays[]=$val[$sort_order_field];
//        }
//        array_multisort($key_arrays,SORT_ASC,SORT_NUMERIC,$data);
//        return  $data;
//}
    /**
     * 检测类中方法的权限
     * 待完善
     * @return array
     */
    public function checkFunPower($action='',$menus=[],$getPower=false)
    {
        if(empty($action)){
            $action = \Route::current()->getActionName();
        }
        list($class, $method) = explode('@', $action);
        preg_match_all('/App\\\Http\\\Controllers\\\(.*)/',$class,$classMatch);
        if(!isset($classMatch[1][0])){
            return [false,'CodeError',[]];
        }
        $nowAction = $classMatch[1][0].'@'.$method;
        $user = \Auth::user();
        if($user->status !== 1){
            return [false,'用户状态异常',[]];
        }
        //SuperAdmin
        if($user->id !== 1){
            if(empty($user->rid)){
                return [false,'用户角色异常',[]];
            }
            list($rStatus,$rPower) = $this->getPowers($user->rid);
            if(!$rStatus){
                return [false,'用户权限异常',[]];
            }
            if(!in_array($nowAction,$rPower)){
                if($getPower){
                    return [false,'您没有权限访问',$rPower];
                }
                return [false,'您没有权限访问',[]];
            }
            if($menus){
                $newMenus = $this->MenusReset($menus,$rPower);
                return [true,'ok',$newMenus];
            }
        }
        return [true,'ok',$menus];
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
}//EndClass
