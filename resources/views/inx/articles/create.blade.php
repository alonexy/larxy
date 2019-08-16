@extends('layouts.app')
@section('title')
    创建
@stop
<link rel="stylesheet" href="/jodits/jodit.min.css">
<script src="/jodits/jodit.min.js"></script>
<style type="text/css">
    .jodit_container .jodit_icon,
    .jodit_container .jodit_toolbar .jodit_toolbar_btn>a {
        fill: #7963e4;
        color: #7963e4;
    }
    .jodit_container .jodit_toolbar>li.jodit_toolbar_btn.jodit_with_dropdownlist .jodit_with_dropdownlist-trigger {
        border-top-color: #7963e4;
    }
</style>
@section('content')
    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-lg-12">
                <div id="editor"></div>
            </div>
        </div>
    </div>
@endsection
@section('other-js')
    <script type="application/javascript">
        $(document).ready(function () {
            var options = {
                imageDefaultWidth: 300,
                textIcons: false,
                enter: "DIV",
                language: 'zh_cn',
                disablePlugins: "media",
                height: 600,
                defaultMode: Jodit.MODE_WYSIWYG,
                showWordsCounter: true,
                observer: {
                    timeout: 100
                },
                uploader: {
                    url: '/connector/index.php?action=fileUpload'
                },
                filebrowser: {
                    buttons: ['list', 'tiles', 'sort'],
                    ajax: {
                        url: '/connector/index.php'
                    }
                },
                buttons: "paragraph,bold,strikethrough,underline,italic,|,superscript,subscript,|,ul,ol,|,outdent,indent,|,font,fontsize,brush,|,image,link,|,align,undo,redo,\n,cut,hr,eraser,copyformat,|,fullsize,selectall"
            };
            var editor = new Jodit('#editor', options);
        });
    </script>
@stop