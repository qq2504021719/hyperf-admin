<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="zh-cn">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>AdminLTE 3 | Starter</title>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{config('hyperf-admin.app_host')}}/public/vendor/plugins/fontawesome-free/css/all.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- 页面进度条 -->
    <link rel="stylesheet" href="{{config('hyperf-admin.app_host')}}/public/vendor/dist/css/font-awesome.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{config('hyperf-admin.app_host')}}/public/vendor/plugins/fontawesome-free/css/all.min.css">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="{{config('hyperf-admin.app_host')}}/public/vendor/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet" href="{{config('hyperf-admin.app_host')}}/public/vendor/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="{{config('hyperf-admin.app_host')}}/public/vendor/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">

    <!-- DataTables start -->
    <link rel="stylesheet" href="{{config('hyperf-admin.app_host')}}/public/vendor/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{config('hyperf-admin.app_host')}}/public/vendor/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{config('hyperf-admin.app_host')}}/public/vendor/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="{{config('hyperf-admin.app_host')}}/public/vendor/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- daterange picker -->
    <link rel="stylesheet" href="{{config('hyperf-admin.app_host')}}/public/vendor/plugins/daterangepicker/daterangepicker.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{config('hyperf-admin.app_host')}}/public/vendor/dist/css/adminlte.min.css">
    <!-- Bootstrap4 Duallistbox -->
    <link rel="stylesheet" href="{{config('hyperf-admin.app_host')}}/public/vendor/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
    <!-- toastr -->
    <link rel="stylesheet" href="{{config('hyperf-admin.app_host')}}/public/vendor/plugins/toastr/toastr.css">


    <!-- jQuery -->
    <script src="{{config('hyperf-admin.app_host')}}/public/vendor/plugins/jquery/jquery.min.js"></script>
    <!-- jQuery pjax -->
    <script src="{{config('hyperf-admin.app_host')}}/public/vendor/plugins/jquery/jquery.pjax.min.js"></script>
    <!-- 页面进度条 -->
    <script src="{{config('hyperf-admin.app_host')}}/public/vendor/dist/js/nprogress.js"></script>
    <!-- Bootstrap 4 -->
    <script src="{{config('hyperf-admin.app_host')}}/public/vendor/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Select2 -->
    <script src="{{config('hyperf-admin.app_host')}}/public/vendor/plugins/select2/js/select2.full.min.js"></script>
    <!-- Bootstrap4 Duallistbox -->
    <script src="{{config('hyperf-admin.app_host')}}/public/vendor/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
    <!-- InputMask -->
    <script src="{{config('hyperf-admin.app_host')}}/public/vendor/plugins/moment/moment.min.js"></script>
    <script src="{{config('hyperf-admin.app_host')}}/public/vendor/plugins/inputmask/jquery.inputmask.min.js"></script>
    <!-- date-range-picker -->
    <script src="{{config('hyperf-admin.app_host')}}/public/vendor/plugins/daterangepicker/daterangepicker.js"></script>
    <!-- bootstrap color picker -->
    <script src="{{config('hyperf-admin.app_host')}}/public/vendor/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{config('hyperf-admin.app_host')}}/public/vendor/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Bootstrap Switch -->
    <script src="{{config('hyperf-admin.app_host')}}/public/vendor/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
    <!-- AdminLTE App -->
    <script src="{{config('hyperf-admin.app_host')}}/public/vendor/dist/js/adminlte.min.js"></script>
    <!-- toastr -->
    <script src="{{config('hyperf-admin.app_host')}}/public/vendor/plugins/toastr/toastr.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    {{--<script src="{{config('hyperf-admin.app_host')}}/public/vendor/dist/js/demo.js"></script>--}}
    <!-- 帮助方法 -->
    <script src="{{config('hyperf-admin.app_host')}}/public/vendor/dist/js/functions.js"></script>

</head>
<body class="hold-transition sidebar-mini">
<div class="bar" role="bar"><div class="peg"></div></div><div class="spinner" role="spinner"><div class="spinner-icon"></div></div>
<div class="wrapper">

@include('layouts.header')

@include('layouts.sidebar')

<!-- Content Wrapper. jquery pjax -->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div id="content-wrapper">
    @if($config['is_pjax'] == false)
    {!! $html !!}
    @endif
    </div>
</div>
<!-- /.content-wrapper -->
<!-- /.content-wrapper jquery pjax -->

@include('layouts.footer')

</div>
<!-- ./wrapper -->
</body>

<!-- REQUIRED SCRIPTS -->


<script>

// 路由前缀
var routePrefix = "{{$config['prefix']}}";

// #################### jquery pjax start ####################
// 路由点击
$(document).pjax('a[data-pjax]', '#content-wrapper');

// 菜单选中初始化
function navInit()
{
    var that = '';
    var path = window.location.pathname;
    // console.log(path)
    // 等于首页的情况
    if(path === '/'+routePrefix)
    {
        path = path+'/testindex';
    }

    $(".nav-link").each(function () {
        // 关闭所有菜单选中
        $(this).attr('class','nav-link');
        // 右侧图标去掉
        $(this).parent().attr('class','nav-item has-treeview');
        // 子菜单隐藏
        $(this).next('ul').attr('style','display: none;');

        // 选中和当前路由名称一样的路由
        if($(this).attr('href') === path || $(this).attr('href') == f_path)
        {
            $(this).attr('class','nav-link active');
            that = $(this);
        }


    })
    // 父级的父级的上一个兄弟标签是a标签的情况，也选中
    if(that)
    {
        // 一级父选项选中
        var data = that.attr('data');
        var level = that.attr('level');
        // console.log(data+"|"+level)
        if(level > 1 && data > 0)
        {
            for(var i = 1; i < level;i++)
            {
                // 菜单选中
                $('#'+i+'-'+data).attr('class','nav-link active');
                // 右侧图标更换
                $('#'+i+'-'+data).parent().attr('class','nav-item has-treeview menu-open');
                // 子菜单显示
                $('#'+i+'-'+data).next('ul').attr('style','display: block;');
            }
        }

    }
}

/**
 * pjax加载完成
 * @constructor
 */
function pjaxDone()
{
    // 菜单选中初始化
    navInit();
    // 关闭进度条
    NProgress.done(true);
    // 关闭刷新转动
    $('#view-fa-refresh').attr('class','fas fa-refresh');

}

// 进度条配置
NProgress.configure({
    showSpinner:false,
    template:'<div class="bar" style="z-index:1039;"  role="bar">' +
        '<div class="peg"></div></div><div class="spinner" role="spinner">' +
        '<div class="spinner-icon"></div></div>'
});

/**
 * pjax被触发
 */
function pjaxStart()
{
    // 开启进度条
    NProgress.start();
    // 开启刷新转动
    $('#view-fa-refresh').attr('class','fas fa-refresh fa-spin');
}

// 绑定点击事件被触发
$(document).on('pjax:click', function() {
})

// 发送前
$(document).on('pjax:beforeSend', function() {
    pjaxStart();
})
// 开始
$(document).on('pjax:start', function() {
    NProgress.set(0.3); // 20%
})
// 发送
$(document).on('pjax:send', function() {
    NProgress.set(0.4); // 30%
})
// pjax通过链接点击已经开始之后触发
$(document).on('pjax:clicked', function() {
})
// 从服务器端加载的HTML内容完成之后，替换当前内容之前
$(document).on('pjax:beforeReplace', function() {
    NProgress.set(0.8); // 80%
})
// 从服务器端加载的HTML内容替换当前内容之后
$(document).on('pjax:success', function() {
    NProgress.set(0.9); // 90%
})
// 	在options.timeout之后触发；除非被取消，否则会强制刷新页面
$(document).on('pjax:timeout', function() {
})
// 	ajax请求出错；除非被取消，否则会强制刷新页面
$(document).on('pjax:error', function() {
})
// 无论结果如何，都在ajax响应完成后触发
$(document).on('pjax:complete', function() {
})
// 	结束
$(document).on('pjax:end', function() {
    pjaxDone();
})


// 菜单选中初始化
navInit();
// #################### jquery pjax end ####################



</script>

</html>
