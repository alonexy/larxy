<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inx - @yield('title') </title>
    <!-- Toastr style -->
    <link rel="stylesheet" href="/css_plugins/toastr/toastr.min.css" rel="stylesheet">
    <!-- Gritter -->
    <link href="/js_plugins/gritter/jquery.gritter.css" rel="stylesheet">
    <link href="/css_plugins/iCheck/custom.css" rel="stylesheet">
    <link href="/css_plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet">
    <link rel="stylesheet" href="{!! asset('css/vendor.css') !!}" />
    <link rel="stylesheet" href="{!! asset('css/app.css') !!}" />
    <link rel="stylesheet" href="{{url('layui/css/layui.css')}}">
    <!-- Sweet Alert -->
    <link href="/css_plugins/sweetalert/sweetalert.css" rel="stylesheet">
    @section('other-css')
    @show
</head>
<body>

  <!-- Wrapper-->
    <div id="wrapper">

        <!-- Navigation -->
        @include('layouts.navigation')

        <!-- Page wraper -->
        <div id="page-wrapper" class="gray-bg">

            <!-- Page wrapper -->
            @include('layouts.topnavbar')

            <!-- Main view  -->
            @yield('content')

            <!-- Footer -->
            @include('layouts.footer')

        </div>
        <!-- End page wrapper-->

    </div>
    <!-- End wrapper-->
  <script src="{!! asset('js/app.js') !!}" type="text/javascript"></script>
  <!-- Flot -->
  <script src="/js_plugins/flot/jquery.flot.js"></script>
  <script src="/js_plugins/flot/jquery.flot.tooltip.min.js"></script>
  <script src="/js_plugins/flot/jquery.flot.spline.js"></script>
  <script src="/js_plugins/flot/jquery.flot.resize.js"></script>
  <script src="/js_plugins/flot/jquery.flot.pie.js"></script>
  <script src="/js_plugins/flot/jquery.flot.symbol.js"></script>
  <script src="/js_plugins/flot/jquery.flot.time.js"></script>
  <!-- Peity -->
  <script src="/js_plugins/peity/jquery.peity.min.js"></script>
  <!-- jQuery UI -->
  <script src="/js_plugins/jquery-ui/jquery-ui.min.js"></script>
  <!-- Jvectormap -->
  <script src="/js_plugins/jvectormap/jquery-jvectormap-2.0.2.min.js"></script>
  <script src="/js_plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
  <!-- EayPIE -->
  <script src="/js_plugins/easypiechart/jquery.easypiechart.js"></script>
  <!-- Sparkline -->
  <script src="/js_plugins/sparkline/jquery.sparkline.min.js"></script>
  <!-- Toastr script -->
  <script src="/js_plugins/toastr/toastr.min.js"></script>
  <!-- iCheck -->
  <script src="/js_plugins/iCheck/icheck.min.js"></script>
  <script src="/layer/layer.js"></script>
  <script src="{{url('laydate/laydate.js')}}"></script>
  <script src="/layui/layui.js"></script>
  <!-- Jquery Validate -->
  <script src="/js_plugins/validate/jquery.validate.min.js"></script>
  <script src="/js_plugins/validate/message_cn.js"></script>
  <!-- Sweet alert -->
  <script src="/js_plugins/sweetalert/sweetalert.min.js"></script>
@section('scripts')
@show
{{-- 引入额外依赖JS插件 --}}
@section('other-js')
@show
</body>
</html>
