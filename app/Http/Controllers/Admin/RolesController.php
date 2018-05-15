<?php

namespace App\Http\Controllers\Admin;

use App\Models\AdminRolesModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

/**
 * @Cname:角色管理
 * @Cstyle:fa-th
 * @Csort:10
 * @package App\Http\Controllers\Admin
 */
class RolesController extends Controller
{
    private  $RolesModel;
    public function __construct(){
        $this->RolesModel = new AdminRolesModel();
    }
    /**
     * @Fname:角色列表
     * @Fdisplay:true
     * @Fstyle:fa-circle-o text-red
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $_private_info = $request->get('_private_info');
        $menus = $_private_info['menus'];
        $list = $this->RolesModel->where('status','<>',3)->get();
        return view('admin.roles.list',compact('menus','list'));
    }

    /**
     * @Fname:创建角色
     * @Fdisplay:true
     * @Fstyle:fa-circle-o text-aqua
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $_private_info = $request->get('_private_info');
        $menus = $_private_info['menus'];
        if($request->isMethod('post')){
            $addData = [];
            $addData['name'] = $request->input('name');
            $addData['desc'] = $request->input('content');
            $addData['status'] = $request->input('status');
            $addData['powers'] = $request->input('power');
            $this->RolesModel->fill($addData);
            $this->RolesModel->save();
            return redirect()->route('admin::roles');
        }

        if(Auth::user()->id == 1){
            $menusJson = $this->menusHandle($menus);
        }else{
            $roleInfo = $this->RolesModel->find(Auth::user()->rid);
            if(empty($roleInfo)){
                abort(403,'对不起，请求参数错误！');
            }
            $menusJson = $this->menusHandle($menus,$roleInfo->powers,1);
            foreach($menusJson as $key=>&$val){
                if(!$val['checked']){
                    unset($menusJson[$key]);
                }
                $val['checked'] = !$val['checked'];
            }
            $menusJson = json_encode(array_values($menusJson));
        }

        return view('admin.roles.info',compact('menus','menusJson'));
    }
    //获取树形菜单json数组
    public function menusHandle($menus,$power='',$c=false){
        $arrs = [];
        $powers = explode(',',$power);
//        dump($powers);
//        dump($menus);
        foreach($menus as $k=>$val){
            $c_arr['id'] = $k+1;
            $c_arr['pId'] = 0;
            $c_arr['name'] = $val['C'][1];
            $c_arr['open'] = true;
            $c_arr['controller'] = false;
            $c_arr['fun']        = false;
            $c_arr['checked']    = false;

            foreach($val['F'] as $fk=>$fv){
                $f_arr['id'] = $k+10000;
                $f_arr['pId'] = $k+1;
                $f_arr['name'] = $fk;
                $f_arr['controller'] = $val['C'][0];
                $f_arr['fun']        = $fv['fun_name'];
                $f_arr['checked']    = false;
                foreach($powers as $p){
                    preg_match_all('/Admin\\\(.*)@(.*)/',$p,$match);
                    preg_match_all('/Admin\\\(.*)/',$val['C'][0],$C_match);
                    if(isset($match[2][0])&& isset($match[1][0]) &&isset($fv['fun_name'])){
                        if(($match[1][0] == $C_match[1][0])&&($match[2][0] == $fv['fun_name'])){
                            $c_arr['checked']  = true;
                            $f_arr['checked']  = true;
                        }
                    }
                }
                $arrs[] = $f_arr;
            }
            $arrs[] = $c_arr;
        }
        if($c){
            return $arrs;
        }
//        dump($arrs);
        return json_encode($arrs);
    }
    /**
     * @Fname:编辑角色
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $_private_info = $request->get('_private_info');
        $menus = $_private_info['menus'];
        $id = $request->input('id',0);
        if(empty($id)){
            abort(403,'对不起，请求参数错误！');
        }
        $roleInfo = $this->RolesModel->find($id);
        if(empty($roleInfo)){
            abort(403,'对不起，请求参数错误！');
        }
        if($request->isMethod('post')){
            $addData = [];
            $addData['name'] = $request->input('name');
            $addData['desc'] = $request->input('content');
            $addData['status'] = $request->input('status');
            $addData['powers'] = $request->input('power');
            $roleInfo->fill($addData);
            $roleInfo->save();
            return redirect()->route('admin::roles');
        }
        $menusJson = $this->menusHandle($menus,$roleInfo->powers);
        return view('admin.roles.info',compact('menus','menusJson','roleInfo'));
    }

    /**
     * @Fname:删除角色
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->input('id');
        $info = $this->RolesModel->find($id);
        if(empty($info)){
            return ['msg'=>'找不到该条数据','data'=>[],'status'=>13000];
        }
        $info->status = 3;
        $info->save();
        return ['msg'=>'删除成功','data'=>[],'status'=>0];
    }

}
