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

        $list = [];
        return view('inx.articles.lists', compact('menus','list'));
    }

    /**
     * @Fname:创建文章
     * @Fdisplay:true
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $_private_info = $request->get('_private_info');
        $menus = $_private_info['menus'];
        $list = [];
        return view('inx.articles.create', compact('menus','list'));
    }

}
