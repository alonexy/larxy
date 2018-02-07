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

         $collects = collect(
        [
            [
                'count' => 455,
                'title' => 'All Members',
                'sup' => '人',
                'icon' => 'ion-person-add',
                'bck' => 'bg-aqua',
                'url' => '/admin/usermember/index'
            ],
            [
                'count' => 45,
                'title' => 'All Articles',
                'sup' => '篇',
                'icon' => 'ion-document',
                'bck' => 'bg-green',
                'url' => '/admin/article/index'
            ],
            [
                'count' => 33,
                'title' => 'All videos',
                'sup' => '个',
                'icon' => 'ion-videocamera',
                'bck' => 'bg-purple',
                'url' => 'admin/video/index'
            ],
            [
                'count' => 11,
                'title' => 'All News',
                'sup' => '个',
                'icon' => 'ion-film-marker',
                'bck' => 'bg-yellow',
                'url' => 'admin/series/index'
            ],
            [
                'count' => 33,
                'title' => 'All Comments',
                'sup' => '条',
                'icon' => 'ion-document',
                'bck' => 'bg-red',
                'url' => 'admin/discussion/index'
            ],
            [
                'count' => 44,
                'title' => 'All Lists',
                'sup' => '条',
                'icon' => 'ion-android-textsms',
                'bck' => 'bg-orange',
                'url' => 'admin/comment/index'
            ],
            [
                'count' => 43,
                'title' => 'All Tasks',
                'sup' => '条',
                'icon' => 'ion-pricetags',
                'bck' => 'bg-olive',
                'url' => 'admin/tags/index'
            ],
            [
                'count' => 55,
                'title' => 'All musics',
                'sup' => '首',
                'icon' => 'ion-music-note',
                'bck' => 'bg-maroon',
                'url' => 'admin/broadcast/index'
            ]
        ]
    );
        $_private_info = $request->get('_private_info');
        $menus = $_private_info['menus'];
//        dump($menus);
        return view('admin.dashboard.index', compact('collects','menus'));
    }


}
