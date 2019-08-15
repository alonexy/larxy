<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

/**
 * @Cname:控制面板
 * @Cstyle:fa-dashboard
 * @Csort:1
 */
class HomeController extends Controller
{
    /**
     * @Fname:首页
     * @Fdisplay:true
     * @Fstyle:fa-circle-o
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $_private_info = $request->get('_private_info');
        $menus = $_private_info['menus'];

        return view('inx.home.index', compact('menus'));
    }


}
