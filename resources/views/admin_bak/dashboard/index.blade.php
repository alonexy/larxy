@extends('admin.admin')
@section('content-header')
    <section class="content-header">
        <h1>
            控制面板
            <small>概述</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{url('/')}}"><i class="fa fa-dashboard"></i> 主页</a></li>
            <li class="active">控制面板</li>
        </ol>
    </section>
@endsection

@section('content')
    <section class="content">
        <div class="row">
            @foreach($collects as $collect)
                <div class="col-lg-3 col-xs-6">
                    <div class="small-box {{$collect['bck']}}" style="color: #fff">
                        <div class="inner">
                            <h3>{{$collect['count']}}<sup style="font-size: 20px">{{$collect['sup']}}</sup></h3>

                            <p>{{$collect['title']}}</p>
                        </div>
                        <div class="icon">
                            <i class="fa {{$collect['icon']}}"></i>
                        </div>
                        @if(!empty($collect['url']))
                            <a href="{{url($collect['url'])}}" class="small-box-footer">更多信息 <i
                                        class="fa fa-arrow-circle-right"></i></a>
                        @else
                            <a href="javascript:void(0);" class="small-box-footer">更多信息 <i
                                        class="fa fa-arrow-circle-right"></i></a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
        <div class="row">
            <section class="col-lg-12 connectedSortable">
                <div class="box box-primary">
                    <div class="box-header">
                            <h3 class="box-title">暂无消息</h3>
                        <div class="box-tools pull-right">

                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        {{--<ul class="todo-list">--}}
                            {{--@foreach($FollowFailOrders as $FollowFailOrder)--}}
                                {{--<li>--}}
                                    {{--<!-- drag handle -->--}}
                      {{--<span class="handle">--}}
                        {{--<i class="fa fa-ellipsis-v"></i>--}}
                        {{--<i class="fa fa-ellipsis-v"></i>--}}
                      {{--</span>--}}
                                    {{--<!-- todo text -->--}}
                                    {{--<span class="text"><a class="layui-btn layui-btn-radius layui-btn-primary"--}}
                                                          {{--href="{{URL::route("admin::getLogBySid")}}?s_uuid={{ $FollowFailOrder['s_uuid'] or 's_uuid is null' }}">--}}
                                            {{--查看 </a></span>--}}
                                    {{--<span class="text">用户:{{ $FollowFailOrder['master_server']  }}--}}
                                        {{--_{{ $FollowFailOrder['follow_user_id'] or 'follow_user_id is null' }}</span>--}}
                                    {{--<span class="text">Symbol:{{ $FollowFailOrder['symbol'] or ' symbol is null' }}</span>--}}
                                    {{--<span class="text">Volume:{{ $FollowFailOrder['volume'] or ' volume is null' }}</span>--}}
                                    {{--<span class="text">Cmd:{{ $FollowFailOrder['cmd'] or ' cmd is null' }}</span>--}}
                                    {{--<span class="text">错误信息:【{{ $FollowFailOrder['err_msg'] or ' Error is null' }}--}}
                                        {{--】</span>--}}
                                    {{--<!-- Emphasis label -->--}}
                                    {{--<small class="label label-danger"><i--}}
                                                {{--class="fa fa-clock-o"></i> {{ $FollowFailOrder['err_time_now'] or '--' }}--}}
                                    {{--</small>--}}
                                    {{--<!-- General tools such as edit or delete-->--}}
                                    {{--<div class="tools">--}}
                                    {{--</div>--}}
                                {{--</li>--}}
                            {{--@endforeach--}}
                        {{--</ul>--}}
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer clearfix no-border">

                    </div>
                </div>
            </section>
        </div>
    </section>
@endsection