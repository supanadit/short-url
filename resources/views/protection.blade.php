<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="csrf_token" content="{{ csrf_token() }}" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Short URL</title>
    <link rel="shortcut icon" href="{{asset('favicon.png')}}" />
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{asset('vendor/bootstrap/dist/css/bootstrap.min.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('vendor/font-awesome/css/font-awesome.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{asset('vendor/Ionicons/css/ionicons.min.css')}}">
    <!-- Toastr -->
    <link rel="stylesheet" href="{{asset('vendor/toastr/toastr.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('dist/css/AdminLTE.min.css')}}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{asset('plugin/iCheck/square/blue.css')}}">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="/"><b>Short</b>&nbsp;URL</a>
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg">Protected URL</p>

            <form action="/" method="post" id="protection-form">
                <div class="form-group has-feedback">
                    <input type="password" class="form-control" placeholder="Password" id="password">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="row">
                    <div class="col-xs-8"></div>
                    <!-- /.col -->
                    <div class="col-xs-4">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">
                            Open Link
                        </button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
        </div>
        <!-- /.login-box-body -->
    </div>
    <!-- /.login-box -->

    <!-- jQuery 3 -->
    <script src="{{asset('vendor/jquery/dist/jquery.min.js')}}"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="{{asset('vendor/bootstrap/dist/js/bootstrap.min.js')}}"></script>
    <!-- Toastr -->
    <script src="{{asset('vendor/toastr/toastr.min.js')}}"></script>
    <!-- iCheck -->
    <script src="{{asset('plugin/iCheck/icheck.min.js')}}"></script>
    <script>
        $(document).ready(function () {
        $("#protection-form").on("submit", function (e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "/s/{{$path}}/open/protection",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                data: JSON.stringify({
                    "password": $("#password").val(),
                }),
                contentType: "application/json",
                dataType: "json",
                async: true,
                success: function (result) {
                    toastr.success(result.message);
                    location.href = result.url;
                },
                error: function (result) {
                    toastr.error(result.responseJSON.message);
                }
            });
        });
    });
    </script>
</body>

</html>
