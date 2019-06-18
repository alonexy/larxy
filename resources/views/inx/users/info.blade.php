@extends('layouts.app')
@section('title')
    账户管理-创建新账号
@stop
@section('content')
<div class="wrapper wrapper-content">
    @if (count($errors) > 0)
        <div class="alert alert-error">
            <ul>
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger alert-dismissable">
                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">×</font></font></button><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">
                                {{ $error }}</font></font><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">。
                            </font></font>
                    </div>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5> 创建新账号 </h5>
            <div class="ibox-tools">
                <a class="collapse-link">
                    <i class="fa fa-chevron-up"></i>
                </a>
                {{--<a class="dropdown-toggle" data-toggle="dropdown" href="#">--}}
                    {{--<i class="fa fa-wrench"></i>--}}
                {{--</a>--}}
                {{--<ul class="dropdown-menu dropdown-user">--}}
                    {{--<li><a href="#">选项 1</a>--}}
                    {{--</li>--}}
                    {{--<li><a href="#">选项 2</a>--}}
                    {{--</li>--}}
                {{--</ul>--}}
                {{--<a class="close-link">--}}
                    {{--<i class="fa fa-times"></i>--}}
                {{--</a>--}}
            </div>
        </div>
        <div class="ibox-content">
            <form method="POST" action="#" class="form-horizontal" role="form" id="form">
                {!! csrf_field() !!}
                <div class="form-group">
                    <label class="col-sm-2 control-label">账户名称</label>
                    <div class="col-sm-10">
                        @if(empty($Info->name))
                            <input required="required" type="text" class="form-control" name="name" autocomplete="off"
                                   placeholder="名称" maxlength="80" value="{{old('name')}}">
                        @else
                            <input required="required" type="text" class="form-control" name="name" autocomplete="off"
                                   placeholder="名称" maxlength="80" value="{{$Info->name or ''}}">
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">登陆邮箱</label>
                    <div class="col-sm-10">
                        @if(empty($Info->email))
                            <input required  type="email" aria-required="true" aria-invalid="true" class="form-control" name="email" autocomplete="off"
                                   placeholder="登陆邮箱" maxlength="80" value="{{old('email')}}">
                        @else
                            <input required="required" type="text" class="form-control" name="email" autocomplete="off"
                                   placeholder="登陆邮箱" maxlength="80" value="{{$Info->email or ''}}">
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">登录密码</label>
                    <div class="col-sm-10">
                        <input required="required" type="text" class="form-control" name="passwd" autocomplete="off"
                               placeholder="密码" maxlength="80">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">确认登录密码</label>
                    <div class="col-sm-10">
                        <input required="required" type="text" class="form-control" name="passwd_confirmation" autocomplete="off"
                               placeholder="再一次输入密码" maxlength="80">
                    </div>
                </div>

                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">选择角色</label>

                    <div class="col-sm-10">
                        <select class="form-control m-b" name="roleid">
                            @if(empty($roles))
                                <option value="0">==请先去添加角色==</option>
                            @else
                                @foreach($roles as $rv)
                                    <option value="{{$rv->id or 0}}" @if(!empty($Info->rid) && $Info->rid == $rv->id) {{'selected'}} @endif >{{$rv->name or '--'}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="form-group"><label class="col-sm-2 control-label">是否启用</label>

                    <div class="col-sm-10">
                        <select class="form-control m-b" name="status">
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

                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <div class="col-sm-4 col-sm-offset-2">

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
</div>
@endsection
@section('other-js')
    <script type="application/javascript">
        $(document).ready(function() {
            $("#form").validate({
                rules: {
                    name: {
                        required: true,
                        minlength: 3
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    passwd: {
                        required: true,
                        minlength: 4
                    },
                    passwd_confirmation: {
                        required: true,
                        minlength: 4
                    }
                }
            });
        });
    </script>
@stop