@extends('admin.admin')
@section('other-css')
    {!! editor_css() !!}
    <link href="//cdn.bootcss.com/select2/4.0.3/css/select2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/ztree/css/bootstrapStyle/bootstrapStyle.css" type="text/css">
@endsection
@section('content-header')
    <h1>
        角色管理
        <small>创建角色</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{url('/dashboard')}}"><i class="fa fa-dashboard"></i> 主页</a></li>
        <li class="active">角色管理 - 创建角色</li>
    </ol>
@stop

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">创建角色</h3>
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
            <h2 class="page-header">角色信息</h2>
            <form method="POST" action="#"  id="createRole" accept-charset="utf-8">
                {!! csrf_field() !!}
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">主要内容</a></li>
                    </ul>

                    <div class="tab-content">

                        <div class="tab-pane active" id="tab_1">
                            <div class="form-group">
                                <label>角色名称
                                    <small class="text-red">*</small>
                                </label>
                                <input required="required" type="text" class="form-control" name="name" autocomplete="off"
                                       placeholder="名称" maxlength="80" value="{{$roleInfo->name or ''}}">
                            </div>
                            <div class="form-group">
                                <label>选择权限
                                    <small class="text-red">*</small>
                                </label>
                                <ul id="treeDemo" class="ztree"></ul>
                            </div>
                            <div class="form-group">
                                <label>是否启用
                                    <small class="text-red">*</small>
                                </label>
                                <select class="js-example-placeholder-single form-control">
                                    @if(!empty($roleInfo->status) && ($roleInfo->status == 1))
                                        <option value="{{$roleInfo->status or 1}}" selected>启用</option>
                                        <option value="2">关闭</option>
                                        @else
                                        <option value="1">启用</option>
                                        <option value="{{$roleInfo->status or 2}}" selected>关闭</option>
                                        @endif
                                </select>
                            </div>
                            <div class="form-group">
                                <label>简介(Markdown)
                                    <small class="text-red">*</small>
                                    <span class="text-green">min:20</span></label>
                                <div id="editormd_id">
                                    <textarea name="content" style="display:none;">{!! $roleInfo->desc or '' !!}</textarea>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="status" value="{{$roleInfo->status or ''}}">
                        <input type="hidden" name="power" value="{{$roleInfo->powers or ''}}">
                        @if(empty($roleInfo->id))
                            <button type="button" class="btn btn-primary" id="fsubmit">创建</button>
                            @else
                            <button type="button" class="btn btn-primary" id="fsubmit">更新</button>
                            @endif

                    </div>
                </div>
            </form>
        </div>
    </div>
@stop
@section('other-js')
    {!! editor_js() !!}
    <script src="//cdn.bootcss.com/select2/4.0.3/js/select2.full.min.js"></script>
    <script type="text/javascript" src="/ztree/js/jquery.ztree.core.js"></script>
    <script type="text/javascript" src="/ztree/js/jquery.ztree.excheck.js"></script>
    <script type="text/javascript" src="/ztree/js/jquery.ztree.exedit.js"></script>
    <script>
        var Powers = [];
        @if(!empty($roleInfo->powers))
        Powers = {!!  json_encode(explode(',',$roleInfo->powers)) !!}
        @endif
        function zTreeOnCheck(event, treeId, treeNode){
            if(treeNode.checked){
                if(treeNode.children){
                    for(var i=0;i<treeNode.children.length;i++){
                        var addV = treeNode.children[i].controller+'@'+treeNode.children[i].fun;
                        console.log(Powers.indexOf(addV))
                        if(Powers.indexOf(addV) >= 0){ //存在

                        }else{
                            Powers.push(addV);
                        }
                    }
                }else{
                    if(Powers.indexOf(treeNode.controller+'@'+treeNode.fun) >= 0){ //存在
                    }else{
                        Powers.push(treeNode.controller+'@'+treeNode.fun);
                    }
                }
            }else{
                if(treeNode.children){
                    for(var i=0;i<treeNode.children.length;i++){
                        var DelV = treeNode.children[i].controller+'@'+treeNode.children[i].fun;
                        if(Powers.indexOf(DelV) >= 0){ //存在
                            Powers.splice(Powers.indexOf(DelV),1);
                        }
                    }
                }else{
                    if(Powers.indexOf(treeNode.controller+'@'+treeNode.fun) >= 0){ //存在
                        Powers.splice(Powers.indexOf(treeNode.controller+'@'+treeNode.fun),1);
                    }
                }
            }
        }
        var setting = {
            view: {
                selectedMulti: false,
                showIcon:false
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

        $(document).ready(function(){
            $.fn.zTree.init($("#treeDemo"), setting, zNodes);
            $(".js-example-basic-multiple").select2({
                placeholder: "选择一个标签"
            });
            $(".js-example-placeholder-single").select2({
                placeholder: "选择是否启用",
                allowClear: true
            });
            $("#fsubmit").bind({
                click:function(){
                    var isOnObj = $(".js-example-placeholder-single").select2('data');
                    if(isOnObj[0].id == ""){
                        layer.msg('选择是否启用');
                        return false;
                    }
                    $("input[name='status']").val(isOnObj[0].id)
                    console.log(Powers)
                    if(Powers.length == 0){
                        layer.msg('未选择权限');
                        return false;
                    }
                    $("input[name='power']").val(Powers)
                    document.getElementById("createRole").submit();
                }
            })
        });
    </script>

@endsection
