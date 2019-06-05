@extends('admin.admin')
@section('other-css')
    <link href="{{asset("/cdnboot/select2/4.0.3/css/select2.min.css") }}" rel="stylesheet">
    <link rel="stylesheet" href="/ztree/css/bootstrapStyle/bootstrapStyle.css" type="text/css">
@endsection
@section('content-header')
    <h1>
        账号管理
        <small>创建账号</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{url('/dashboard')}}"><i class="fa fa-dashboard"></i> 主页</a></li>
        <li class="active">账号管理 - 创建账号</li>
    </ol>
@stop

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">

            @if (count($errors) > 0)
                <div class="alert alert-error">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
        <div class="box-body table-responsive">
            <h2 class="page-header">角色信息</h2>
            <form method="POST" action="#"  id="createUser" accept-charset="utf-8">
                {!! csrf_field() !!}
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">主要内容</a></li>
                    </ul>

                    <div class="tab-content">

                        <div class="tab-pane active" id="tab_1">
                            <div class="form-group">
                                <label>管理员名称
                                    <small class="text-red">*</small>
                                </label>
                                @if(empty($Info->name))
                                    <input required="required" type="text" class="form-control" name="name" autocomplete="off"
                                           placeholder="名称" maxlength="80" value="{{old('name')}}">
                                    @else
                                    <input required="required" type="text" class="form-control" name="name" autocomplete="off"
                                                placeholder="名称" maxlength="80" value="{{$Info->name or ''}}">
                                @endif
                            </div>
                            <div class="form-group">
                                <label>登陆邮箱
                                    <small class="text-red">*</small>
                                </label>
                                @if(empty($Info->email))
                                <input required="required" type="text" class="form-control" name="email" autocomplete="off"
                                       placeholder="登陆邮箱" maxlength="80" value="{{old('email')}}">
                                    @else
                                    <input required="required" type="text" class="form-control" name="email" autocomplete="off"
                                           placeholder="登陆邮箱" maxlength="80" value="{{$Info->email or ''}}">
                                @endif
                            </div>
                            <div class="form-group">
                                <label>登陆密码
                                    <small class="text-red">*</small>
                                </label>
                                <input required="required" type="text" class="form-control" name="passwd" autocomplete="off"
                                       placeholder="密码" maxlength="80">
                            </div>
                            <div class="form-group">
                                <label>确认登陆密码
                                    <small class="text-red">*</small>
                                </label>
                                <input required="required" type="text" class="form-control" name="passwd_confirmation" autocomplete="off"
                                       placeholder="再一次输入密码" maxlength="80">
                            </div>
                            <div class="form-group">
                                <label>选择角色
                                    <small class="text-red">*</small>
                                </label>
                                <select class="js-example-basic-multiplee form-control" name="roleid">
                                    @if(empty($roles))
                                        <option value="0">==请先去添加角色==</option>
                                    @else
                                        @foreach($roles as $rv)
                                            <option value="{{$rv->id or 0}}" @if(!empty($Info->rid) && $Info->rid == $rv->id) {{'selected'}} @endif >{{$rv->name or '--'}}</option>
                                        @endforeach
                                    @endif

                                </select>
                            </div>
                            <div class="form-group">
                                <label>是否启用
                                    <small class="text-red">*</small>
                                </label>
                                <select class="js-example-placeholder-single form-control" name="status">
                                    @if(!empty($Info->status) && ($Info->status == 1))
                                        <option value="{{$Info->status or 1}}" selected>启用</option>
                                        <option value="2">关闭</option>
                                    @else
                                        <option value="1">启用</option>
                                        <option value="{{$Info->status or 2}}" selected>关闭</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        @if(empty($Info->id))
                            <button type="submit" class="btn btn-primary">创建</button>
                        @else
                            <button type="submit" class="btn btn-primary">更新</button>
                        @endif

                    </div>
                </div>
            </form>
        </div>
    </div>
@stop
@section('other-js')
    <script src="//cdn.bootcss.com/select2/4.0.3/js/select2.full.min.js"></script>
    <script type="text/javascript" src="/ztree/js/jquery.ztree.core.js"></script>
    <script type="text/javascript" src="/ztree/js/jquery.ztree.excheck.js"></script>
    <script type="text/javascript" src="/ztree/js/jquery.ztree.exedit.js"></script>
    <script>


        $(document).ready(function(){
            $(".js-example-basic-multiple").select2({
                placeholder: "选择一个角色"
            });
            $(".js-example-placeholder-single").select2({
                placeholder: "选择是否启用",
                allowClear: true
            });
        });
    </script>

@endsection
