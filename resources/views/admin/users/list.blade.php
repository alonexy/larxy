@extends('admin.admin')
@section('content-header')
    <h1>
        账号管理
        <small>管理员列表</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{url('/dashboard')}}"><i class="fa fa-dashboard"></i> 主页</a></li>
        <li class="active">账号管理 - 管理员列表</li>
    </ol>
@stop

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">管理员列表</h3>
            <div class="box-tools">
                <form action="" method="get">
                    <div class="input-group">
                        <input type="text" class="form-control input-sm pull-right" name="s_title"
                               style="width: 150px;" placeholder="搜索会员">
                        <div class="input-group-btn">
                            <button class="btn btn-sm btn-default"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="box-body table-responsive">
            <table class="table table-hover table-bordered">
                <tbody>
                <!--tr-th start-->
                <tr>
                    <th>呢称</th>
                    <th>邮箱</th>
                    <th>角色</th>
                    <th>状态</th>
                    <th>创建时间</th>
                    <th>更新时间</th>
                    <th>操作</th>
                </tr>
                <!--tr-th end-->

                @foreach($list as $val)
                    <tr>
                        <td class="text-muted">{{$val->name or ''}}</td>
                        <td class="text-muted">{!!$val->email or ''!!}</td>
                        <td class="text-muted">{{$val->r_name or ''}}</td>
                        @if($val->status == 1)
                            <td class="text-muted">启用</td>
                            @else
                            <td class="text-muted">关闭</td>
                        @endif

                        <td class="text-navy">{{$val->created_at or ''}}</td>
                        <td class="text-navy">{{$val->updated_at or ''}}</td>
                        <td>
                            <a style="font-size: 16px" href="{{URL::route("admin::user::edit")}}?id={{$val->id or 0}}"><i class="fa fa-fw fa-pencil" title="修改"></i></a>
                            <a style="font-size: 16px" href="javascript:void(0);"><i class="fa fa-fw fa-trash-o del_uer" dev_val="{{$val->id or 0}}" title="删除"></i></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop
@section('other-js')
<script type="application/javascript">
    $(document).ready(function () {
        $(".del_uer").bind({
            click:function(){
                var id = $(this).attr('dev_val');
                layer.confirm('删除账号，账号将无法登陆', {
                    btn: ['确认','取消'] //按钮
                }, function(){
                    $.ajax({
                        type : "POST",  //提交方式
                        url : "{{URL::route('admin::user::destroy')}}",//路径
                        data : {
                            'id':id,
                        },
                        dataType: "json",
                        success : function(result) {//返回数据根据结果进行相应的处理
                            layer.msg(result.msg);
                            if(result.status == 0){
                                setTimeout(function(){
                                    window.location.reload();
                                },2000)
                            }
                        }
                    });
                }, function(){
                    layer.closeAll();
                    return false;
                });
            }
        })
    });
</script>
@stop