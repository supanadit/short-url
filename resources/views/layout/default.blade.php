<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Short URL</title>
    <link rel="shortcut icon" href="{{asset('favicon.png')}}"/>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{asset('vendor/bootstrap/dist/css/bootstrap.min.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('vendor/font-awesome/css/font-awesome.min.css')}}">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="{{asset('plugin/iCheck/all.css')}}">
    <!-- Bootstrap Datepicker -->
    <link rel="stylesheet" href="{{asset('vendor/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{asset('vendor/Ionicons/css/ionicons.min.css')}}">
    <!-- Toastr -->
    <link rel="stylesheet" href="{{asset('vendor/toastr/toastr.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('dist/css/AdminLTE.min.css')}}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{asset('dist/css/skins/_all-skins.min.css')}}">

    <style type="text/css">
        .modal {
            overflow: auto !important;
        }
    </style>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

    @yield('css')
</head>
<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
<body class="hold-transition skin-blue layout-top-nav">
<div class="wrapper">
    <header class="main-header">
        <nav class="navbar navbar-static-top">
            <div class="container">
                <div class="navbar-header">
                    <a href="/" class="navbar-brand"><b>Short</b>&nbsp;URL</a>
                    <button type="button"
                            class="navbar-toggle collapsed"
                            data-toggle="collapse"
                            data-target="#navbar-collapse">
                        <i class="fa fa-bars"></i>
                    </button>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li><a href="/">Home</a></li>
                        @if(Session::get('user') != null)
                            <li>
                                <a href="/list">
                                    My URL Shortener
                                </a>
                            </li>
                            <li>
                                <a href="#" data-toggle="modal" data-target="#change-password-modal">
                                    Change Password
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        @if(Session::get('user') == null)
                            <li>
                                <a href="#" data-toggle="modal" data-target="#sign-in-modal">
                                    <span>Sign In</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" data-toggle="modal" data-target="#register-modal">
                                    <span>Register</span>
                                </a>
                            </li>
                        @else
                            <li>
                                <a href="#" class="logout-button">
                                    <span>Sign Out</span>
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
            <!-- /.container-fluid -->
        </nav>
    </header>
    <!-- Full Width Column -->
    <div class="content-wrapper">
        <div class="container">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    @yield('title')
                    <small>@yield('subtitle')</small>
                    <div class="pull-right">
                        @yield('top-button')
                    </div>
                </h1>
            </section>

            <!-- Main content -->
            <section class="content">
                @yield('content')
            </section>
            <!-- /.content -->
        </div>
        <!-- /.container -->
    </div>
    <!-- /.content-wrapper -->

    <footer class="main-footer">
        <div class="container">
            <div class="pull-right hidden-xs">
                <b>Version</b> 1.0.0
            </div>
            Copyright &copy; @php echo date('Y'); @endphp <b>Short</b>&nbsp;URL. All rights reserved.
        </div>
        <!-- /.container -->
    </footer>
</div>
<!-- ./wrapper -->

@if(Session::get('user') == null)
    {{-- Forgot Password Modal --}}
    <div class="modal fade" id="forgot-password-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="/" method="post" id="forgot-password-modal-form">
                    <div class="modal-header">
                        <h4 class="modal-title">Forgot Password</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" placeholder="Insert your email"
                                   id="forgot-password-modal-form-field-email">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-spinner fa-spin" id="forgot-password-modal-save-loading-indicator"></i>
                            <span id="forgot-password-modal-save-button-label">Sign In</span>
                        </button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    {{-- Sign In Modal --}}
    <div class="modal fade" id="sign-in-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="/" method="post" id="sign-in-modal-form">
                    <div class="modal-header">
                        <h4 class="modal-title">Sign In</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" placeholder="Insert your email"
                                   id="sign-in-modal-form-field-email">
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" class="form-control" placeholder="Insert your new password"
                                   id="sign-in-modal-form-field-password">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger pull-left"
                                id="sign-in-modal-button-forgot-password">Forgot Password
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-spinner fa-spin" id="sign-in-modal-save-loading-indicator"></i>
                            <span id="sign-in-modal-save-button-label">Sign In</span>
                        </button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    {{-- Register Modal --}}
    <div class="modal fade" id="register-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="/" method="post" id="register-modal-form">
                    <div class="modal-header">
                        <h4 class="modal-title">Register</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" placeholder="Insert your name"
                                   id="register-modal-form-field-name">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" placeholder="Insert your email"
                                   id="register-modal-form-field-email">
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" class="form-control" placeholder="Insert your new password"
                                   id="register-modal-form-field-password">
                        </div>
                        <div class="form-group">
                            <label>Confirm Password</label>
                            <input type="password" class="form-control" placeholder="Please confirm new password"
                                   id="register-modal-form-password-confirm">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-spinner fa-spin" id="register-modal-save-loading-indicator"></i>
                            <span id="register-modal-save-button-label">Register</span>
                        </button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
@else
    {{-- Change Password Modal --}}
    <div class="modal fade" id="change-password-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="/" method="post" id="change-password-modal-form">
                    <div class="modal-header">
                        <h4 class="modal-title">Change Password</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>New Password</label>
                            <input type="password" class="form-control" placeholder="Insert your new password"
                                   id="change-password-modal-form-field-password">
                        </div>
                        <div class="form-group">
                            <label>Confirm Password</label>
                            <input type="password" class="form-control" placeholder="Please confirm new password"
                                   id="change-password-modal-form-field-password-confirm">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-spinner fa-spin" id="change-password-modal-save-loading-indicator"></i>
                            <span id="change-password-modal-save-button-label">Save</span>
                        </button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
@endif

<!-- jQuery 3 -->
<script src="{{asset('vendor/jquery/dist/jquery.min.js')}}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{asset('vendor/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<!-- SlimScroll -->
<script src="{{asset('vendor/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
<!-- FastClick -->
<script src="{{asset('vendor/fastclick/lib/fastclick.js')}}"></script>
<!-- Sweet Alert -->
<script src="{{asset('vendor/sweetalert/sweetalert.min.js')}}"></script>
<!-- Toastr -->
<script src="{{asset('vendor/toastr/toastr.min.js')}}"></script>
<!-- Bootstrap Datepicker -->
<script src="{{asset('vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
<!-- iCheck 1.0.1 -->
<script src="{{asset('plugin/iCheck/icheck.min.js')}}"></script>
<!-- Clipboard -->
<script src="{{asset('vendor/clipboard.js/dist/clipboard.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('dist/js/adminlte.min.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{asset('dist/js/demo.js')}}"></script>

<script type="application/javascript">
    $(document).ready(function () {
        @if(Session::get('user') == null)
        $("#forgot-password-modal-save-loading-indicator").hide();
        $("#sign-in-modal-save-loading-indicator").hide();
        $("#register-modal-save-loading-indicator").hide();

        $("#sign-in-modal-button-forgot-password").click(function () {
            $("#sign-in-modal").modal('hide');
            $("#forgot-password-modal").modal('show');
        });

        $("#forgot-password-modal-form").on("submit", function (e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "/web/forgot",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                data: JSON.stringify({
                    "email": $("#forgot-password-modal-form-field-email").val(),
                }),
                contentType: "application/json",
                dataType: "json",
                async: true,
                beforeSend: function () {
                    $("#forgot-password-modal-save-loading-indicator").show();
                    $("#forgot-password-modal-save-button-label").hide();
                },
                success: function (result) {
                    $("#forgot-password-modal").modal('hide');
                    toastr.success(result.message);
                },
                error: function (result) {
                    toastr.error(result.responseJSON.message);
                },
                complete: function () {
                    $("#forgot-password-modal-save-loading-indicator").hide();
                    $("#forgot-password-modal-save-button-label").show();
                }
            });
        });
        $("#sign-in-modal-form").on("submit", function (e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "/web/login",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                data: JSON.stringify({
                    "email": $("#sign-in-modal-form-field-email").val(),
                    "password": $("#sign-in-modal-form-field-password").val()
                }),
                contentType: "application/json",
                dataType: "json",
                async: true,
                beforeSend: function () {
                    $("#sign-in-modal-save-loading-indicator").show();
                    $("#sign-in-modal-save-button-label").hide();
                },
                success: function (result) {
                    toastr.success(result.message);
                    $("#sign-in-modal-save-loading-indicator").hide();
                    $("#sign-in-modal-save-button-label").hide();
                    window.setTimeout(function () {
                        location.reload();
                    }, 500);
                },
                error: function (result) {
                    toastr.error(result.responseJSON.message);
                },
                complete: function () {
                    $("#sign-in-modal-save-loading-indicator").hide();
                    $("#sign-in-modal-save-button-label").show();
                }
            });
        });
        $("#register-modal-form").on("submit", function (e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "/web/register",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                data: JSON.stringify({
                    "email": $("#register-modal-form-field-email").val(),
                    "password": $("#register-modal-form-field-password").val(),
                    "name": $("#register-modal-form-field-password").val(),
                    "password_confirm": $("#register-modal-form-password-confirm").val(),
                }),
                contentType: "application/json",
                dataType: "json",
                async: true,
                beforeSend: function () {
                    $("#register-modal-save-loading-indicator").show();
                    $("#register-modal-save-button-label").hide();
                },
                success: function (result) {
                    toastr.success(result.message);
                },
                error: function (result) {
                    toastr.error(result.responseJSON.message);
                },
                complete: function () {
                    $("#register-modal-save-loading-indicator").hide();
                    $("#register-modal-save-button-label").show();
                    $("#register-modal").modal('hide');
                }
            });
        });
        @else
        $("#change-password-modal-save-loading-indicator").hide();
        $(".logout-button").on('click', function () {
            swal({
                title: "Do you want to sign out ?",
                buttons: ["No", "Yes"],
                dangerMode: true,
            }).then((logout) => {
                if (logout) {
                    location.href = "/web/logout";
                }
            });
        });
        $("#change-password-modal-form").on("submit", function (e) {
            e.preventDefault();

            const password = $("#change-password-modal-form-field-password");
            const passwordConfirm = $("#change-password-modal-form-field-password-confirm");

            $.ajax({
                type: "POST",
                url: "/web/change/password",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                data: JSON.stringify({
                    "email": "{{ Session::get('email') }}",
                    "password": password.val(),
                    "password_confirm": passwordConfirm.val(),
                }),
                contentType: "application/json",
                dataType: "json",
                async: true,
                beforeSend: function () {
                    $("#change-password-modal-save-loading-indicator").show();
                    $("#change-password-modal-save-button-label").hide();
                },
                success: function (result) {
                    password.val(null);
                    passwordConfirm.val(null);

                    toastr.success(result.message);

                    $("#change-password-modal").modal('hide');
                },
                error: function (result) {
                    toastr.error(result.responseJSON.message);
                },
                complete: function () {
                    $("#change-password-modal-save-loading-indicator").hide();
                    $("#change-password-modal-save-button-label").show();
                }
            });
        });
        @endif
    });
</script>

@yield('js')

</body>
</html>
