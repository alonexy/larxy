@extends('layouts.app')
@section('title')
    角色管理-角色列表
@stop
@section('content')
<div class="wrapper wrapper-content">
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>角色列表</h5>
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
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>名称</th>
                    <th>简介</th>
                    <th>状态</th>
                    <th>创建时间</th>
                    <th>更新时间</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($list as $val)
                    <tr>
                        <td class="text-info">{{$val->name or ''}}</td>
                        <td class="text-muted">{!!$val->desc or ''!!}</td>
                        @if(!empty($val->status) && $val->status==1)
                            <td class="text-muted">启用</td>
                        @else
                            <td class="text-muted">关闭</td>
                        @endif

                        <td class="text-navy">{{$val->created_at or ''}}</td>
                        <td class="text-navy">{{$val->updated_at or ''}}</td>
                        <td>
                            <a style="font-size: 16px" href="{{URL::route("admin::role::edit")}}?id={{$val->id or 0}}">
                                <button class="btn btn-primary dim btn-sm" type="button"><i class="fa fa-fw fa-pencil" title="修改"></i></button>
                            </a>
                            <a style="font-size: 16px" href="javascript:void(0);">
                                <button class="btn btn-warning dim btn-sm del_uer" type="button" dev_val="{{$val->id or 0}}"><i class="fa fa-fw fa-trash-o"  title="删除"></i></button>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>
    </div>
</div>
@endsection
@section('other-js')
    <script type="application/javascript">
        $(document).ready(function() {
            $(".del_uer").bind({
                click:function(){
                    var id = $(this).attr('dev_val');
                    swal({
                                title: "确认删除吗？",
                                text: "删除角色，绑定改角色的账号将无法登陆",
                                type: "warning",
                                showCancelButton: true,
                                confirmButtonColor: "#DD6B55",
                                confirmButtonText: "删除",
                                cancelButtonText: "取消",
                                closeOnConfirm: false,
                                closeOnCancel: true
                            },
                            function (isConfirm) {
                                if (isConfirm) {
                                    var index = layer.load(2, {time: 10*1000});
                                    $.ajax({
                                        type : "POST",  //提交方式
                                        url : "{{URL::route('admin::role::destroy')}}",//路径
                                        data : {
                                            'id':id
                                        },
                                        dataType: "json",
                                        success : function(result) {
                                            layer.close(index)
                                            if(result.status == 0){
                                                swal('操作成功', result.msg, "success");
                                                setTimeout(function(){
                                                    window.location.reload();
                                                },2000)
                                            }else{
                                                swal('操作失败', result.msg, "error");
                                            }
                                        }
                                    });

                                }
                            });
                }
            })
        });
    </script>
@stop