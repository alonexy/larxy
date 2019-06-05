<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="clear">
                            <span class="block m-t-xs">
                                <strong class="font-bold">{{\Auth::user()->name}}</strong>
                            </span> <span class="text-muted text-xs block"> {{ \App\Common\Functions::getAuthRole() }} <b class="caret"></b></span>
                        </span>
                    </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a href="/auth/logout">登出</a></li>
                    </ul>
                </div>
                <div class="logo-element">
                    IN+
                </div>
            </li>

            {{----}}
            @foreach($menus as $menu)
                @if($menu['C'][3] == 'on')
                    <li class="{{ \App\Common\Functions::isActiveRoute($menu['C'][0]) }}">
                        <a href="#">
                            <i class="fa {{$menu['C'][2] or 'fa-user'}}"></i>
                            <span>{{$menu['C'][1] or null}}</span>
                            <span class="pull-right-container">
                                 <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="nav nav-second-level collapse ">
                            @foreach($menu['F'] as $fk=>$fv)
                                @if((bool)$fv['display'])
                                    <li class="{{ \App\Common\Functions::isActiveRoute($menu['C'][0].'@'.$fv['fun_name']) }}">
                                        <a href="{{URL::action($menu['C'][0].'@'.$fv['fun_name'])}}">
                                            <i class="fa {{$fv['style'] or 'fa-circle-o'}}"></i>
                                            {{$fk or '--'}}
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </li>
                @endif
            @endforeach
            {{----}}

        </ul>

    </div>
</nav>
