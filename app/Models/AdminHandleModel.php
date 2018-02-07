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
            $newMenus[$mk['C'][4]] = $mk;
        }

        ksort($newMenus);
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

}//EndClass
