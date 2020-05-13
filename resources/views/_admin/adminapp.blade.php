<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ get_buzzy_config('sitename') }} | {{ trans('admin.adminpanel') }}</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/adminlte/bootstrap/css/bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/adminlte/dist/css/AdminLTE.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/adminlte/dist/css/skins/_all-skins.min.css') }}">

    <!-- sweetalert -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/adminlte/plugins/sweetalert/sweetalert.css') }}">

    @yield('header')

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <style>
        .material-icons{
            vertical-align: middle;
            font-size:15px;
            margin-right: 10px;
        }
    </style>
    <script>
        var buzzy_item_id ="{{ config('buzzy.item_id') }}";
        var buzzy_base_url ="{{ url('/') }}";
        var buzzy_current_url ="{{ url()->current() }}";
    </script>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

        @include('_admin.layout.header')

    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        @include('_admin._particles.sidebar')
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        @include('_admin._particles.update-alert')
        @include('errors.error')
        @yield("content")

    </div><!-- /.content-wrapper -->

    @include('_admin.layout.footer')

</div><!-- ./wrapper -->

<!-- jQuery 2.1.4 -->
<script src="{{ asset('assets/plugins/adminlte/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('assets/plugins/adminlte/plugins/jQueryUI/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.5 -->
<script src="{{ asset('assets/plugins/adminlte/bootstrap/js/bootstrap.min.js') }}"></script>
<!-- SlimScroll 1.3.0 -->
<script src="{{ asset('assets/plugins/adminlte/plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>

<!-- sweetalert -->
<script src="{{ asset('assets/plugins/adminlte/plugins/sweetalert/sweetalert.min.js') }}"></script>

<!-- AdminLTE App -->
<script src="{{ asset('assets/plugins/adminlte/dist/js/adminlte.min.js') }}"></script>

@yield('footer_js')

<script src="{{ asset('assets/admin/js/app.js') }}"></script>

@yield('footer')
@if(!$updates)
<script>
    $(document).ready(function() {
        var buzzy_item_id ="{{ config('buzzy.item_id') }}";
        $(window).trigger('activate:toggle');
    });
</script>
@endif
<div class="hide">
    <input name="_requesttoken" id="requesttoken" type="hidden" value="{{ csrf_token() }}" />
</div>

@include('.errors.swalerror')

</body>
</html>
