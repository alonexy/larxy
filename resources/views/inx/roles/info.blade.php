@extends('layouts.app')
@section('other-css')
    <link rel="stylesheet" href="/ztree/css/bootstrapStyle/bootstrapStyle.css" type="text/css">
@endsection
@section('title')
    角色管理-添加新角色
@stop
@section('content')
    <div class="wrapper wrapper-content">
        <div class="ibox-content">
            <form method="POST" action="#" class="form-horizontal" id="createRole"  role="form" accept-charset="utf-8">
                {!! csrf_field() !!}

                <div class="form-group">
                    <label class="col-sm-2 control-label">角色名称*</label>

                    <div class="col-sm-10">
                        <input required="required" type="text" class="form-control required" name="name" autocomplete="off"
                               placeholder="角色名称" maxlength="80" aria-required="true" value="{{$roleInfo->name or ''}}">
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">选择权限
                        <small class="text-red">*</small>
                    </label>
                    <div class="col-sm-10">
                        <ul id="treeDemo" class="ztree "></ul>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">是否启用*</label>

                    <div class="col-sm-10">
                        <select class="js-example-placeholder-single form-control" id="status">
                            @if(!empty($roleInfo->status) && ($roleInfo->status == 1))
                                <option value="{{$roleInfo->status or 1}}" selected>启用</option>
                                <option value="2">关闭</option>
                            @else
                                <option value="1">启用</option>
                                <option value="{{$roleInfo->status or 2}}" selected>关闭</option>
                            @endif
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">备注</label>
                    <div class="col-sm-10">
                        <textarea class="form-control message-input" name="content"
                                  placeholder="输入角色简介">{!! $roleInfo->desc or '' !!}</textarea>
                    </div>
                </div>

                <input type="hidden" name="status" value="{{$roleInfo->status or ''}}">
                <input type="hidden" name="power" value="{{$roleInfo->powers or ''}}">
                @if(empty($roleInfo->id))
                    <button type="button" class="btn btn-primary" id="fsubmit">创建</button>
                @else
                    <button type="button" class="btn btn-primary" id="fsubmit">更新</button>
                @endif
            </form>
        </div>
    </div>
@endsection
@section('other-js')
    <script type="text/javascript" src="/ztree/js/jquery.ztree.core.js"></script>
    <script type="text/javascript" src="/ztree/js/jquery.ztree.excheck.js"></script>
    <script type="text/javascript" src="/ztree/js/jquery.ztree.exedit.js"></script>
    <script>
        var Powers = [];
        @if(!empty($roleInfo->powers))
        Powers = {!!  json_encode(explode(',',$roleInfo->powers)) !!}
        @endif
        function zTreeOnCheck(event, treeId, treeNode) {
            if (treeNode.checked) {
                if (treeNode.children) {
                    for (var i = 0; i < treeNode.children.length; i++) {
                        var addV = treeNode.children[i].controller + '@' + treeNode.children[i].fun;
                        if (Powers.indexOf(addV) >= 0) { //存在
                        } else {
                            Powers.push(addV);
                        }
                    }
                } else {
                    if (Powers.indexOf(treeNode.controller + '@' + treeNode.fun) >= 0) { //存在
                    } else {
                        Powers.push(treeNode.controller + '@' + treeNode.fun);
                    }
                }
            } else {
                if (treeNode.children) {
                    for (var i = 0; i < treeNode.children.length; i++) {
                        var DelV = treeNode.children[i].controller + '@' + treeNode.children[i].fun;
                        if (Powers.indexOf(DelV) >= 0) { //存在
                            Powers.splice(Powers.indexOf(DelV), 1);
                        }
                    }
                } else {
                    if (Powers.indexOf(treeNode.controller + '@' + treeNode.fun) >= 0) { //存在
                        Powers.splice(Powers.indexOf(treeNode.controller + '@' + treeNode.fun), 1);
                    }
                }
            }
        }
        var setting = {
            view: {
                selectedMulti: false,
                showIcon: false
            },
            check: {
                enable: true
            },
            data: {
                simpleData: {
                    enable: true
                }
            },
            callback: {
                onCheck: zTreeOnCheck
            }
        };

        var zNodes = {!!$menusJson!!};

        $(document).ready(function () {
            $.fn.zTree.init($("#treeDemo"), setting, zNodes);
            $("#fsubmit").bind({
                click: function () {
                    if($("input[name='name']").val() == ''){
                        layer.msg('请输入角色名称');
                        return false;
                    }

                    $("input[name='status']").val($("#status").val())

                    if (Powers.length == 0) {
                        layer.msg('请选择权限');
                        return false;
                    }
                    $("input[name='power']").val(Powers)
                    document.getElementById("createRole").submit();
                }
            })
            $("#createRole").validate({
                rules: {
                    name: {
                        required: true,
                        minlength: 2
                    },
                    status:{
                        required: true
                    },
                    content:{
                        required: true,
                        minlength: 3
                    }
                }
            });
        });
    </script>
@stop