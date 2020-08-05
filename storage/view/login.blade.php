<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{config('hyperf-admin.name')}}-登录</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="{{config('hyperf-admin.app_host')}}/public/vendor/dist/css/googleapis.css">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{config('hyperf-admin.app_host')}}/public/vendor/plugins/fontawesome-free/css/all.min.css">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="{{config('hyperf-admin.app_host')}}/public/vendor/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{config('hyperf-admin.app_host')}}/public/vendor/dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <b>{{config('hyperf-admin.name')}}</b>
    </div>
    <!-- /.login-logo -->
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">登录</p>

            <form action="{{$url}}" method="post">
                <div class="input-group mb-3">
                    <input type="text" name="username" class="form-control @if($msg)is-invalid @endif" placeholder="账号">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" name="password" class="form-control @if($msg)is-invalid @endif" placeholder="密码">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <span style="color: red;">{{$msg}}</span>
                <div class="row">
                    <div class="col-8">
                        <div class="icheck-primary">
                            {{--<input type="checkbox" id="remember">--}}
                            {{--<label for="remember">--}}
                                {{--Remember Me--}}
                            {{--</label>--}}
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block">登录</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>

            {{--<div class="social-auth-links text-center mb-3">--}}
                {{--<p>- OR -</p>--}}
                {{--<a href="#" class="btn btn-block btn-primary">--}}
                    {{--<i class="fab fa-facebook mr-2"></i> Sign in using Facebook--}}
                {{--</a>--}}
                {{--<a href="#" class="btn btn-block btn-danger">--}}
                    {{--<i class="fab fa-google-plus mr-2"></i> Sign in using Google+--}}
                {{--</a>--}}
            {{--</div>--}}
            {{--<!-- /.social-auth-links -->--}}

            {{--<p class="mb-1">--}}
                {{--<a href="forgot-password.html">I forgot my password</a>--}}
            {{--</p>--}}
            {{--<p class="mb-0">--}}
                {{--<a href="register.html" class="text-center">Register a new membership</a>--}}
            {{--</p>--}}
        </div>
        <!-- /.login-card-body -->
    </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="{{config('hyperf-admin.app_host')}}/public/vendor/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="{{config('hyperf-admin.app_host')}}/public/vendor/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="{{config('hyperf-admin.app_host')}}/public/vendor/dist/js/adminlte.min.js"></script>

</body>
</html>
