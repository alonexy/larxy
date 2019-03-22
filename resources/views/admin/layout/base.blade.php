<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta property="wb:webmaster" content="b1217e0e46e1e300"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta id="token" name="token" value="{{csrf_token()}}">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @section('head-css')
        <link href="{{asset("/cdnboot/font-awesome/4.6.0/css/font-awesome.css") }}" rel="stylesheet">
        <link href="{{asset("/cdnboot/bootstrap/3.3.0/css/bootstrap.min.css") }}" rel="stylesheet">
        <link rel="stylesheet" href="/css/ionicons.min.css">
        <link rel="stylesheet" href="{{url('dist/css/AdminLTE.css')}}">
        <link rel="stylesheet" href="{{url('dist/css/ionicons.min.css')}}">
        <link rel="stylesheet" href="{{url('dist/css/skins/_all-skins.css')}}">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/jszip-2.5.0/af-2.2.2/b-1.5.1/b-colvis-1.5.1/b-flash-1.5.1/b-html5-1.5.1/b-print-1.5.1/cr-1.4.1/fc-3.2.4/fh-3.1.3/kt-2.3.2/r-2.2.1/rg-1.0.2/rr-1.2.3/sc-1.4.4/sl-1.2.5/datatables.min.css"/>
        <link rel="stylesheet" href="{{url('dist/css/jquery.dataTables.min.css')}}">
        {{--<link rel="stylesheet" href="{{url('dist/css/dataTables.bootstrap.min.css')}}">--}}
        <link rel="stylesheet" href="{{url('layui/css/layui.css')}}">

    @show


    @section('other-css')
    @show  {{----}}
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
    {{--顶部导航--}}
    @section('main-header')
    @show
    {{--/顶部导航--}}

    {{--主导航栏--}}
    @section('main-sidebar')
    @show
    {{--/主导航栏--}}

    {{--中间的内容--}}
    <div class="content-wrapper">
        <section class="content-header">
            @section('content-header')
            @show
        </section>
        <section class="content">
            @section('content')
            @show
        </section>
    </div>
    {{--/中间的内容--}}

    {{--底部--}}
    @section('main-footer')
    @show
    {{--/底部--}}

    {{--右侧边栏--}}
    @section('right-sidebar')
    @show
    {{--/右侧边栏--}}
</div>

@section('head-js')
    <script src="{{asset("/cdnboot/jquery/2.1.0/jquery.min.js") }}"></script>
    <script src="{{asset("/cdnboot/bootstrap/3.3.0/js/bootstrap.min.js") }}"></script>
    <script src="{{asset("/cdnboot/vue/2.0.0-rc.5/vue.min.js") }}"></script>
    <script src="{{asset("/cdnboot/vue.resource/1.0.2/vue-resource.min.js") }}"></script>
    <script src="{{url('dist/js/admin.js')}}"></script>
    <script src="{{url('dist/js/demo.js')}}"></script>
    <script src="{{url('dist/js/raphael.min.js')}}"></script>
    <script src="{{url('dist/js/Morris.min.js')}}"></script>
    <script src="{{url('dist/js/jquery.dataTables.min.js')}}"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs/jszip-2.5.0/af-2.2.2/b-1.5.1/b-colvis-1.5.1/b-flash-1.5.1/b-html5-1.5.1/b-print-1.5.1/cr-1.4.1/fc-3.2.4/fh-3.1.3/kt-2.3.2/r-2.2.1/rg-1.0.2/rr-1.2.3/sc-1.4.4/sl-1.2.5/datatables.min.js"></script>
    <script src="/layer/layer.js"></script>
    <script src="{{url('laydate/laydate.js')}}"></script>
    <script src="/layui/layui.js"></script>
@show

{{-- 引入额外依赖JS插件 --}}
@section('other-js')
@show

{{--判断导航栏是否高亮--}}
<script type="text/javascript">
    $(document).ready(function () {
        var path_array = window.location.pathname.split('/');
        var scheme_less_url = '//' + window.location.host + window.location.pathname;
        if (path_array[2] == undefined) {
            scheme_less_url = window.location.protocol + '//' + window.location.host + '/' + path_array[1];
        }else if(path_array[3] == ''){
            scheme_less_url = window.location.protocol + '//' + window.location.host + '/' + path_array[1] + '/' + path_array[2];
        }else {
            scheme_less_url = window.location.protocol + '//' + window.location.host + '/' + path_array[1] + '/' + path_array[2];
            for(var ii = 0;ii<path_array.length;ii++){
                if(ii>=3){
                    scheme_less_url+= '/' + path_array[ii];
                }
            }
        }

        $('ul.treeview-menu>li').find('a[href="' + scheme_less_url + '"]').closest('li').addClass('active');  //二级链接高亮
        $('ul.treeview-menu>li').find('a[href="' + scheme_less_url + '"]').closest('li.treeview').addClass('active');  //一级栏目[含二级链接]高亮
        $('.sidebar-menu>li').find('a[href="' + scheme_less_url + '"]').closest('li').addClass('active');  //一级栏目[不含二级链接]高亮
    });
</script>
</body>
</html>