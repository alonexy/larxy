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
        <link rel="stylesheet" href="{{url('dist/css/AdminLTE.css')}}">
        <link rel="stylesheet" href="{{url('dist/css/ionicons.min.css')}}">
        <link rel="stylesheet" href="{{url('dist/css/skins/_all-skins.css')}}">

        <link rel="stylesheet" href="{{url('dist/css/jquery.dataTables.min.css')}}">
        <link href="//cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.10.16/b-1.5.1/b-colvis-1.5.1/b-flash-1.5.1/b-html5-1.5.1/datatables.min.css"/>
        <link rel="stylesheet" href="{{url('layui/css/layui.css')}}">
    @show


    @section('other-css')
    @show  {{----}}
</head>
<body class="hold-transition skin-blue sidebar-mini">
    {{--中间的内容--}}
        <section class="content-header">
            @section('content-header')
            @show
        </section>
        <section class="content">
            @section('content')
            @show
        </section>
    {{--/中间的内容--}}


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
    <script src="//cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
    {{--<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>--}}
    {{--<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>--}}
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.10.16/b-1.5.1/b-colvis-1.5.1/b-flash-1.5.1/b-html5-1.5.1/datatables.min.js"></script>
    <script src="/layer/layer.js"></script>
    <script src="/laydate/laydate.js"></script>
    <script src="/layui/layui.js"></script>
@show

{{-- 引入额外依赖JS插件 --}}
@section('other-js')
@show

</body>
</html>