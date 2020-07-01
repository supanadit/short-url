<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="csrf_token" content="{{ csrf_token() }}"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Short URL</title>
    <link rel="shortcut icon" href="{{asset('favicon.png')}}"/>
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
        <p class="login-box-msg">Expired</p>
        <p>
            I am sorry, the link is expired, so please just back to the homepage, or if you own the link just regenerate
            the link, but if you get the link from somebody just ask to the person who share this link.
        </p>
        <div class="input-group">
            <input type="text"
                   class="form-control"
                   placeholder="Generated URL"
                   id="generated-url-field"
                   value="{{$url}}"
                   readonly>
            <span class="input-group-btn">
                <button type="button" class="btn btn-danger btn-flat"
                        data-clipboard-target="#generated-url-field">
                    <i class="fa fa-clipboard"></i>
                </button>
            </span>
        </div>
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
<!-- Clipboard -->
<script src="{{asset('vendor/clipboard.js/dist/clipboard.min.js')}}"></script>
<!-- iCheck -->
<script src="{{asset('plugin/iCheck/icheck.min.js')}}"></script>

<script type="application/javascript">
    const clipboard = new ClipboardJS('.btn');
    clipboard.on('success', function (e) {
        toastr.success("URL Copied");
        e.clearSelection();
    });

    clipboard.on('error', function (e) {
        toastr.failed("Cannot Copy URL");
    });
</script>
</body>
</html>
