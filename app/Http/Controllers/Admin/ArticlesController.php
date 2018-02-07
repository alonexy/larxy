<?php

namespace App\Http\Controllers\Admin;

use App\Common\Functions;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

/**
 * @Cname:内容管理
 * @Cstyle:fa-book
 * @Csort:11
 * Class ArticlesController
 * @package App\Http\Controllers\Admin
 */
class ArticlesController extends Controller
{
    /**
     * @Fname:文章列表
     * @Fdisplay:true
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $_private_info = $request->get('_private_info');
        $menus = $_private_info['menus'];
//        dump($menus);
//        DB::connection('mongodb')       //选择使用mongodb
//        ->collection('users_'.date('Ymd'))           //选择使用users集合
//        ->insert([                          //插入数据
//            'name'  =>  str_random(11),
//            'age'     =>   rand(1,100)
//        ]);
        $list = [];
        return view('admin.users.list', compact('menus','list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
