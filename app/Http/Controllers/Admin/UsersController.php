<?php

namespace App\Http\Controllers\Admin;

use App\Models\AdminRolesModel;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 * @Cname:账号管理
 * @Cstyle:fa-user
 * @Csort:9
 * Class UsersController
 * @package App\Http\Controllers\Admin
 */
class UsersController extends Controller
{
    public  $UsersModel;
    public  $RolesModel;

    public function __construct(){
        $this->UsersModel = new User();
        $this->RolesModel = new AdminRolesModel();
    }
    /**
     * @Fname:账号列表
     * @Fdisplay:true
     * @Fstyle:fa-circle-o text-red
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $_private_info = $request->get('_private_info');
        $menus = $_private_info['menus'];
//        dump($menus);
        $s_title = $request->input('s_title',0);
        if(!empty($s_title)){
            $list = $this->UsersModel
                ->select(DB::raw('users.name as name ,users.id as id ,users.email as email,users.rid as rid, users.status as status ,roles.name as r_name,users.created_at as created_at ,users.updated_at as updated_at'))
                ->leftJoin('roles','users.rid','=','roles.id')->where('users.status','<>',3)->where('users.id','>',1)
                ->where('users.name','like','%'.$s_title.'%')
                ->orderBy('users.id','desc')->get();
        }else{
            $list = $this->UsersModel
                ->select(DB::raw('users.name as name ,users.id as id,users.email as email,users.rid as rid, users.status as status ,roles.name as r_name,users.created_at as created_at ,users.updated_at as updated_at'))
                ->leftJoin('roles','users.rid','=','roles.id')->where('users.status','<>',3)->where('users.id','>',1)
                ->orderBy('users.id','desc')->get();
        }

//        dump($list);
        return view('admin.users.list', compact('menus','list'));
    }

    /**
     * @Fname:新增账号
     * @Fdisplay:true
     * @Fstyle:fa-circle-o text-yellow
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request){
        $_private_info = $request->get('_private_info');
        $menus = $_private_info['menus'];
        $roles = $this->getActiveRoles();
        if($request->isMethod('post')){
            $messages = [
                'name.required'  => '昵称不能为空 .',
                'email.required' =>'邮箱不能为空',
                'email.email'    =>'邮箱格式错误',
                'passwd.required'    =>'密码不能为空',
                'passwd.confirmed'    =>'两次密码不一致',
                'roleid.required'    =>'请先去增加角色',
                'roleid.numeric'     =>'角色值错误',
            ];
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255',
                'email' => 'required|email',
                'passwd' => 'required|confirmed',
                'roleid' => 'required|numeric',
            ],$messages);
            if ($validator->fails()) {
                return redirect(route('admin::user::create'))->withErrors($validator)->withInput();
            }
            if(empty($request->input('roleid')) || $request->input('roleid') == 0){
                abort(403,'角色不能为空');
            }
            $res = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('passwd')),
                'rid'=>$request->input('roleid'),
                'status'=>$request->input('status'),
            ]);
            if($res){
                return redirect(route('admin::users'));
            }
        }
        return view('admin.users.info', compact('menus','roles'));
    }
    /**
     * @Fname:账号信息编辑
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request){
        $_private_info = $request->get('_private_info');
        $menus = $_private_info['menus'];
        $userid  = $request->input('id');
        if(empty($userid)){
            abort(403,'对不起，请求参数错误！');
        }
        $roles = $this->getActiveRoles();
        $Info = $this->UsersModel
            ->select(DB::raw('users.name as name ,users.id as id,users.email as email,users.rid as rid, users.status as status ,roles.name as r_name,users.created_at as created_at ,users.updated_at as updated_at'))
            ->leftJoin('roles','users.rid','=','roles.id')->where('users.status',1)->where('users.id','=',$userid)
            ->orderBy('users.id','desc')->first();
        if(empty($Info)){
            abort(403,'对不起，找不到用户');
        }
        if($request->isMethod('post')){
            $messages = [
                'name.required'  => '昵称不能为空 .',
                'email.required' =>'邮箱不能为空',
                'email.email'    =>'邮箱格式错误',
                'passwd.required'    =>'密码不能为空',
                'passwd.confirmed'    =>'两次密码不一致',
                'roleid.required'    =>'请先去增加角色',
                'roleid.numeric'     =>'角色值错误',
            ];
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255',
                'email' => 'required|email',
                'passwd' => 'required|confirmed',
                'roleid' => 'required|numeric',
            ],$messages);
            if ($validator->fails()) {
                return redirect(route('admin::user::create'))->withErrors($validator)->withInput();
            }
            if(empty($request->input('roleid')) || $request->input('roleid') == 0){
                abort(403,'角色不能为空');
            }
            $Info->name = $request->input('name');
            $Info->email = $request->input('email');
            $Info->password = bcrypt($request->input('passwd'));
            $Info->rid = $request->input('roleid');
            $Info->status = $request->input('status');
            $res = $Info->save();
            if($res){
                return redirect(route('admin::users'));
            }
        }
        return view('admin.users.info', compact('menus','Info','roles'));
    }
    //获取有效的角色列表
    public function getActiveRoles(){
        $arr = $this->RolesModel->where('status',1)->get();
        return $arr;
    }

    /**
     * @Fname:删除账号
     * @param Request $request
     * @return array
     */
    public function destroy(Request $request){
        $id = $request->input('id');
        $info = $this->UsersModel->find($id);
        if(empty($info)){
            return ['msg'=>'找不到该条数据','data'=>[],'status'=>13000];
        }
        $info->status = 3;
        $info->save();
        return ['msg'=>'删除成功','data'=>[],'status'=>0];
    }
}
